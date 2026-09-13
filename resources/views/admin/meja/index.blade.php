@extends('admin.layout')

@section('title', 'Kelola Meja Pelanggan')

@section('content')
    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Kelola Meja Restoran</h1>
            <p class="text-xs text-slate-500 mt-0.5">Atur nomor meja pelanggan dan tautkan ke kode QR pemesanan.</p>
        </div>
        <div class="flex items-center gap-2">
            <a 
                href="/admin/cetak-qr" 
                class="bg-brand-500 hover:bg-brand-600 text-white font-extrabold text-xs px-4 py-2 rounded-xl shadow-xs transition flex items-center gap-1.5"
            >
                <span class="material-icons-round text-base">qr_code</span>
                <span>Cetak Semua QR Meja</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- FORM TAMBAH MEJA -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl border border-slate-200/80 p-5 sm:p-6 shadow-sm sticky top-24">
                
                <div class="flex items-center gap-2.5 pb-4 mb-5 border-b border-slate-100">
                    <div class="w-9 h-9 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center">
                        <span class="material-icons-round text-xl">table_restaurant</span>
                    </div>
                    <div>
                        <h2 class="font-extrabold text-sm text-slate-900 leading-tight">+ Tambah Meja Baru</h2>
                        <p class="text-[11px] text-slate-400">Daftarkan nomor meja fisik restoran</p>
                    </div>
                </div>

                <form action="/admin/meja/tambah" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nomor Meja
                        </label>
                        <input 
                            type="number" 
                            name="nomor_meja" 
                            required 
                            min="1"
                            placeholder="Contoh: 7"
                            class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-400/20 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 placeholder-slate-400 outline-none transition-all font-bold"
                        >
                    </div>

                    <button 
                        type="submit" 
                        class="w-full bg-slate-900 hover:bg-brand-600 active:scale-95 text-white font-extrabold text-xs py-3 rounded-xl shadow-md transition-all duration-200 flex items-center justify-center gap-2"
                    >
                        <span class="material-icons-round text-base">add</span>
                        <span>Daftarkan Meja</span>
                    </button>
                </form>

            </div>
        </div>

        <!-- DAFTAR MEJA -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
                
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-extrabold text-sm text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-brand-500"></span>
                        <span>Daftar Meja Terdaftar ({{ count($mejas) }})</span>
                    </h3>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">
                                <th class="py-3.5 px-4">Meja</th>
                                <th class="py-3.5 px-4">Link Pemesanan</th>
                                <th class="py-3.5 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs font-semibold">
                            @forelse($mejas as $m)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-2xl bg-brand-50 border border-brand-200 text-brand-800 font-black text-sm flex items-center justify-center shrink-0">
                                                {{ $m->nomor_meja }}
                                            </div>
                                            <div>
                                                <span class="font-extrabold text-slate-900 block">Meja {{ $m->nomor_meja }}</span>
                                                <span class="text-[10px] text-slate-400">ID Database: #{{ $m->id }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <a 
                                            href="/pesan?meja={{ $m->nomor_meja }}" 
                                            target="_blank" 
                                            class="inline-flex items-center gap-1 text-xs text-brand-700 hover:text-brand-800 font-bold hover:underline"
                                        >
                                            <span>/pesan?meja={{ $m->nomor_meja }}</span>
                                            <span class="material-icons-round text-sm">open_in_new</span>
                                        </a>
                                    </td>
                                    <td class="py-3.5 px-4 text-right">
                                        <a 
                                            href="/admin/meja/hapus/{{ $m->id }}" 
                                            onclick="return confirm('Hapus Meja {{ $m->nomor_meja }}?')"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 transition"
                                            title="Hapus Meja"
                                        >
                                            <span class="material-icons-round text-base">delete</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-10 text-center text-slate-400">
                                        <span class="material-icons-round text-4xl block mx-auto mb-2 text-slate-300">table_restaurant</span>
                                        Belum ada nomor meja yang didaftarkan.
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