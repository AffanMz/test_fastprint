<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    
    public function collectStatusEdit($id)
    {
        $findStatus = Status::where('id_status', $id)->first();
        if ($findStatus) {
            return response()->json(['success' => 'Data berhasil didapatkan', 'data' => $findStatus, 'id' => $id]);
        } else {
            return response()->json(['error' => 'Data gagal didapatkan', 'id' => $id]);
        }
    }

    public function deleteStatus(Request $request)
    {
        $request->validate([
            'id_status' => 'required|numeric|min:1'
        ], [
            'id_status.required' => 'ID Status tidak ditemukan.',
        ]);

        try {
            $findStatus = Status::where('id_status', $request->id_status)->firstOrFail();
            $findStatus->delete();
            return redirect()->back()->with(['success-sta' => 'Kategori berhasil dihapus', 'tabs' => 'status']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with(['error-sta' => 'Kategori tidak ditemukan '.$e->getMessage(), 'tabs' => 'status']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error-sta' => 'Kategori gagal dihapus '.$th->getMessage(), 'tabs' => 'status']);
        }
    }

    public function createStatus(Request $request)
    {
        try {
            $request->validate([
                'status_name' => 'required|string|max:255',
            ], [
                'status_name.required' => 'Nama Status wajib diisi.',
            ]);

            $findStatus = Status::where(['nama_status' => Str::upper($request['status_name'])])->first();

            if ($findStatus) {
                return redirect()->back()->with(['error-sta' => 'Status sudah ada', 'tabs' => 'status']);
            } else {
                Status::create([
                    'nama_status' => Str::upper($request['status_name']),
                ]);
            }
            
            return redirect()->back()->with(['success-sta' => 'Status berhasil ditambahkan', 'tabs' => 'status']);

        } catch (\Exception $e) {
            return redirect()->back()->with(['error-sta' => 'Terjadi kesalahan: ' . $e->getMessage(), 'tabs' => 'status']);
        }
    }

    public function editStatus(Request $request)
    {
        try {
            $request->validate([
                'status_name' => 'required|string|max:255',
            ], [
                'status_name.required' => 'Nama status wajib diisi.',
            ]);

            $findStatus = Status::where(['nama_status' => Str::upper($request->status_name)])->first();
            $findStatusId = Status::where(['id_status' => $request->id_status])->first();

            if ($findStatusId) {
                if ($findStatus) {
                    return redirect()->back()->with(['error-sta' => 'Status sudah ada', 'tabs' => 'status']);
                } else {
                    $findStatusId->update([
                        'nama_status' => Str::upper($request->status_name),
                    ]);
                    return redirect()->back()->with(['success-sta' => 'Status berhasil diperbarui', 'tabs' => 'status']);
                }
            } else {
                return redirect()->back()->with(['error-sta' => 'Status Tidak Ditemukan', 'tabs' => 'status']);
            }

        } catch (\Exception $e) {
            return redirect()->back()->with(['error-sta' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    
}
