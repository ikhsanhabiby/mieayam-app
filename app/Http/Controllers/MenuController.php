<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\File;

class MenuController extends Controller
{
    // Tampilkan daftar menu & form tambah
    public function index() {
        $menus = Menu::all();
        return view('admin.menu.index', compact('menus'));
    }

    // Simpan menu baru
    public function store(Request $request) {
        $menu = new Menu();
        $menu->nama_menu = $request->nama_menu;
        $menu->harga = $request->harga;
        $menu->stok = $request->stok;

        if($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $nama_gambar = time() . "_" . $gambar->getClientOriginalName();
            $gambar->move(public_path('gambar_menu'), $nama_gambar);
            $menu->gambar = $nama_gambar;
        }
        $menu->save();
        return back()->with('success', 'Menu berhasil ditambahkan!');
    }

    // Halaman Edit Menu
    public function edit($id) {
        $menu = Menu::find($id);
        return view('admin.menu.edit', compact('menu'));
    }

    // Update menu
    public function update(Request $request, $id) {
        $menu = Menu::find($id);
        $menu->nama_menu = $request->nama_menu;
        $menu->harga = $request->harga;
        $menu->stok = $request->stok;

        if($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if(File::exists(public_path('gambar_menu/'.$menu->gambar))) {
                File::delete(public_path('gambar_menu/'.$menu->gambar));
            }
            // Upload gambar baru
            $gambar = $request->file('gambar');
            $nama_gambar = time() . "_" . $gambar->getClientOriginalName();
            $gambar->move(public_path('gambar_menu'), $nama_gambar);
            $menu->gambar = $nama_gambar;
        }
        $menu->save();
        return redirect('/admin/menu')->with('success', 'Menu berhasil diupdate!');
    }

    // Hapus menu
    public function destroy($id) {
        $menu = Menu::find($id);
        if(File::exists(public_path('gambar_menu/'.$menu->gambar))) {
            File::delete(public_path('gambar_menu/'.$menu->gambar));
        }
        $menu->delete();
        return back()->with('success', 'Menu berhasil dihapus!');
    }
}