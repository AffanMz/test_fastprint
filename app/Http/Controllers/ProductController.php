<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $data['products'] = Product::orderBy('created_at', 'desc')->get();
        $data['categories'] = Category::orderBy('created_at', 'desc')->get();
        $data['statuses'] = Status::all();
        return view('product', $data);
    }
    
    public function collectProductEdit($id)
    {
        $findProduct = Product::where('id_produk', $id)->first();
        if ($findProduct) {
            return response()->json(['success' => 'Data berhasil didapatkan', 'data' => $findProduct, 'id' => $id]);
        } else {
            return response()->json(['error' => 'Data gagal didapatkan', 'id' => $id]);
        }
    }

    public function collectProductItem(){
        $url = 'https://recruitment.fastprint.co.id/tes/api_tes_programmer';
        $username = 'tesprogrammer140125C20';
        $day = now()->format('d-m-y');
        $password = md5('bisacoding-'.$day);

        // FUNCTION MEMBUAT KONEKSI KE API
        $collectData = function ($username) use ($url, $password){
            return Http::asForm()->post($url, [
                'username' => $username,
                'password' => $password,
            ]);
        };

        try {
            // TEST KONEKSI API PERTAMA
            $respons = $collectData($username);
            $data_produk = $respons->json();
            if (isset($data_produk['error']) && $data_produk['error'] == 1) {
                // MENGAMBIL USERNAME BARU DARI HEADER
                $newUsername = $respons->header('X-Credentials-Username');
                if ($newUsername) {
                    // TEST KONEKSI API KEDUA
                    $respons = $collectData(explode(' ',$newUsername)[0]);
                    $data_produk = $respons->json();
                    if (isset($data_produk['error']) && $data_produk['error'] == 1) {
                        return redirect()->back()->with(['error' => 'Update data gagal, kesalahan tidak ditemukan HUBUNGI ADMIN']);
                    }
                }
            }

            // FEACT DATA YANG DIDAPAT DARI API BERDASARKAN NAMA PRODUK
            foreach ($data_produk['data'] as $produk) {
                $selection_product = Product::where('nama_produk', Str::upper($produk['nama_produk']))->first();
                $selection_category = Category::where('nama_kategori', Str::upper($produk['kategori']))->first();
                $selection_status = Status::where('nama_status', Str::upper($produk['status']))->first();
    
                $info_category = $selection_category ? $selection_category->id_kategori : Category::create(['nama_kategori' => Str::upper($produk['kategori'])])->id_kategori;
                $info_status = $selection_status ? $selection_status->id_status : Status::create(['nama_status' => Str::upper($produk['status'])])->id_status;
                
                if ($selection_product) {
                    $selection_product->update([
                        'nama_produk' => Str::upper($produk['nama_produk']),
                        'harga' => $produk['harga'],
                        'id_kategori' => $info_category,
                        'id_status' => $info_status,
                    ]);
                } else {
                    Product::create([
                        'id_produk' => $produk['id_produk'],
                        'nama_produk' => Str::upper($produk['nama_produk']),
                        'harga' => $produk['harga'],
                        'id_kategori' => $info_category,
                        'id_status' => $info_status,
                    ]);
                }
            }

            return redirect()->route('view.product')->with(['success' => 'Data berhasil dipeprbarui']);

        } catch (\Throwable $th) {
            return redirect()->back()->with(['error' => 'Update data gagal, kesalahan tidak ditemukan HUBUNGI ADMIN', 'details' => $th->getMessage(),
            ]);
        }

    }

    public function deleteProduct(Request $request)
    {
        $request->validate([
            'id_produk' => 'numeric|min:1'
        ], [
            'id_produk.required' => 'ID Produk tidak ditemukan.',
        ]);
        try {
            $findProduct = Product::where('id_produk', $request->id_produk)->firstOrFail();
            $findProduct->delete();
            return redirect()->back()->with(['success' => 'Produk berhasil dihapus']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with(['error' => 'Produk tidak ditemukan '.$e->getMessage()]);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error' => 'Produk gagal dihapus '.$th->getMessage()]);
        }
    }

    public function createProduct(Request $request)
    {
        try {
            $request->validate([
                'product_name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'category' => 'required|string',
                'status' => 'required|string',
            ], [
                'product_name.required' => 'Nama produk wajib diisi.',
                'price.required' => 'Harga produk wajib diisi.',
                'price.numeric' => 'Harga produk harus berupa angka.',
                'price.min' => 'Harga produk tidak boleh kurang dari 0.',
                'category.required' => 'Kategori produk wajib diisi.',
                'status.required' => 'Status produk wajib diisi.',
            ]);

            $findProduct = Product::where(['nama_produk' => Str::upper($request['product_name'])])->first();

            if ($findProduct) {
                return redirect()->route('view.product')->with(['error' => 'Data sudah ada']);
            } else {
                Product::create([
                    'nama_produk' => Str::upper($request['product_name']),
                    'harga' => $request['price'],
                    'id_kategori' => $request['category'],
                    'id_status' => $request['status'],
                ]);
            }
            
            return redirect()->route('view.product')->with(['success' => 'Data berhasil ditambahkan']);

        } catch (\Exception $e) {
            return redirect()->route('view.product')->with(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function editProduct(Request $request)
    {
        try {
            $request->validate([
                'id_produk' => 'required|numeric|min:1',
                'product_name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'category' => 'required|string',
                'status' => 'required|string',
            ], [
                'product_name.required' => 'Nama produk wajib diisi.',
                'price.required' => 'Harga produk wajib diisi.',
                'price.numeric' => 'Harga produk harus berupa angka.',
                'price.min' => 'Harga produk tidak boleh kurang dari 0.',
                'category.required' => 'Kategori produk wajib diisi.',
                'status.required' => 'Status produk wajib diisi.',
            ]);

            $findProduct = Product::where(['nama_produk' => Str::upper($request->product_name)])->first();
            $findProductId = Product::where(['id_produk' => $request->id_produk])->first();

            if ($findProductId) {
                if ($findProduct) {
                    return redirect()->route('view.product')->with(['error' => 'Produk sudah ada']);
                } else {
                    $findProductId->update([
                        'nama_produk' => Str::upper($request->product_name),
                        'harga' => $request->price,
                        'id_kategori' => $request->category,
                        'id_status' => $request->status,
                    ]);
                    return redirect()->route('view.product')->with(['success' => 'Data berhasil diperbarui']);
                }
            } else {
                return redirect()->route('view.product')->with(['error' => 'Produk Tidak Ditemukan']);
            }

        } catch (\Exception $e) {
            return redirect()->route('view.product')->with(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    
}
