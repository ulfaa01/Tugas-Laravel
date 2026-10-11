<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perpustakaan Digital - Modul 5</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen">
    <!-- Header -->
    <header class="bg-indigo-600 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">📚 Digital Library Dashboard</h1>
                <p class="text-xs text-indigo-100 mt-1">Praktikum Laravel: Migration, Model Eloquent & Seeder</p>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500 text-white shadow">
                    ● Database: digital_library (MySQL)
                </span>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8 space-y-8">
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center space-x-4">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-2xl font-bold">📖</div>
                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold">Total Buku</p>
                    <p class="text-2xl font-extrabold text-slate-900">{{ $books->count() }}</p>
                </div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center space-x-4">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center text-2xl font-bold">👥</div>
                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold">Total Anggota</p>
                    <p class="text-2xl font-extrabold text-slate-900">{{ $members->count() }}</p>
                </div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center space-x-4">
                <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center text-2xl font-bold">✍️</div>
                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold">Total Penulis</p>
                    <p class="text-2xl font-extrabold text-slate-900">{{ $authorsCount }}</p>
                </div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center space-x-4">
                <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center text-2xl font-bold">📋</div>
                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold">Peminjaman</p>
                    <p class="text-2xl font-extrabold text-slate-900">{{ $loans->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Section 1: Data Buku dengan Relasi Author & Publisher -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">1. Data Buku & Relasi (BelongsTo Author & Publisher)</h2>
                    <p class="text-xs text-slate-500">Query Eloquent: <code class="bg-slate-200 px-1 py-0.5 rounded text-indigo-700">Book::with(['author', 'publisher'])->get()</code></p>
                </div>
                <span class="px-2.5 py-1 bg-indigo-100 text-indigo-700 rounded-md text-xs font-semibold">Tabel: books</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-slate-600 font-semibold text-xs uppercase border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-6">ID</th>
                            <th class="py-3 px-6">Judul Buku</th>
                            <th class="py-3 px-6">Penulis (Author)</th>
                            <th class="py-3 px-6">Penerbit (Publisher)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($books as $book)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-6 font-medium text-slate-500">#{{ $book->id }}</td>
                            <td class="py-3.5 px-6 font-bold text-slate-900">{{ $book->title }}</td>
                            <td class="py-3.5 px-6">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                    {{ $book->author->name ?? '-' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-50 text-purple-700 border border-purple-200">
                                    {{ $book->publisher->name ?? '-' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Section 2: Data Peminjaman dengan Relasi Member & Book -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">2. Data Transaksi Peminjaman (Foreign Keys & Relasi)</h2>
                    <p class="text-xs text-slate-500">Query Eloquent: <code class="bg-slate-200 px-1 py-0.5 rounded text-indigo-700">Loan::with(['member', 'book'])->get()</code></p>
                </div>
                <span class="px-2.5 py-1 bg-amber-100 text-amber-700 rounded-md text-xs font-semibold">Tabel: loans</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-slate-600 font-semibold text-xs uppercase border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-6">ID Pinjam</th>
                            <th class="py-3 px-6">Nama Anggota</th>
                            <th class="py-3 px-6">Judul Buku</th>
                            <th class="py-3 px-6">Tgl Pinjam</th>
                            <th class="py-3 px-6">Tgl Kembali</th>
                            <th class="py-3 px-6">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($loans as $loan)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-6 font-medium text-slate-500">#{{ $loan->id }}</td>
                            <td class="py-3.5 px-6 font-semibold text-slate-800">{{ $loan->member->name ?? '-' }}</td>
                            <td class="py-3.5 px-6 text-slate-700">{{ $loan->book->title ?? '-' }}</td>
                            <td class="py-3.5 px-6 text-slate-600 font-mono text-xs">{{ $loan->loan_date ? $loan->loan_date->format('d M Y') : '-' }}</td>
                            <td class="py-3.5 px-6 text-slate-600 font-mono text-xs">{{ $loan->return_date ? $loan->return_date->format('d M Y') : '-' }}</td>
                            <td class="py-3.5 px-6">
                                @if($loan->return_date)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                        ✓ Sudah Dikembalikan
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 animate-pulse">
                                        ⏳ Sedang Dipinjam
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Section 3: Data Anggota -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">3. Data Anggota (Members)</h2>
                    <p class="text-xs text-slate-500">Query Eloquent: <code class="bg-slate-200 px-1 py-0.5 rounded text-indigo-700">Member::all()</code></p>
                </div>
                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-md text-xs font-semibold">Tabel: members</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-slate-600 font-semibold text-xs uppercase border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-6">ID</th>
                            <th class="py-3 px-6">Nama</th>
                            <th class="py-3 px-6">Email (Unique)</th>
                            <th class="py-3 px-6">Nomor Telepon</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($members as $member)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-6 font-medium text-slate-500">#{{ $member->id }}</td>
                            <td class="py-3.5 px-6 font-semibold text-slate-900">{{ $member->name }}</td>
                            <td class="py-3.5 px-6 text-slate-600 font-mono text-xs">{{ $member->email }}</td>
                            <td class="py-3.5 px-6 text-slate-600 font-mono text-xs">{{ $member->phone }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer class="max-w-7xl mx-auto px-6 py-6 text-center text-xs text-slate-400">
        Praktikum Laravel - Modul Minggu 5: Migration & Model Eloquent | Database: digital_library
    </footer>
</body>
</html>
