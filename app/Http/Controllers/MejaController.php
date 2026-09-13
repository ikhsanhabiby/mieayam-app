<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meja;

class MejaController extends Controller
{
    public function index(){
        $mejas = Meja::orderBy('nomor_meja', 'asc')->get();
        return view('admin.meja.index', compact('mejas'));
    }

    public function store(Request $request){
        $meja = new Meja();
        $meja->nomor_meja = $request->nomor_meja;
        $meja->save();
        return back()->with('success', 'Meja berhasil ditambahkan!');
    }

    public function destroy($id){
        Meja::find($id)->delete();
        return back()->with('success', 'Meja berhasil dihapus!');
    }

    public function cetakQr(){
        $mejas = Meja::orderBy('nomor_meja','asc')->get();
        return view('admin.cetak-qr', compact('mejas'));
    }
}
