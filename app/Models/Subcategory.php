<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public $timestamps = false;

    public static function createSubcategory(Request $request)
    {
        $subcategory = Subcategory::firstOrNew(['name' => $request->get('name')]);
        if(!$subcategory->exists){
            $category = Category::findOrFail($request->get('category_id'));
            $subcategory->category()->associate($category);
            $subcategory->save();
            return $subcategory;
        }
        throw new ModelNotFoundException();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function updateSubcategory(Request $request)
    {
        return $this->update(['name'=>$request->get('name')]);
    }
}
