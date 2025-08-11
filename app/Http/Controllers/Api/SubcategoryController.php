<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategory = Subcategory::with('category')->get();
        if (env('APP_DEBUG_LOG', false)) {
        Log::debug('DEBUG_LOG: Query Result', $subcategory->toArray());
    }
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

    public function search(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return response()->json([
                'code' => 200,
                'message' => 'Query pencarian kosong.',
                'data' => []
            ]);
        }

        $subcategories = Subcategory::where('name', 'like', "%{$query}%")->get();

        return response()->json([
            'code' => 200,
            'message' => 'Hasil pencarian sub kategori.',
            'data' => $subcategories
        ]);
    }
}
