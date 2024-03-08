<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'parent_id', 'image', 'description', 'status', 'slug'];
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id')->withDefault();
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'active');
    }
    public function scopeFilter(Builder $builder, $filters)
    {

        $builder->when($filters['name'] ?? false, function ($builder, $value) {
            $builder->where('categories.name', 'LIKE', "%{$value}%");
        });
        $builder->when($filters['status'] ?? false, function ($builder, $value) {
            $builder->where('categories.status', '=', $value);
        });
    }
    public static function rules($id = 0)
    {
        return [
            'name' => [
                'required', 'string', 'min:3', 'max:255',
                //"unique:categories,name,$id" => it the same this statement
                Rule::unique('categories', 'name')->ignore($id),
                /**
                 * On of method to define new rule but its not general!!
                 *  function ($attribute, $value, $fails) {
                 * if (strtolower($value)  == 'laravel') {
                 *   $fails('This name for category is forbidden!');
                 *}
                 */
                //We Are create a new class (Filter) from Rule and define the rule we need within it
                // new Filter(['laravel', 'html', 'php']),
                // The Macrous method in AppServiceProviders
                'filter:laravel,php,css'
            ],
            'parent_id' => ['nullable', 'int', 'exists:categories,id'],
            'status' => ['in:active,archived'],
            'image' => ['image', 'max:1048576', 'dimensions:min_width=100,min_height=100']
        ];
    }
}
