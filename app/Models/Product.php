<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    public function __construct()
    {
        $this->middelware('auth:sanctum')->except('index', 'store');
    }
    protected $table = 'products';
    protected $fillable = [
        'store_id', 'category_id', 'name', 'slug', 'description', 'image',
        'price', 'compare_price', 'options', 'rating', 'featured', 'status'
    ];
    protected $hidden = ['image', 'created_at', 'updated_at', 'deleted_at'];
    protected $appends = ['image_url'];
    protected static function booted()
    {
        static::addGlobalScope(new StoreScope);
        static::creating(function (Product $product) {
            $product->slug = Str::slug($product->name);
        });
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,     // Related Model
            'product_tag', //  Pivot Table Name
            'product_id', //   FK In Pivot Table For Current Model
            'tag_id',    //    FK In Pivot Table For Related Model
            'id',       //     PK For Current Model
            'id'       //      PK For Related Model
        );
    }
    public function scopeActive(Builder $builder) // Local Scope
    {
        $builder->where('status', 'active');
    }
    //Accessor {function get....Attribute()}
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://www.incathlab.com/images/products/default_product.png';
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }
    //Accessor {function get....Attribute()}
    public function getSalePercentAttribute()
    {
        if (!$this->compare_price) {
            return 0;
        }
        return round(100 - (100 * $this->price / $this->compare_price), 1);
    }
    public function scopeFilter(Builder $builder, $filters)
    {
        $options = array_merge([
            'store_id' => null,
            'category_id' => null,
            'tag_id' => null,
            'status' => 'active',
        ], $filters);
        $builder->when($options['status'], function ($builder, $value) {
            $builder->where('status', $value);
        });
        $builder->when($options['store_id'], function ($builder, $value) {
            $builder->where('store_id', $value);
        });
        $builder->when($options['category_id'], function ($builder, $value) {
            $builder->where('category_id', $value);
        });
        $builder->when($options['tag_id'], function ($builder, $value) {
            $builder->whereExists(function ($query) use ($value) {
                $query->select(1)
                    ->from('product_tag')
                    ->whereRaw('product_id = Products.id')
                    ->where('tag_id', $value);
            });
            // $builder->selectRaw('EXISTS(SELECT 1 from product_tag WHERE tag_id = ?)',[$value]);

            // $builder->selectRaw('id IN (SELECT product_id from product_tag WHERE tag_id = ? AND product_id = Products.id)',[$value]);

            // $builder->whereHas('tags', function ($builder) use ($value) {
            //     $builder->where('id', $value); });
        });
    }
}
