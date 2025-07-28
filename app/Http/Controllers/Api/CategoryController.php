<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();

        return response()->json([
            'code' => 200,
            'message' => 'Berhasil mendapatkan data kategori',
            'data' => $category
        ]);
    }

    public function show(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'code' => 404,
                'message' => 'Kategori tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Berhasil mendapatkan detail kategori',
            'data' => $category
        ]);
    }
}
