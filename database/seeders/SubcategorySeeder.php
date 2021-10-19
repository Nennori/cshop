<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::first();
        $subcategory = Subcategory::firstOrNew(['name' => 'Агар-агар']);
        if (!$subcategory->exists) {
            $subcategory->category()->associate($category);
            $subcategory->save();
        }
        $subcategory = Subcategory::firstOrNew(['name' => 'Айсинг']);
        if (!$subcategory->exists) {
            $subcategory->category()->associate($category);
            $subcategory->save();
        }
        $subcategory = Subcategory::firstOrNew(['name' => 'Вафельные рожки']);
        if (!$subcategory->exists) {
            $subcategory->category()->associate($category);
            $subcategory->save();
        }
        $subcategory = Subcategory::firstOrNew(['name' => 'Взрывная карамель']);
        if (!$subcategory->exists) {
            $subcategory->category()->associate($category);
            $subcategory->save();
        }
        $subcategory = Subcategory::firstOrNew(['name' => 'Глазурь кондитерская']);
        if (!$subcategory->exists) {
            $subcategory->category()->associate($category);
            $subcategory->save();
        }
        $subcategory = Subcategory::firstOrNew(['name' => 'Какао']);
        if (!$subcategory->exists) {
            $subcategory->category()->associate($category);
            $subcategory->save();
        }
    }
}
