<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    
    public function collectCategoryEdit($id)
    {
        $findCategory = Category::where('id_kategori', $id)->first();
        if ($findCategory) {
            return response()->json(['success' => 'Data berhasil didapatkan', 'data' => $findCategory, 'id' => $id]);
        } else {
            return response()->json(['error' => 'Data gagal didapatkan', 'id' => $id]);
        }
    }

    public function deleteCategory(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|numeric|min:1'
        ], [
            'id_kategori.required' => 'ID Kategori tidak ditemukan.',
        ]);

        try {
            $findCategory = Category::where('id_kategori', $request->id_kategori)->firstOrFail();
            $findCategory->delete();
            return redirect()->back()->with(['success-cat' => 'Kategori berhasil dihapus', 'tabs' => 'category']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with(['error-cat' => 'Kategori tidak ditemukan '.$e->getMessage(), 'tabs' => 'category']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error-cat' => 'Kategori gagal dihapus '.$th->getMessage(), 'tabs' => 'category']);
        }
    }

    public function createCategory(Request $request)
    {
        try {
            $request->validate([
                'category_name' => 'required|string|max:255',
            ], [
                'category_name.required' => 'Nama kategori wajib diisi.',
            ]);

            $findCategory = Category::where(['nama_kategori' => Str::upper($request['category_name'])])->first();

            if ($findCategory) {
                return redirect()->back()->with(['error-cat' => 'Kategori sudah ada', 'tabs' => 'category']);
            } else {
                Category::create([
                    'nama_kategori' => Str::upper($request['category_name']),
                ]);
            }
            
            return redirect()->back()->with(['success-cat' => 'Kategori berhasil ditambahkan', 'tabs' => 'category']);

        } catch (\Exception $e) {
            return redirect()->back()->with(['error-cat' => 'Terjadi kesalahan: ' . $e->getMessage(), 'tabs' => 'category']);
        }
    }

    public function editCategory(Request $request)
    {
        try {
            $request->validate([
                'category_name' => 'required|string|max:255',
            ], [
                'category_name.required' => 'Nama kategori wajib diisi.',
            ]);

            $findCategory = Category::where(['nama_kategori' => Str::upper($request->category_name)])->first();
            $findCategoryId = Category::where(['id_kategori' => $request->id_kategori])->first();

            if ($findCategoryId) {
                if ($findCategory) {
                    return redirect()->back()->with(['error-cat' => 'Kategori sudah ada', 'tabs' => 'category']);
                } else {
                    $findCategoryId->update([
                        'nama_kategori' => Str::upper($request->category_name),
                    ]);
                    return redirect()->back()->with(['success-cat' => 'Kategori berhasil diperbarui', 'tabs' => 'category']);
                }
            } else {
                return redirect()->back()->with(['error-cat' => 'Kategori Tidak Ditemukan', 'tabs' => 'category']);
            }

        } catch (\Exception $e) {
            return redirect()->back()->with(['error-cat' => 'Terjadi kesalahan: ' . $e->getMessage(), 'tabs' => 'category']);
        }
    }

    
}
