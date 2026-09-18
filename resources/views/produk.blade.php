<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk - EcoTahu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 flex h-screen font-sans">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md hidden md:flex flex-col">
        <div class="p-6 flex items-center gap-3">
            <div class="w-8 h-8 bg-emerald-600 rounded-md flex items-center justify-center text-white font-bold"><i class="fa-solid fa-leaf"></i></div>
            <span class="text-xl font-bold text-gray-800">EcoTahu</span>
        </div>
        <nav class="flex-1 px-4 space-y-2 text-gray-600">
            <a href="#" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100"><i class="fa-solid fa-house w-5"></i> Dashboard</a>
            <a href="#" class="flex items-center gap-3 p-3 rounded-lg bg-emerald-600 text-white font-semibold shadow"><i class="fa-solid fa-box w-5"></i> Produk</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto">
        <header class="bg-white shadow-sm p-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">Manajemen Produk</h1>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">Admin EcoTahu</span>
                <div class="w-8 h-8 bg-gray-300 rounded-full overflow-hidden">
                    <img src="https://ui-avatars.com/api/?name=Admin+EcoTahu&background=0D8ABC&color=fff" alt="Profile">
                </div>
            </div>
        </header>

        <div class="p-6">
            <!-- Notifikasi Sukses -->
            @if(session('success'))
            <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative mb-4">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <!-- Notifikasi Error Validasi -->
            @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <strong class="font-bold">Gagal Menyimpan!</strong>
                <ul class="list-disc list-inside mt-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-bold text-gray-800">Daftar Produk Tahu</h2>
                    <button onclick="bukaModalTambah()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                        + Tambah Produk
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 text-sm border-b">
                                <th class="p-4 font-semibold">Foto</th>
                                <th class="p-4 font-semibold">Kode Unik</th>
                                <th class="p-4 font-semibold">Nama Produk</th>
                                <th class="p-4 font-semibold">Harga</th>
                                <th class="p-4 font-semibold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse ($produks as $p)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4">
                                    @if($p->foto)
                                        <img src="{{ asset('storage/produks/' . $p->foto) }}" alt="Foto" class="w-16 h-16 object-cover rounded-md border">
                                    @else
                                        <div class="w-16 h-16 bg-gray-200 rounded-md flex items-center justify-center text-gray-400 text-xs">No Image</div>
                                    @endif
                                </td>
                                <td class="p-4 font-mono font-bold text-emerald-600">{{ $p->kode_produk }}</td>
                                <td class="p-4 font-medium">{{ $p->nama_produk }}</td>
                                <td class="p-4">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                                <td class="p-4 text-center">
                                    <!-- TOMBOL EDIT (Parameter dikirim lengkap ke JS) -->
                                    <button type="button" onclick="bukaModalEdit('{{ $p->id }}', '{{ $p->kode_produk }}', '{{ $p->nama_produk }}', '{{ $p->harga }}')" class="text-blue-500 hover:text-blue-700 mx-2">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>

                                    <!-- TOMBOL HAPUS -->
                                    <form action="{{ route('produk.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin mau hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 mx-2">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-500 py-8">
                                    Belum ada produk nih, bang. Tambahin dulu gih!
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- MODAL TAMBAH -->
    <div id="modalTambah" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Tambah Produk Baru</h3>
                <button onclick="tutupModalTambah()" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>
            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf 
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Produk (Unik)</label>
                    <input type="text" name="kode_produk" class="w-full border border-gray-300 rounded-lg p-2.5" required placeholder="Contoh: THU-001">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk (Huruf saja, tanpa angka/simbol)</label>
                    <!-- Validasi JS: otomatis mental kalau diketik angka/simbol -->
                    <input type="text" name="nama_produk" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" class="w-full border border-gray-300 rounded-lg p-2.5" required placeholder="Contoh: Tahu Putih Lembang">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                    <input type="number" name="harga" class="w-full border border-gray-300 rounded-lg p-2.5" required placeholder="15000">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Produk</label>
                    <input type="file" name="foto" accept="image/*" class="w-full border border-gray-300 rounded-lg p-2 text-sm bg-white">
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="tutupModalTambah()" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div id="modalEdit" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Edit Produk</h3>
                <button onclick="tutupModalEdit()" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>
            <form id="formEdit" action="" method="POST" enctype="multipart/form-data">
                @csrf 
                @method('PUT') 
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Produk (Unik)</label>
                    <input type="text" id="edit_kode" name="kode_produk" class="w-full border border-gray-300 rounded-lg p-2.5" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk (Huruf saja)</label>
                    <!-- Validasi JS di Edit juga -->
                    <input type="text" id="edit_nama" name="nama_produk" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" class="w-full border border-gray-300 rounded-lg p-2.5" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                    <input type="number" id="edit_harga" name="harga" class="w-full border border-gray-300 rounded-lg p-2.5" required>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Update Foto (Opsional)</label>
                    <input type="file" name="foto" accept="image/*" class="w-full border border-gray-300 rounded-lg p-2 text-sm bg-white">
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="tutupModalEdit()" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Javascript yang bener buat nangkep nilai input -->
    <script>
        function bukaModalTambah() { 
            document.getElementById('modalTambah').classList.remove('hidden'); 
        }
        function tutupModalTambah() { 
            document.getElementById('modalTambah').classList.add('hidden'); 
        }

        function bukaModalEdit(id, kode, nama, harga) {
            document.getElementById('modalEdit').classList.remove('hidden');
            // Memasukkan data lama ke dalam input form modal edit
            document.getElementById('edit_kode').value = kode;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_harga').value = harga;
            // Menyesuaikan jalur action URL update berdasarkan ID produk
            document.getElementById('formEdit').action = '/produk/' + id;
        }

        function tutupModalEdit() { 
            document.getElementById('modalEdit').classList.add('hidden'); 
        }
    </script>
</body>
</html>