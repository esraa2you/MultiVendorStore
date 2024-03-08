<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categoriesrequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $request = request();
        // $query = Category::query();
        //SELECT categories.*,parent.name as parent_name FROM categories LEFTJOIN categories as parent
        //ON parent.id = categories.parent_id
        $categories = Category::with('parent')
            ->withCount(['products as products_number' => function ($builder) {
                $builder->where('status', '=', 'active');
            }])
            // ->select('categories.*')
            // ->selectRaw('(SELECT COUNT(*)FROM products WHERE category_id=categories.id AND status='active')as product_count')
            //=>withCount('products')
            // leftJoin('categories as parent', 'parent.id', '=', 'categories.parent_id')
            //     ->select(['categories.*', 'parent.name as parent_name'])=>with('parents')
            ->orderby('categories.name')
            ->filter($request->query())->paginate(5); // return collection object
        // $categories = Category::active()->paginate(5);
        // dd($request->query());
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $category = new Category();
        $parents = Category::all();
        return view('dashboard.categories.create', compact('category', 'parents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        /**
         * $request->input('name');
         * $request->post('name');
         * $request->query('name');
         * $request->get('name');
         * $request->only(['name','parent_id']);
         * $request->except(['slug']);
         */
        $clean_data = $request->validate(Category::rules(), [
            'name.unique' => 'The Category is Already Exists',
            'required' => 'the field (:attribute) is required '

        ]);
        $request->merge(['slug' => Str::slug($request->post('name'))]);
        //Mass assignment
        $data = $request->except('image');
        // if ($request->hasFile('image')) {
        //     $file = $request->file('image'); //UploadedFile object
        //     $path = $file->store('uploads', [
        //         'disk' => 'public'
        //     ]);
        //     $data['image'] = $path;
        // }
        $data['image'] = $this->uploadImage($request);
        $category = Category::create($data);
        //PRG
        return redirect()->route('dashboard.categories.index')->with(['success' => 'category created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
        return view('dashboard.categories.show', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        try {
            $category = Category::findOrFail($id);
        } catch (Exception $e) {
            return redirect()->route('dashboard.categories.index')->with(['info' => 'category not found!']);
        }
        $parents = Category::where('id', '<>', $id)
            ->where(function ($query) use ($id) {
                $query->WhereNull('parent_id')->orWhere('parent_id', '<>', $id);
            })->get();
        return view('dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Categoriesrequest $request, $id)
    {
        //
        //$request->validate(Category::rules($id));
        $category = Category::findOrFail($id);
        $old_image = $category->image;
        $data = $request->except('image');
        // if ($request->hasFile('image')) {
        //     $file = $request->file('image'); //UploadedFile object
        //     // $file->getClientOriginalName();
        //     // $file->getSize();
        //     // $file->getClientOriginalExtension();
        //     // $file->getClientMimeType();
        //     $path = $file->store('uploads', [
        //         'disk' => 'public'
        //     ]);
        //     $data['image'] = $path;
        // }
        // //  dd($path);

        $new_image = $this->uploadImage($request);
        if ($new_image) {
            $data['image'] = $new_image;
        }
        $category->update($data);

        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }
        return redirect()->route('dashboard.categories.index')->with(['success' => 'category updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        //   Category::destroy($id);
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('dashboard.categories.index')->with(['success' => 'category deleted']);
    }
    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return;
        }
        $file = $request->file('image');
        $path = $file->store('uploads', [
            'disk' => 'public'
        ]);
        return $path;
    }
    public function trash()
    {
        $request = request();
        $categories = Category::onlyTrashed()->filter($request->query())->paginate(3);
        return view('dashboard.categories.trash', compact('categories'));
    }
    public function restore(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('dashboard.categories.trash')->with(['success' => "The Category Is Restore"]);
    }
    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        return redirect()->route('dashboard.categories.trash')->with(['success' => "The Category Is Deleted"]);
    }
}
