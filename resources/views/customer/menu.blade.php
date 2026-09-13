<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Mie Ayam Kita - Menu Self-Service</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f',
                            dark: '#1e1b18'
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Poppins', 'sans-serif']
                    }
                }
            }
        }
    </script>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            -webkit-tap-highlight-color: transparent;
        }
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
        .active-pill {
            background-color: #1e1b18 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(30, 27, 24, 0.15);
        }
        @keyframes scaleUp {
            0% { transform: scale(1); }
            50% { transform: scale(1.15); }
            100% { transform: scale(1); }
        }
        .animate-pop {
            animation: scaleUp 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
    </style>
</head>
<body class="text-slate-800 antialiased bg-slate-100 min-h-screen flex justify-center selection:bg-brand-500 selection:text-white">

    <!-- Container Aplikasi Mobile-First (Bisa diakses nyaman di HP, Tablet, Laptop) -->
    <div class="w-full max-w-md bg-white min-h-screen relative shadow-2xl flex flex-col border-x border-slate-200/70">
        
        <!-- TOP APP BAR -->
        <header class="sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-slate-100 px-5 pt-4 pb-3 transition-all">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-brand-600 to-brand-400 flex items-center justify-center text-white shadow-md shadow-brand-500/20">
                        <span class="material-icons-round text-2xl">ramen_dining</span>
                    </div>
                    <div>
                        <h1 class="text-base font-extrabold text-slate-900 tracking-tight leading-tight">Mie Ayam Kita</h1>
                        <p class="text-[11px] font-semibold text-slate-400 flex items-center gap-1">
                            <span>Self-Service Dining</span>
                        </p>
                    </div>
                </div>

                <!-- Badge Meja -->
                <div class="flex items-center gap-1.5 bg-brand-50 border border-brand-200/80 px-3 py-1.5 rounded-full shadow-sm">
                    <span class="material-icons-round text-brand-700 text-sm">table_restaurant</span>
                    <span class="text-xs font-bold text-brand-900">Meja {{ $meja }}</span>
                </div>
            </div>

            <!-- SEARCH BAR -->
            <div class="mt-3 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <span class="material-icons-round text-[19px]">search</span>
                </div>
                <input 
                    type="text" 
                    id="searchInput" 
                    oninput="filterMenu()"
                    placeholder="Cari mie ayam, minuman, camilan..." 
                    class="w-full bg-slate-50 hover:bg-slate-100/80 focus:bg-white text-xs font-semibold text-slate-800 placeholder-slate-400 pl-10 pr-9 py-2.5 rounded-xl border border-slate-200/80 focus:border-brand-500 focus:ring-2 focus:ring-brand-400/20 outline-none transition-all"
                >
                <button 
                    id="clearSearch" 
                    onclick="resetSearch()" 
                    class="hidden absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600"
                >
                    <span class="material-icons-round text-[16px]">cancel</span>
                </button>
            </div>

            <!-- KATEGORI PILLS (Horizontal Scrolling) -->
            <div class="mt-3 flex items-center gap-2 overflow-x-auto hide-scroll pb-0.5" id="categoryContainer">
                <button onclick="setCategory('all', this)" class="category-btn active-pill px-3.5 py-1.5 rounded-full text-xs font-bold whitespace-nowrap bg-slate-100 text-slate-600 hover:bg-slate-200/80 transition-all flex items-center gap-1">
                    <span class="material-icons-round text-sm">grid_view</span>
                    Semua
                </button>
                <button onclick="setCategory('mie', this)" class="category-btn px-3.5 py-1.5 rounded-full text-xs font-bold whitespace-nowrap bg-slate-100 text-slate-600 hover:bg-slate-200/80 transition-all flex items-center gap-1">
                    <span class="material-icons-round text-sm">ramen_dining</span>
                    Mie Ayam
                </button>
                <button onclick="setCategory('minum', this)" class="category-btn px-3.5 py-1.5 rounded-full text-xs font-bold whitespace-nowrap bg-slate-100 text-slate-600 hover:bg-slate-200/80 transition-all flex items-center gap-1">
                    <span class="material-icons-round text-sm">local_drink</span>
                    Minuman
                </button>
                <button onclick="setCategory('camilan', this)" class="category-btn px-3.5 py-1.5 rounded-full text-xs font-bold whitespace-nowrap bg-slate-100 text-slate-600 hover:bg-slate-200/80 transition-all flex items-center gap-1">
                    <span class="material-icons-round text-sm">lunch_dining</span>
                    Camilan
                </button>
                <button onclick="setCategory('paket', this)" class="category-btn px-3.5 py-1.5 rounded-full text-xs font-bold whitespace-nowrap bg-slate-100 text-slate-600 hover:bg-slate-200/80 transition-all flex items-center gap-1">
                    <span class="material-icons-round text-sm">stars</span>
                    Paket Hemat
                </button>
            </div>
        </header>

        <!-- NOTIFIKASI TOAST -->
        <div id="toastNotif" class="fixed top-20 left-1/2 -translate-x-1/2 z-50 bg-slate-900/95 text-white px-4 py-2.5 rounded-2xl shadow-xl shadow-slate-900/20 backdrop-blur-md flex items-center gap-2.5 text-xs font-bold transform -translate-y-12 opacity-0 pointer-events-none transition-all duration-300">
            <span class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center">
                <span class="material-icons-round text-sm">check</span>
            </span>
            <span id="toastMsg">Menu berhasil ditambahkan!</span>
        </div>

        <!-- DAFTAR MENU -->
        <main class="flex-1 px-4 pt-4 pb-32">
            
            <!-- Banner Slogan Resto -->
            <div class="mb-4 bg-gradient-to-br from-brand-500 via-brand-600 to-amber-700 rounded-2xl p-4 text-white relative overflow-hidden shadow-md shadow-brand-600/15">
                <div class="relative z-10">
                    <span class="bg-white/20 backdrop-blur-sm text-[10px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-md text-amber-100">
                        Mie Ayam Otentik
                    </span>
                    <h2 class="text-base font-extrabold mt-1.5 leading-snug">Pesan Langsung dari Meja</h2>
                    <p class="text-[11px] text-amber-100/90 mt-0.5">Pilih menu favoritmu, kami antar hangat ke Meja {{ $meja }}.</p>
                </div>
                <div class="absolute -right-4 -bottom-6 w-24 h-24 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
                <div class="absolute right-3 bottom-2 opacity-25 text-white">
                    <span class="material-icons-round text-6xl">soup_kitchen</span>
                </div>
            </div>

            <!-- Status Jumlah Menu -->
            <div class="flex items-center justify-between mb-3 px-1">
                <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-brand-500"></span>
                    Daftar Menu (<span id="menuCount">{{ count($menus) }}</span>)
                </h3>
                <span class="text-[11px] font-semibold text-slate-400">Pilih & Atur Porsi</span>
            </div>

            <!-- Grid Menu Cards -->
            <div id="menuGrid" class="grid grid-cols-2 gap-3.5">
                @forelse($menus as $m)
                @php
                    $namaLower = strtolower($m->nama_menu);
                    $kategori = 'mie';
                    if(str_contains($namaLower, 'es') || str_contains($namaLower, 'teh') || str_contains($namaLower, 'jus') || str_contains($namaLower, 'kopi') || str_contains($namaLower, 'air') || str_contains($namaLower, 'minum') || str_contains($namaLower, 'lemon')) {
                        $kategori = 'minum';
                    } elseif(str_contains($namaLower, 'bakso') || str_contains($namaLower, 'pangsit') || str_contains($namaLower, 'dimsum') || str_contains($namaLower, 'camilan') || str_contains($namaLower, 'kerupuk') || str_contains($namaLower, 'kentang')) {
                        $kategori = 'camilan';
                    } elseif(str_contains($namaLower, 'paket') || str_contains($namaLower, 'komplit') || str_contains($namaLower, 'combo')) {
                        $kategori = 'paket';
                    }
                @endphp
                <div 
                    class="menu-card bg-white rounded-2xl p-3 border border-slate-100 shadow-[0_2px_8px_rgba(0,0,0,0.04)] hover:shadow-md hover:border-brand-200 transition-all duration-200 flex flex-col justify-between group"
                    data-nama="{{ strtolower($m->nama_menu) }}"
                    data-kategori="{{ $kategori }}"
                >
                    <div>
                        <!-- Foto Menu -->
                        <div class="w-full aspect-[4/3] bg-slate-100 rounded-xl overflow-hidden relative mb-2.5">
                            @if($m->gambar)
                                <img 
                                    src="{{ asset('gambar_menu/'.$m->gambar) }}" 
                                    alt="{{ $m->nama_menu }}"
                                    loading="lazy"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                >
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-tr from-brand-50 to-amber-50 text-brand-400">
                                    <span class="material-icons-round text-3xl">restaurant</span>
                                </div>
                            @endif

                            <!-- Badge Stok -->
                            <div class="absolute bottom-1.5 right-1.5 bg-slate-900/80 backdrop-blur-sm text-white px-2 py-0.5 rounded-lg text-[9px] font-bold">
                                Stok: {{ $m->stok }}
                            </div>
                        </div>

                        <!-- Informasi Menu -->
                        <h4 class="font-bold text-xs text-slate-800 leading-tight line-clamp-2 min-h-[32px] group-hover:text-brand-700 transition-colors">
                            {{ $m->nama_menu }}
                        </h4>
                        
                        <div class="mt-1">
                            <span class="text-xs font-extrabold text-brand-700">
                                Rp {{ number_format($m->harga, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Quantity Counter & Tombol Tambah -->
                    <div class="mt-3 pt-2.5 border-t border-slate-100">
                        <div class="flex items-center justify-between bg-slate-50 rounded-xl p-1 border border-slate-200/70 box-counter">
                            <button 
                                type="button" 
                                onclick="ubahJumlah(this, -1)" 
                                aria-label="Kurangi porsi"
                                class="w-7 h-7 rounded-lg bg-white shadow-xs border border-slate-200/60 flex items-center justify-center text-slate-600 hover:text-slate-900 hover:bg-slate-100 active:scale-95 transition"
                            >
                                <span class="material-icons-round text-sm">remove</span>
                            </button>
                            
                            <input 
                                type="number" 
                                value="1" 
                                min="1" 
                                data-max="{{ $m->stok ?? 99 }}" 
                                class="input-jumlah w-7 text-center bg-transparent font-extrabold text-xs text-slate-900 focus:outline-none" 
                                readonly
                            >
                            
                            <button 
                                type="button" 
                                onclick="ubahJumlah(this, 1)" 
                                aria-label="Tambah porsi"
                                class="w-7 h-7 rounded-lg bg-white shadow-xs border border-slate-200/60 flex items-center justify-center text-slate-600 hover:text-slate-900 hover:bg-slate-100 active:scale-95 transition"
                            >
                                <span class="material-icons-round text-sm">add</span>
                            </button>
                        </div>

                        <button 
                            type="button"
                            onclick="tambahKeKeranjang(this, '{{ addslashes($m->nama_menu) }}', {{ $m->harga }})" 
                            class="btn-tambah w-full mt-2 bg-slate-900 hover:bg-brand-600 active:scale-95 text-white font-bold text-xs py-2 rounded-xl transition-all duration-200 flex items-center justify-center gap-1 shadow-sm"
                        >
                            <span class="material-icons-round text-sm">add_shopping_cart</span>
                            <span>+ Tambah</span>
                        </button>
                    </div>
                </div>
                @empty
                <div class="col-span-2 py-12 text-center bg-white rounded-2xl border border-slate-100 p-6">
                    <div class="w-14 h-14 bg-amber-50 rounded-full flex items-center justify-center mx-auto text-brand-500 mb-3">
                        <span class="material-icons-round text-3xl">inventory_2</span>
                    </div>
                    <h4 class="font-bold text-sm text-slate-800">Menu Belum Tersedia</h4>
                    <p class="text-xs text-slate-400 mt-1">Saat ini stok menu sedang habis atau belum dimasukkan.</p>
                </div>
                @endforelse
            </div>

            <!-- Empty State Pencarian / Filter -->
            <div id="emptySearch" class="hidden py-12 text-center bg-white rounded-2xl border border-slate-100 p-6 mt-4">
                <div class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center mx-auto text-slate-400 mb-3">
                    <span class="material-icons-round text-3xl">search_off</span>
                </div>
                <h4 class="font-bold text-sm text-slate-800">Menu Tidak Ditemukan</h4>
                <p class="text-xs text-slate-400 mt-1">Coba gunakan kata kunci lain atau pilih kategori "Semua".</p>
                <button onclick="resetSearch()" class="mt-4 bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs px-4 py-2 rounded-xl transition">
                    Tampilkan Semua Menu
                </button>
            </div>

        </main>

        @php
            $cartItems = (array) session('cart', []);
            $totalBadge = 0;
            foreach($cartItems as $ci) {
                $totalBadge += (int)($ci['jumlah'] ?? 1);
            }
        @endphp

        <!-- NAVBAR BOTTOM CUSTOMER -->
        <nav class="fixed bottom-0 w-full max-w-md bg-white/95 backdrop-blur-md border-t border-slate-200/80 px-6 py-2.5 flex justify-around items-center z-40 shadow-[0_-4px_20px_rgba(0,0,0,0.06)]">
            <a href="/pesan?meja={{ $meja }}" class="flex flex-col items-center text-brand-600 font-bold transition-colors">
                <div class="w-9 h-9 rounded-xl bg-brand-50 flex items-center justify-center text-brand-700 shadow-xs">
                    <span class="material-icons-round text-2xl">restaurant_menu</span>
                </div>
                <span class="text-[10px] font-extrabold mt-0.5">Buku Menu</span>
            </a>

            <a href="/keranjang" class="flex flex-col items-center text-slate-500 hover:text-slate-900 transition-colors relative group">
                <div class="relative w-9 h-9 rounded-xl group-hover:bg-slate-100 flex items-center justify-center transition">
                    <span class="material-icons-round text-2xl text-slate-600 group-hover:text-slate-900">shopping_bag</span>
                    <span 
                        id="badgeKeranjang" 
                        class="absolute -top-1 -right-1 bg-brand-600 text-white text-[10px] font-extrabold w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-sm transition-all {{ $totalBadge > 0 ? '' : 'hidden' }}"
                    >
                        {{ $totalBadge }}
                    </span>
                </div>
                <span class="text-[10px] font-bold text-slate-600 group-hover:text-slate-900 mt-0.5">Keranjang</span>
            </a>
        </nav>

    </div>

    <!-- SCRIPT CLIENT LOGIC -->
    <script>
        let currentCategory = 'all';

        function ubahJumlah(btn, arah) {
            let container = btn.closest('.box-counter');
            let input = container.querySelector('.input-jumlah');
            
            let currentVal = parseInt(input.value) || 1; 
            let maxStok = parseInt(input.getAttribute('data-max')) || 99; 
            
            let newVal = currentVal + arah;
            
            if (newVal >= 1 && newVal <= maxStok) {
                input.value = newVal;
            }
        }

        function showToast(msg) {
            let toast = document.getElementById('toastNotif');
            let toastMsg = document.getElementById('toastMsg');
            if(toast && toastMsg) {
                toastMsg.innerText = msg;
                toast.classList.remove('opacity-0', '-translate-y-12', 'pointer-events-none');
                toast.classList.add('opacity-100', 'translate-y-0');
                
                setTimeout(() => {
                    toast.classList.add('opacity-0', '-translate-y-12', 'pointer-events-none');
                    toast.classList.remove('opacity-100', 'translate-y-0');
                }, 2200);
            }
        }

        function tambahKeKeranjang(btn, namaMenu, harga) {
            let card = btn.closest('.menu-card');
            let input = card.querySelector('.input-jumlah');
            let jumlah = parseInt(input ? input.value : 1) || 1; 
            let meja = "{{ $meja }}";

            // Visual loading state on button
            let originalContent = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = `<span class="material-icons-round text-sm animate-spin">refresh</span> <span>Menambah...</span>`;

            fetch('/keranjang/tambah', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ 
                    menu: namaMenu, 
                    harga: harga, 
                    jumlah: jumlah, 
                    meja: meja 
                })
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = originalContent;

                if(data.success) {
                    // Update badge with pop animation
                    let badge = document.getElementById('badgeKeranjang');
                    if(badge) {
                        badge.innerText = data.total_item;
                        if(data.total_item > 0) {
                            badge.classList.remove('hidden');
                        } else {
                            badge.classList.add('hidden');
                        }
                        badge.classList.remove('animate-pop');
                        void badge.offsetWidth; // trigger reflow
                        badge.classList.add('animate-pop');
                    }
                    
                    showToast(`${jumlah}x ${namaMenu} berhasil ditambahkan!`);
                    
                    // Reset counter to 1
                    if(input) {
                        input.value = 1;
                    }
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = originalContent;
                showToast('Gagal menambahkan ke keranjang');
            });
        }

        function setCategory(cat, btn) {
            currentCategory = cat;
            document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active-pill'));
            if(btn) btn.classList.add('active-pill');
            filterMenu();
        }

        function resetSearch() {
            let searchInput = document.getElementById('searchInput');
            if(searchInput) searchInput.value = '';
            setCategory('all', document.querySelector('.category-btn'));
            filterMenu();
        }

        function filterMenu() {
            let searchInput = document.getElementById('searchInput');
            let clearBtn = document.getElementById('clearSearch');
            let query = (searchInput ? searchInput.value : '').toLowerCase().trim();
            
            if(clearBtn) {
                if(query.length > 0) {
                    clearBtn.classList.remove('hidden');
                } else {
                    clearBtn.classList.add('hidden');
                }
            }

            let cards = document.querySelectorAll('.menu-card');
            let visibleCount = 0;

            cards.forEach(card => {
                let name = card.getAttribute('data-nama') || '';
                let cat = card.getAttribute('data-kategori') || 'mie';

                let matchesSearch = query === '' || name.includes(query);
                let matchesCat = currentCategory === 'all' || cat === currentCategory;

                if (matchesSearch && matchesCat) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            let menuCount = document.getElementById('menuCount');
            if(menuCount) menuCount.innerText = visibleCount;

            let emptySearch = document.getElementById('emptySearch');
            if(emptySearch) {
                if(visibleCount === 0 && cards.length > 0) {
                    emptySearch.classList.remove('hidden');
                } else {
                    emptySearch.classList.add('hidden');
                }
            }
        }
    </script>
</body>
</html>