<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'cost', 'count', 'article'];

    public $timestamps = false;

    public static function createProduct(Request $request)
    {
        $product = new Product($request->only('name', 'description', 'cost', 'count', 'article'));
        $subcategory = Subcategory::findOrFail($request->get('subcategory_id'));
        $product->subcategory()->associate($subcategory);
        $product->save();
        return $product;
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function updateProduct(Request $request)
    {
        $this->update($request->only('name', 'description', 'cost', 'count'));
        return $this;
    }

    public function changeSubcategory($subcategoryId)
    {
        $subcategory = Subcategory::findOrFail($subcategoryId);
        $this->subcategory()->associate($subcategory);
        $this->save();
        return $this;
    }
}
