@extends('admin.layout')

@section('title', 'Edit Menu: ' . $menu->nama_menu)

@section('content')
    <div class="max-w-2xl mx-auto">
        
        <!-- BACK BUTTON & TITLE -->
        <div class="flex items-center gap-3 mb-6">
            <a 
                href="/admin/menu" 
                class="w-10 h-10 rounded-2xl bg-white border border-slate-200 hover:bg-slate-50 flex items-center justify-center text-slate-700 transition active:scale-95 shadow-xs"
                title="Batal & Kembali"
            >
                <span class="material-icons-round text-xl">arrow_back</span>
            </a>
            <div>
                <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Edit Menu: {{ $menu->nama_menu }}</h1>
                <p class="text-xs text-slate-500">Perbarui informasi harga, stok atau foto menu ini.</p>
            </div>
        </div>

        <!-- FORM CARD -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
            
            <form action="/admin/menu/update/{{ $menu->id }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nama Menu
                    </label>
                    <input 
                        type="text" 
                        name="nama_menu" 
                        value="{{ old('nama_menu', $menu->nama_menu) }}"
                        required 
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-400/20 rounded-xl px-4 py-3 text-xs text-slate-900 outline-none transition-all font-semibold"
                    >
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Harga (Rp)
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-extrabold text-slate-400">Rp</span>
                            <input 
                                type="number" 
                                name="harga" 
                                value="{{ old('harga', $menu->harga) }}"
                                required 
                                min="0"
                                class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-400/20 rounded-xl pl-10 pr-4 py-3 text-xs text-slate-900 outline-none transition-all font-semibold"
                            >
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Stok Porsi
                        </label>
                        <input 
                            type="number" 
                            name="stok" 
                            value="{{ old('stok', $menu->stok) }}"
                            required 
                            min="0"
                            class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-400/20 rounded-xl px-4 py-3 text-xs text-slate-900 outline-none transition-all font-semibold"
                        >
                    </div>
                </div>

                <!-- Foto Menu Saat Ini & Ganti Foto -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Foto Makanan
                    </label>

                    <div class="flex flex-col sm:flex-row items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-200/80">
                        <div class="w-24 h-24 rounded-2xl bg-white border border-slate-200 overflow-hidden shrink-0">
                            @if($menu->gambar)
                                <img id="currentImg" src="{{ asset('gambar_menu/'.$menu->gambar) }}" alt="{{ $menu->nama_menu }}" class="w-full h-full object-cover">
                            @else
                                <div id="noImg" class="w-full h-full flex items-center justify-center text-slate-400">
                                    <span class="material-icons-round text-2xl">restaurant</span>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 text-center sm:text-left">
                            <span class="text-xs font-bold text-slate-700 block">Ganti Foto Menu</span>
                            <span class="text-[11px] text-slate-400 block mb-2">Kosongkan jika tidak ingin mengubah foto</span>
                            
                            <input 
                                type="file" 
                                name="gambar" 
                                accept="image/*"
                                onchange="previewEditImage(this)"
                                class="text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white hover:file:bg-brand-600 file:cursor-pointer cursor-pointer"
                            >
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex items-center gap-3">
                    <a 
                        href="/admin/menu" 
                        class="w-1/3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-3 rounded-xl transition text-center"
                    >
                        Batal
                    </a>
                    <button 
                        type="submit" 
                        class="w-2/3 bg-slate-900 hover:bg-brand-600 active:scale-95 text-white font-extrabold text-xs py-3 rounded-xl shadow-md transition-all duration-200 flex items-center justify-center gap-2"
                    >
                        <span class="material-icons-round text-base">save</span>
                        <span>Perbarui Data Menu</span>
                    </button>
                </div>
            </form>

        </div>

    </div>
@endsection

@section('scripts')
<script>
    function previewEditImage(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                let currentImg = document.getElementById('currentImg');
                let noImg = document.getElementById('noImg');
                if(currentImg) {
                    currentImg.src = e.target.result;
                } else if(noImg) {
                    noImg.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection