<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index()
    {
        return response()->json(['data' => Subcategory::all()], 200);
    }

    public function store(Request $request)
    {
        return response()->json(['data' => Subcategory::createSubcategory($request)], 200);
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $subcategory->updateSubcategory($request);
        return response()->json(['data' => $subcategory], 200);
    }

    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();
        return response()->json([], 204);
    }

    public function show(Subcategory $subcategory)
    {
        return response()->json(['data' => $subcategory]);
    }
}
