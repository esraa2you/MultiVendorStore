<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // This Is Constructor
    protected $cart;
    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CartRepository $cart)
    {
        //


        return view('front.cart', [
            'cart' => $cart
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request, CartRepository $cart)
    {
        //
        $request->validate([
            'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity'  => ['nullable', 'int', 'min:1'],
        ]);

        $product = Product::findOrFail($request->post('product_id'));
        $cart->add($product, $request->post('quantity'));
        if ($request->expectsJson()) {
            return response()->json([
                'item' => 'Item Added to cart',
            ], 201);
        }
        return redirect()->route('carts.index')->with('success', 'Product Added To Cart :)');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([

            'quantity'  => ['required', 'int', 'min:1'],
        ]);


        $this->cart->update($id, $request->post('quantity'));
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
        // $repository = new CartModelRepository();
        $this->cart->delete($id);
        return response()->json(['message' => 'Item deleted']);
    }
}
