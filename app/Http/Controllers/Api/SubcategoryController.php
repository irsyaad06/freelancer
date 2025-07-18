<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategory = Subcategory::with('category')->get();

        return response()->json([
            'code' => 200,
            'message' => 'Berhasil mendapatkan data sub kategori',
            'data' => $subcategory
        ]);
    }

    public function show(string $id)
    {
        $subcategory = Subcategory::with('category')->find($id);

        if (!$subcategory) {
            return response()->json([
                'code' => 404,
                'message' => 'Sub kategori tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Berhasil mendapatkan detail sub kategori',
            'data' => $subcategory
        ]);
    }
}
