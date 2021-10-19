<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public $timestamps = false;

    public static function createCategory(Request $request)
    {
        return Category::firstOrCreate(['name' => $request->get('name')]);
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    public function updateCategory(Request $request)
    {
        return $this->update(['name' => $request->get('name')]);
    }
}
