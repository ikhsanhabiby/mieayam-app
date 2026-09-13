@extends('admin.layout')

@section('title', 'Kelola Menu Restoran')

@section('content')
    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Kelola Menu & Harga</h1>
            <p class="text-xs text-slate-500 mt-0.5">Tambah menu baru, perbarui harga, stok, dan foto makanan.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="bg-brand-50 border border-brand-200 text-brand-800 text-xs font-bold px-3 py-1.5 rounded-xl">
                Total {{ count($menus) }} Menu Terdaftar
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- FORM TAMBAH MENU BARU -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl border border-slate-200/80 p-5 sm:p-6 shadow-sm sticky top-24">
                
                <div class="flex items-center gap-2.5 pb-4 mb-5 border-b border-slate-100">
                    <div class="w-9 h-9 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center">
                        <span class="material-icons-round text-xl">add_box</span>
                    </div>
                    <div>
                        <h2 class="font-extrabold text-sm text-slate-900 leading-tight">+ Tambah Menu Baru</h2>
                        <p class="text-[11px] text-slate-400">Masukkan detail menu mie/minuman</p>
                    </div>
                </div>

                <form action="/admin/menu/tambah" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nama Menu
                        </label>
                        <input 
                            type="text" 
                            name="nama_menu" 
                            required 
                            placeholder="Contoh: Mie Ayam Pangsit Baso"
                            class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-400/20 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 placeholder-slate-400 outline-none transition-all font-semibold"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Harga (Rp)
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-extrabold text-slate-400">Rp</span>
                            <input 
                                type="number" 
                                name="harga" 
                                required 
                                min="0"
                                placeholder="15000"
                                class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-400/20 rounded-xl pl-10 pr-3.5 py-2.5 text-xs text-slate-900 placeholder-slate-400 outline-none transition-all font-semibold"
                            >
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Stok Awal
                        </label>
                        <input 
                            type="number" 
                            name="stok" 
                            required 
                            min="0"
                            placeholder="50"
                            class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-400/20 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 placeholder-slate-400 outline-none transition-all font-semibold"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Foto Makanan
                        </label>
                        <div class="border-2 border-dashed border-slate-200 rounded-2xl p-4 text-center hover:border-brand-400 transition cursor-pointer relative bg-slate-50">
                            <input 
                                type="file" 
                                name="gambar" 
                                id="imageInput"
                                accept="image/*"
                                onchange="previewImage(this)"
                                class="absolute inset-0 opacity-0 cursor-pointer w-full h-full"
                            >
                            <div id="previewContainer" class="hidden mb-2">
                                <img id="previewImg" src="#" alt="Preview" class="w-20 h-20 object-cover rounded-xl mx-auto shadow-xs border border-slate-200">
                            </div>
                            <span class="material-icons-round text-slate-400 text-3xl block mx-auto mb-1">cloud_upload</span>
                            <span class="text-xs font-bold text-slate-600 block">Pilih Gambar</span>
                            <span class="text-[10px] text-slate-400 block mt-0.5">Format: JPG, PNG, WEBP</span>
                        </div>
                    </div>

                    <button 
                        type="submit" 
                        class="w-full bg-slate-900 hover:bg-brand-600 active:scale-95 text-white font-extrabold text-xs py-3 rounded-xl shadow-md transition-all duration-200 flex items-center justify-center gap-2"
                    >
                        <span class="material-icons-round text-base">save</span>
                        <span>Simpan Menu</span>
                    </button>
                </form>

            </div>
        </div>

        <!-- DAFTAR MENU TABLE & CARDS -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
                
                <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <h3 class="font-extrabold text-sm text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-brand-500"></span>
                        <span>Daftar Menu Makanan & Minuman</span>
                    </h3>
                    
                    <div class="relative w-full sm:w-64">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <span class="material-icons-round text-sm">search</span>
                        </span>
                        <input 
                            type="text" 
                            id="tableSearch" 
                            oninput="searchAdminMenu()" 
                            placeholder="Cari nama menu..." 
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-8 pr-3 py-1.5 text-xs text-slate-800 placeholder-slate-400 outline-none focus:border-brand-500 transition"
                        >
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="adminMenuTable">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">
                                <th class="py-3.5 px-4">Menu</th>
                                <th class="py-3.5 px-4">Harga</th>
                                <th class="py-3.5 px-4 text-center">Stok</th>
                                <th class="py-3.5 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs font-semibold">
                            @forelse($menus as $m)
                                <tr class="hover:bg-slate-50/60 transition menu-row">
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden shrink-0 border border-slate-200">
                                                @if($m->gambar)
                                                    <img src="{{ asset('gambar_menu/'.$m->gambar) }}" alt="{{ $m->nama_menu }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-slate-400">
                                                        <span class="material-icons-round text-xl">restaurant</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="font-extrabold text-slate-900 block menu-name">{{ $m->nama_menu }}</span>
                                                <span class="text-[10px] text-slate-400">ID: #{{ $m->id }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 font-extrabold text-brand-700">
                                        Rp {{ number_format($m->harga, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        @if($m->stok > 10)
                                            <span class="inline-block bg-emerald-50 text-emerald-700 font-extrabold text-[10px] px-2.5 py-1 rounded-full border border-emerald-200">
                                                {{ $m->stok }} Porsi
                                            </span>
                                        @elseif($m->stok > 0)
                                            <span class="inline-block bg-amber-50 text-amber-700 font-extrabold text-[10px] px-2.5 py-1 rounded-full border border-amber-200">
                                                Sisa {{ $m->stok }}
                                            </span>
                                        @else
                                            <span class="inline-block bg-rose-50 text-rose-700 font-extrabold text-[10px] px-2.5 py-1 rounded-full border border-rose-200">
                                                Habis
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a 
                                                href="/admin/menu/edit/{{ $m->id }}" 
                                                class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-brand-50 text-slate-600 hover:text-brand-700 flex items-center justify-center transition"
                                                title="Edit Menu"
                                            >
                                                <span class="material-icons-round text-base">edit</span>
                                            </a>
                                            <a 
                                                href="/admin/menu/hapus/{{ $m->id }}" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus menu {{ addslashes($m->nama_menu) }}?')"
                                                class="w-8 h-8 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center transition"
                                                title="Hapus Menu"
                                            >
                                                <span class="material-icons-round text-base">delete</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-10 text-center text-slate-400">
                                        <span class="material-icons-round text-4xl block mx-auto mb-2 text-slate-300">inventory_2</span>
                                        Belum ada menu yang ditambahkan. Silakan gunakan form di samping.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
@endsection

@section('scripts')
<script>
    function previewImage(input) {
        let container = document.getElementById('previewContainer');
        let img = document.getElementById('previewImg');
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                container.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function searchAdminMenu() {
        let q = document.getElementById('tableSearch').value.toLowerCase();
        let rows = document.querySelectorAll('.menu-row');
        rows.forEach(row => {
            let name = row.querySelector('.menu-name').innerText.toLowerCase();
            if (name.includes(q)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
@endsection