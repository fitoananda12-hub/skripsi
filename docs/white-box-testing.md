# DOKUMEN PENGUJIAN WHITE BOX TESTING
## Sistem Layanan Technical Support PT. ESABUMINDO

---

## Tabel 1. Uji Coba Whitebox Halaman Login

| No | Source Code | Keterangan | Status |
|----|-------------|------------|--------|
| 1 | `<a href="{{ route('login') }}">Login</a>` | Mulai - Membuka Halaman Login User | VALID |
| 2 | `<input type="email" name="email" value="{{ old('email') }}" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg" placeholder="email@example.com" required autofocus>` | Form Login - Form Input Email | VALID |
| 3 | `<input type="password" name="password" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg" placeholder="Masukkan password" required>` | Form Login - Form Input Password | VALID |
| 4 | `<input type="checkbox" name="remember" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500"> <span class="ml-2 text-sm text-gray-600">Ingat saya</span>` | Checkbox Ingat Saya - Opsi Remember Me | VALID |
| 5 | `<button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-purple-700 text-white py-3 rounded-lg font-semibold">Login</button>` | Tombol Login - Mengirim Data Login | VALID |
| 6 | `$credentials = $request->validate(['email' => ['required', 'email'], 'password' => ['required']]);` | Validasi - Menangkap dan Memvalidasi Data Email dan Password dari Form | VALID |
| 7 | `if (Auth::attempt($credentials, $remember)) { $request->session()->regenerate(); }` | Autentikasi - Memverifikasi Kredensial dan Regenerasi Session | VALID |
| 8 | `if (!$user->is_active) { Auth::logout(); throw ValidationException::withMessages(['email' => 'Akun Anda telah dinonaktifkan.']); }` | Cek Status Akun - Jika Akun Nonaktif, Logout dan Tampilkan Pesan Error | VALID |
| 9 | `throw ValidationException::withMessages(['email' => 'Email atau password yang Anda masukkan salah.']);` | Jika Gagal - Menampilkan Pesan Login Gagal | VALID |
| 10 | `if ($user->isAdmin()) { return redirect()->intended(route('admin.dashboard'))->with('success', 'Selamat datang, ' . $user->name); }` | Jika Berhasil (Admin) - Mengalihkan ke Dashboard Admin | VALID |
| 11 | `return redirect()->intended(route('user.dashboard'))->with('success', 'Selamat datang, ' . $user->name);` | Jika Berhasil (User) - Mengalihkan ke Dashboard User | VALID |

---

## Tabel 2. Uji Coba Whitebox Halaman Register

| No | Source Code | Keterangan | Status |
|----|-------------|------------|--------|
| 1 | `<a href="{{ route('register') }}">Daftar Sekarang</a>` | Mulai - Membuka Halaman Registrasi | VALID |
| 2 | `<input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg" placeholder="Masukkan nama lengkap" required>` | Form Registrasi - Input Nama Lengkap | VALID |
| 3 | `<input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg" placeholder="email@example.com" required>` | Form Registrasi - Input Email | VALID |
| 4 | `<input type="text" name="nik" value="{{ old('nik') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg" placeholder="Contoh: NIK12345" required>` | Form Registrasi - Input NIK Karyawan | VALID |
| 5 | `<input type="text" name="jabatan" value="{{ old('jabatan') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg" placeholder="Contoh: Staff Marketing" required>` | Form Registrasi - Input Jabatan | VALID |
| 6 | `<input type="text" name="departemen" value="{{ old('departemen') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg" placeholder="Contoh: Marketing" required>` | Form Registrasi - Input Departemen | VALID |
| 7 | `<input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg" placeholder="08xxxxxxxxxx" required>` | Form Registrasi - Input Nomor Telepon | VALID |
| 8 | `<textarea name="address" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg" placeholder="Masukkan alamat lengkap" required>{{ old('address') }}</textarea>` | Form Registrasi - Input Alamat | VALID |
| 9 | `<input type="password" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg" placeholder="Min. 8 karakter" required>` | Form Registrasi - Input Password | VALID |
| 10 | `<input type="password" name="password_confirmation" class="w-full px-4 py-3 border border-gray-300 rounded-lg" placeholder="Ulangi password" required>` | Form Registrasi - Input Konfirmasi Password | VALID |
| 11 | `<button type="submit" class="w-full mt-6 bg-gradient-to-r from-purple-600 to-purple-700 text-white py-3 rounded-lg font-semibold">Daftar Sekarang</button>` | Tombol Daftar - Mengirim Data Registrasi | VALID |
| 12 | `$validated = $request->validate(['name' => ['required', 'string', 'max:255'], 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], 'nik' => ['required', 'string', 'max:50', 'unique:users'], ...]);` | Validasi - Memvalidasi Semua Input Termasuk Unique Email dan NIK | VALID |
| 13 | `$user = User::create(['name' => $validated['name'], 'email' => $validated['email'], 'password' => Hash::make($validated['password']), 'role' => 'user', 'is_active' => true]);` | Proses - Membuat Akun User Baru dengan Hash Password | VALID |
| 14 | `Auth::login($user); $request->session()->regenerate();` | Auto Login - Login Otomatis Setelah Registrasi Berhasil | VALID |
| 15 | `return redirect()->route('user.dashboard')->with('success', 'Registrasi berhasil! Selamat datang, ' . $user->name);` | Selesai - Redirect ke Dashboard User dengan Pesan Sukses | VALID |

---

## Tabel 3. Uji Coba Whitebox Halaman Dashboard User

| No | Source Code | Keterangan | Status |
|----|-------------|------------|--------|
| 1 | `Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');` | Mulai - Membuka Halaman Dashboard User melalui Route | VALID |
| 2 | `$user = auth()->user();` | Autentikasi - Mengambil Data User yang Sedang Login | VALID |
| 3 | `$totalComplaints = $user->complaints()->count();` | Query - Menghitung Total Keluhan Milik User | VALID |
| 4 | `$submittedComplaints = $user->complaints()->where('status', 'submitted')->count();` | Query - Menghitung Keluhan Berstatus Diajukan | VALID |
| 5 | `$inProgressComplaints = $user->complaints()->where('status', 'in_progress')->count();` | Query - Menghitung Keluhan Berstatus Diproses | VALID |
| 6 | `$resolvedComplaints = $user->complaints()->where('status', 'resolved')->count();` | Query - Menghitung Keluhan Berstatus Selesai | VALID |
| 7 | `$recentComplaints = $user->complaints()->latest()->limit(5)->get();` | Query - Mengambil 5 Keluhan Terbaru | VALID |
| 8 | `<h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>` | Tampilan - Menampilkan Pesan Selamat Datang dengan Nama User | VALID |
| 9 | `<h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalComplaints }}</h3>` | Tampilan - Menampilkan Statistik Total Keluhan | VALID |
| 10 | `<a href="{{ route('user.complaints.create') }}" class="inline-block bg-purple-600 text-white px-6 py-3 rounded-lg">Buat Keluhan</a>` | Navigasi - Tombol Buat Keluhan Baru | VALID |
| 11 | `@foreach($recentComplaints as $complaint) ... @endforeach` | Tampilan - Menampilkan Tabel Keluhan Terbaru | VALID |
| 12 | `return view('user.dashboard', compact('totalComplaints', 'submittedComplaints', 'inProgressComplaints', 'resolvedComplaints', 'recentComplaints'));` | Selesai - Menampilkan View Dashboard dengan Data Statistik | VALID |

---

## Tabel 4. Uji Coba Whitebox Halaman Keluhan User

| No | Source Code | Keterangan | Status |
|----|-------------|------------|--------|
| 1 | `Route::get('/complaints', [UserComplaintController::class, 'index'])->name('complaints.index');` | Mulai - Membuka Halaman Daftar Keluhan User | VALID |
| 2 | `$complaints = Complaint::where('user_id', auth()->id())->latest()->paginate(10);` | Query - Mengambil Daftar Keluhan Milik User dengan Paginasi 10 per Halaman | VALID |
| 3 | `$total = auth()->user()->complaints()->count();` | Statistik - Menghitung Total Semua Keluhan | VALID |
| 4 | `$submitted = auth()->user()->complaints()->where('status', 'submitted')->count();` | Statistik - Menghitung Keluhan Diajukan | VALID |
| 5 | `$inProgress = auth()->user()->complaints()->where('status', 'in_progress')->count();` | Statistik - Menghitung Keluhan Diproses | VALID |
| 6 | `$returned = auth()->user()->complaints()->where('status', 'returned')->count();` | Statistik - Menghitung Keluhan Return | VALID |
| 7 | `$resolved = auth()->user()->complaints()->where('status', 'resolved')->count();` | Statistik - Menghitung Keluhan Selesai | VALID |
| 8 | `<a href="{{ route('user.complaints.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg">Buat Keluhan Baru</a>` | Navigasi - Tombol Buat Keluhan Baru | VALID |
| 9 | `@foreach($complaints as $complaint) ... {{ $complaint->complaint_number }} ... {{ $complaint->getStatusLabel() }} ... @endforeach` | Tampilan - Menampilkan Tabel Daftar Keluhan dengan Nomor, Produk, Status | VALID |
| 10 | `<a href="{{ route('user.complaints.show', $complaint) }}" class="text-purple-600">Detail</a>` | Navigasi - Link Menuju Detail Keluhan | VALID |
| 11 | `{{ $complaints->links() }}` | Paginasi - Menampilkan Navigasi Halaman | VALID |
| 12 | `return view('user.complaints.index', compact('complaints'));` | Selesai - Menampilkan View Daftar Keluhan | VALID |

---

## Tabel 5. Uji Coba Whitebox Halaman Tambah Keluhan User

| No | Source Code | Keterangan | Status |
|----|-------------|------------|--------|
| 1 | `Route::get('/complaints/create', [UserComplaintController::class, 'create'])->name('complaints.create');` | Mulai - Membuka Halaman Form Tambah Keluhan | VALID |
| 2 | `$problemTypes = ['Tidak Merekat dengan Baik', 'Cepat Kering', 'Bau Menyengat', 'Kemasan Rusak', ...];` | Data - Menyiapkan Daftar Jenis Masalah | VALID |
| 3 | `<input type="text" name="customer_name" value="{{ old('customer_name') }}" placeholder="Masukkan nama customer" required>` | Form Input - Nama Customer | VALID |
| 4 | `<input type="text" name="product_name" value="{{ old('product_name') }}" placeholder="Contoh: Super Glue 50ml" required>` | Form Input - Nama Produk | VALID |
| 5 | `<select name="problem_type" required> @foreach($problemTypes as $type) <option value="{{ $type }}">{{ $type }}</option> @endforeach </select>` | Form Input - Memilih Jenis Masalah dari Dropdown | VALID |
| 6 | `<textarea name="description" rows="5" placeholder="Jelaskan masalah yang Anda alami secara detail..." required>{{ old('description') }}</textarea>` | Form Input - Deskripsi Keluhan | VALID |
| 7 | `<input type="file" name="media[]" id="media" accept="image/*,video/*" multiple onchange="previewMedia(event)">` | Form Input - Upload Bukti Foto/Video (Multiple) | VALID |
| 8 | `<input type="date" name="incident_date" value="{{ old('incident_date', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required>` | Form Input - Tanggal Kejadian | VALID |
| 9 | `<button type="submit" class="bg-purple-600 text-white px-8 py-3 rounded-lg font-semibold">Kirim Keluhan</button>` | Tombol Kirim - Mengirim Data Keluhan | VALID |
| 10 | `$validated = $request->validate(['customer_name' => ['required', 'string', 'max:255'], 'product_name' => ['required', 'string', 'max:255'], 'problem_type' => ['required', 'string'], 'description' => ['required', 'string'], 'incident_date' => ['required', 'date', 'before_or_equal:today']]);` | Validasi - Memvalidasi Semua Input Form | VALID |
| 11 | `if ($request->hasFile('media')) { foreach ($request->file('media') as $file) { $photoPaths[] = $file->store('complaints', 'public'); } }` | Upload File - Menyimpan File Bukti ke Storage Public | VALID |
| 12 | `$complaint = Complaint::create(['user_id' => auth()->id(), 'customer_name' => $validated['customer_name'], 'product_name' => $validated['product_name'], 'status' => 'submitted', 'priority' => 'medium']);` | Proses - Membuat Data Keluhan Baru ke Database | VALID |
| 13 | `return redirect()->route('user.complaints.show', $complaint)->with('success', 'Keluhan berhasil diajukan dengan nomor: ' . $complaint->complaint_number);` | Selesai - Redirect ke Detail Keluhan dengan Pesan Sukses | VALID |

---

## Tabel 6. Uji Coba Whitebox Halaman Detail Keluhan User

| No | Source Code | Keterangan | Status |
|----|-------------|------------|--------|
| 1 | `Route::get('/complaints/{complaint}', [UserComplaintController::class, 'show'])->name('complaints.show');` | Mulai - Membuka Halaman Detail Keluhan | VALID |
| 2 | `if ($complaint->user_id !== auth()->id()) { abort(403, 'Unauthorized action.'); }` | Otorisasi - Cek Apakah Keluhan Milik User yang Login | VALID |
| 3 | `$complaint->load(['assignedAdmin', 'solutions']);` | Query - Memuat Data Relasi Admin dan Solusi | VALID |
| 4 | `<h2 class="text-2xl font-bold text-gray-800">{{ $complaint->complaint_number }}</h2>` | Tampilan - Menampilkan Nomor Keluhan | VALID |
| 5 | `<span class="px-4 py-2 text-sm font-semibold rounded-full {{ $complaint->getStatusBadgeClass() }}">{{ $complaint->getStatusLabel() }}</span>` | Tampilan - Menampilkan Badge Status Keluhan | VALID |
| 6 | `<p class="text-gray-800 font-medium">{{ $complaint->product_name }}</p>` | Tampilan - Menampilkan Nama Produk | VALID |
| 7 | `<p class="text-gray-800 whitespace-pre-line">{{ $complaint->description }}</p>` | Tampilan - Menampilkan Deskripsi Keluhan | VALID |
| 8 | `@if(count($photos) > 0) @foreach($photos as $path) ... <img src="{{ $file_url }}" alt="Bukti"> ... @endforeach @endif` | Tampilan - Menampilkan Bukti Foto/Video Keluhan | VALID |
| 9 | `@if($complaint->admin_response) <p class="text-gray-800 whitespace-pre-line">{{ $complaint->admin_response }}</p> @endif` | Tampilan - Menampilkan Respon dari Admin (Jika Ada) | VALID |
| 10 | `@if($complaint->solutions->count() > 0) @foreach($complaint->solutions as $solution) ... {{ $solution->title }} ... @endforeach @endif` | Tampilan - Menampilkan Solusi yang Diberikan (Jika Ada) | VALID |
| 11 | `<p class="text-xs text-gray-500">{{ $complaint->created_at->format('d M Y H:i') }}</p>` | Status Timeline - Menampilkan Tanggal Pengajuan | VALID |
| 12 | `return view('user.complaints.show', compact('complaint'));` | Selesai - Menampilkan View Detail Keluhan | VALID |

---

## Tabel 7. Uji Coba Whitebox Halaman Riwayat User

| No | Source Code | Keterangan | Status |
|----|-------------|------------|--------|
| 1 | `Route::get('/history', [HistoryController::class, 'index'])->name('history');` | Mulai - Membuka Halaman Riwayat Keluhan | VALID |
| 2 | `$query = Complaint::where('user_id', auth()->id());` | Query - Mengambil Keluhan Milik User yang Login | VALID |
| 3 | `if ($request->filled('status')) { $query->where('status', $request->status); }` | Filter - Memfilter Keluhan Berdasarkan Status | VALID |
| 4 | `if ($request->filled('date_from')) { $query->whereDate('created_at', '>=', $request->date_from); }` | Filter - Memfilter Keluhan Berdasarkan Tanggal Mulai | VALID |
| 5 | `if ($request->filled('date_to')) { $query->whereDate('created_at', '<=', $request->date_to); }` | Filter - Memfilter Keluhan Berdasarkan Tanggal Akhir | VALID |
| 6 | `if ($request->filled('search')) { $query->where(function($q) use ($request) { $q->where('complaint_number', 'like', '%' . $request->search . '%')->orWhere('product_name', 'like', ...); }); }` | Pencarian - Mencari Keluhan Berdasarkan Nomor, Produk, atau Jenis Masalah | VALID |
| 7 | `$complaints = $query->latest()->paginate(15);` | Query - Mengambil Data dengan Paginasi 15 per Halaman | VALID |
| 8 | `$statusCounts = ['all' => ..., 'submitted' => ..., 'in_progress' => ..., 'returned' => ..., 'resolved' => ...];` | Statistik - Menghitung Jumlah Keluhan Per Status | VALID |
| 9 | `<input type="text" name="search" value="{{ request('search') }}" placeholder="No. keluhan, produk...">` | Form Filter - Input Pencarian | VALID |
| 10 | `<input type="date" name="date_from" value="{{ request('date_from') }}">` | Form Filter - Input Tanggal Mulai | VALID |
| 11 | `<button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-lg">Filter</button>` | Tombol Filter - Menerapkan Filter Pencarian | VALID |
| 12 | `{{ $complaints->appends(request()->query())->links() }}` | Paginasi - Navigasi Halaman dengan Query String | VALID |
| 13 | `return view('user.history', compact('complaints', 'statusCounts'));` | Selesai - Menampilkan View Riwayat Keluhan | VALID |

---

## Tabel 8. Uji Coba Whitebox Halaman Profil User

| No | Source Code | Keterangan | Status |
|----|-------------|------------|--------|
| 1 | `Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');` | Mulai - Membuka Halaman Edit Profil | VALID |
| 2 | `$user = auth()->user(); return view('user.profile.edit', compact('user'));` | Query - Mengambil Data User yang Sedang Login | VALID |
| 3 | `<input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-3 border rounded-lg" required>` | Form Input - Nama Lengkap | VALID |
| 4 | `<input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-3 border rounded-lg" required>` | Form Input - Email | VALID |
| 5 | `<input type="text" name="nik" value="{{ old('nik', $user->nik) }}" class="w-full px-4 py-3 border rounded-lg" required>` | Form Input - NIK Karyawan | VALID |
| 6 | `<input type="text" name="jabatan" value="{{ old('jabatan', $user->jabatan) }}" required>` | Form Input - Jabatan | VALID |
| 7 | `<input type="text" name="departemen" value="{{ old('departemen', $user->departemen) }}" required>` | Form Input - Departemen | VALID |
| 8 | `<input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required>` | Form Input - Nomor Telepon | VALID |
| 9 | `<textarea name="address" rows="3" required>{{ old('address', $user->address) }}</textarea>` | Form Input - Alamat | VALID |
| 10 | `<button type="submit" class="w-full bg-purple-600 text-white px-6 py-3 rounded-lg">Simpan Perubahan</button>` | Tombol Simpan - Mengirim Data Profil | VALID |
| 11 | `$validated = $request->validate(['name' => ['required', 'string', 'max:255'], 'email' => ['required', 'email', 'unique:users,email,' . $user->id], ...]);` | Validasi - Memvalidasi Input Profil | VALID |
| 12 | `$user->name = $validated['name']; $user->email = $validated['email']; ... $user->save();` | Proses - Menyimpan Perubahan Data Profil ke Database | VALID |
| 13 | `<input type="password" name="current_password" class="w-full px-4 py-3 border rounded-lg">` | Form Password - Input Password Lama | VALID |
| 14 | `<input type="password" name="new_password" class="w-full px-4 py-3 border rounded-lg">` | Form Password - Input Password Baru | VALID |
| 15 | `<input type="password" name="new_password_confirmation" class="w-full px-4 py-3 border rounded-lg">` | Form Password - Input Konfirmasi Password Baru | VALID |
| 16 | `if ($request->filled('new_password')) { if (!Hash::check($request->current_password, $user->password)) { return back()->withErrors(['current_password' => 'Password lama tidak sesuai']); } $user->password = Hash::make($validated['new_password']); }` | Validasi Password - Cek Password Lama dan Update Password Baru | VALID |
| 17 | `return back()->with('success', 'Profil berhasil diperbarui');` | Selesai - Redirect Kembali dengan Pesan Sukses | VALID |

---

## Tabel 9. Uji Coba Whitebox Halaman Dashboard Admin Laboratorium

| No | Source Code | Keterangan | Status |
|----|-------------|------------|--------|
| 1 | `Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');` | Mulai - Membuka Halaman Dashboard Admin | VALID |
| 2 | `$totalComplaints = Complaint::count();` | Query - Menghitung Total Semua Keluhan | VALID |
| 3 | `$pendingComplaints = Complaint::where('status', 'submitted')->count();` | Query - Menghitung Keluhan Berstatus Diajukan | VALID |
| 4 | `$inProgressComplaints = Complaint::where('status', 'in_progress')->count();` | Query - Menghitung Keluhan Berstatus Diproses | VALID |
| 5 | `$resolvedComplaints = Complaint::where('status', 'resolved')->count();` | Query - Menghitung Keluhan Berstatus Selesai | VALID |
| 6 | `$totalUsers = User::where('role', 'user')->count();` | Query - Menghitung Total User Terdaftar | VALID |
| 7 | `$totalSolutions = Solution::where('is_active', true)->count();` | Query - Menghitung Total Solusi Aktif di Knowledge Base | VALID |
| 8 | `$recentComplaints = Complaint::with('user')->latest()->limit(5)->get();` | Query - Mengambil 5 Keluhan Terbaru dengan Data User | VALID |
| 9 | `$complaintsByStatus = Complaint::select('status', DB::raw('count(*) as total'))->groupBy('status')->get();` | Query - Mengelompokkan Keluhan Berdasarkan Status untuk Chart | VALID |
| 10 | `$complaintsByPriority = Complaint::select('priority', DB::raw('count(*) as total'))->groupBy('priority')->get();` | Query - Mengelompokkan Keluhan Berdasarkan Prioritas untuk Chart | VALID |
| 11 | `$monthlyComplaints = Complaint::select(DB::raw('MONTH(created_at) as month'), ...)->where('created_at', '>=', now()->subMonths(6))->groupBy('month', 'year')->get();` | Query - Mengambil Tren Keluhan 6 Bulan Terakhir | VALID |
| 12 | `$topProblems = Complaint::select('problem_type', DB::raw('count(*) as total'))->groupBy('problem_type')->orderBy('total', 'desc')->limit(5)->get();` | Query - Mengambil 5 Masalah Terbanyak | VALID |
| 13 | `$topSolutions = Solution::orderBy('usage_count', 'desc')->limit(5)->get();` | Query - Mengambil 5 Solusi Terpopuler | VALID |
| 14 | `$avgResolutionTime = Complaint::whereNotNull('resolved_at')->selectRaw('AVG(DATEDIFF(resolved_at, created_at)) as avg_days')->value('avg_days');` | Query - Menghitung Rata-rata Waktu Penyelesaian | VALID |
| 15 | `<canvas id="statusChart" height="200"></canvas>` | Chart - Menampilkan Chart Doughnut Status Keluhan | VALID |
| 16 | `<canvas id="priorityChart" height="200"></canvas>` | Chart - Menampilkan Chart Pie Prioritas Keluhan | VALID |
| 17 | `<canvas id="trendChart" height="80"></canvas>` | Chart - Menampilkan Chart Line Tren Keluhan Bulanan | VALID |
| 18 | `return view('admin.dashboard', compact('totalComplaints', 'pendingComplaints', ...));` | Selesai - Menampilkan View Dashboard Admin dengan Semua Data | VALID |

---

## Tabel 10. Uji Coba Whitebox Halaman Kelola Keluhan Admin

| No | Source Code | Keterangan | Status |
|----|-------------|------------|--------|
| 1 | `Route::get('/complaints', [AdminComplaintController::class, 'index'])->name('complaints.index');` | Mulai - Membuka Halaman Kelola Keluhan Admin | VALID |
| 2 | `$query = Complaint::with(['user', 'assignedAdmin']);` | Query - Mengambil Data Keluhan dengan Relasi User dan Admin | VALID |
| 3 | `if ($request->filled('status')) { $query->where('status', $request->status); }` | Filter - Memfilter Berdasarkan Status | VALID |
| 4 | `if ($request->filled('priority')) { $query->where('priority', $request->priority); }` | Filter - Memfilter Berdasarkan Prioritas | VALID |
| 5 | `if ($request->filled('assigned_to')) { $query->where('assigned_to', $request->assigned_to); }` | Filter - Memfilter Berdasarkan Admin yang Ditugaskan | VALID |
| 6 | `if ($request->filled('search')) { $query->where(function($q) use ($request) { $q->where('complaint_number', 'like', '%' . $request->search . '%')->orWhere('product_name', 'like', ...)->orWhereHas('user', ...); }); }` | Pencarian - Mencari Berdasarkan Nomor Keluhan, Produk, Customer, atau Nama User | VALID |
| 7 | `$complaints = $query->latest()->paginate(15);` | Query - Mengambil Data dengan Paginasi 15 per Halaman | VALID |
| 8 | `$admins = User::where('role', 'admin')->get();` | Query - Mengambil Daftar Admin untuk Filter | VALID |
| 9 | `$statusCounts = ['all' => Complaint::count(), 'submitted' => ..., 'in_progress' => ..., 'returned' => ..., 'resolved' => ...];` | Statistik - Menghitung Jumlah Keluhan Per Status | VALID |
| 10 | `return view('admin.complaints.index', compact('complaints', 'admins', 'statusCounts'));` | Selesai - Menampilkan View Kelola Keluhan dengan Data | VALID |

---

## Tabel 11. Uji Coba Whitebox Halaman Edit Keluhan Admin

| No | Source Code | Keterangan | Status |
|----|-------------|------------|--------|
| 1 | `Route::get('/complaints/{complaint}/edit', [AdminComplaintController::class, 'edit'])->name('complaints.edit');` | Mulai - Membuka Halaman Edit Keluhan | VALID |
| 2 | `$complaint->load('solutions');` | Query - Memuat Data Solusi yang Terkait dengan Keluhan | VALID |
| 3 | `$admins = User::whereIn('role', ['admin', 'admin-lab', 'admin-sales'])->where('name', '!=', 'Super Admin')->get();` | Query - Mengambil Daftar Admin untuk Penugasan | VALID |
| 4 | `$solutions = Solution::where('is_active', true)->get();` | Query - Mengambil Daftar Solusi Aktif dari Knowledge Base | VALID |
| 5 | `<select name="status" required> <option value="submitted">Diajukan</option> <option value="in_progress">Dalam Proses</option> <option value="resolved">Selesai</option> <option value="returned">Return</option> </select>` | Form Input - Dropdown Update Status Keluhan | VALID |
| 6 | `<select name="priority" required> <option value="low">Rendah</option> <option value="medium">Sedang</option> <option value="high">Tinggi</option> </select>` | Form Input - Dropdown Update Prioritas | VALID |
| 7 | `<textarea name="admin_response" rows="5" placeholder="Berikan respon dan solusi untuk keluhan ini...">{{ old('admin_response', $complaint->admin_response) }}</textarea>` | Form Input - Textarea Respon Admin | VALID |
| 8 | `@foreach($solutions as $solution) <input type="checkbox" name="solution_ids[]" value="{{ $solution->id }}" {{ $complaint->solutions->contains($solution->id) ? 'checked' : '' }}> @endforeach` | Form Input - Checklist Pilih Solusi dari Knowledge Base | VALID |
| 9 | `<button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg">Simpan Perubahan</button>` | Tombol Simpan - Mengirim Data Pembaruan | VALID |
| 10 | `$validated = $request->validate(['status' => ['required', 'in:submitted,in_progress,returned,resolved'], 'priority' => ['required', 'in:low,medium,high'], 'admin_response' => ['nullable', 'string'], 'solution_ids' => ['nullable', 'array']]);` | Validasi - Memvalidasi Input Update Keluhan | VALID |
| 11 | `if ($validated['status'] === 'resolved') { $validated['resolved_at'] = $complaint->resolved_at ?? now(); }` | Logika - Set Timestamp Resolved Otomatis Jika Status Selesai | VALID |
| 12 | `$complaint->update($validated);` | Proses - Menyimpan Perubahan Data Keluhan ke Database | VALID |
| 13 | `$complaint->solutions()->sync($solutionIds);` | Proses - Sinkronisasi Solusi Knowledge Base dengan Keluhan | VALID |
| 14 | `return redirect()->route('admin.complaints.show', $complaint)->with('success', 'Data keluhan berhasil diperbarui');` | Selesai - Redirect ke Detail Keluhan dengan Pesan Sukses | VALID |

---

## Tabel 12. Uji Coba Whitebox Halaman Detail Keluhan Admin

| No | Source Code | Keterangan | Status |
|----|-------------|------------|--------|
| 1 | `Route::get('/complaints/{complaint}', [AdminComplaintController::class, 'show'])->name('complaints.show');` | Mulai - Membuka Halaman Detail Keluhan Admin | VALID |
| 2 | `$complaint->load(['user', 'assignedAdmin', 'solutions']);` | Query - Memuat Data Relasi User, Admin, dan Solusi | VALID |
| 3 | `{{ $complaint->complaint_number }}` | Tampilan - Menampilkan Nomor Keluhan | VALID |
| 4 | `{{ $complaint->getStatusLabel() }}` | Tampilan - Menampilkan Label Status Keluhan | VALID |
| 5 | `{{ $complaint->user->name }}` | Tampilan - Menampilkan Nama User Pengaju | VALID |
| 6 | `{{ $complaint->product_name }}` | Tampilan - Menampilkan Nama Produk | VALID |
| 7 | `{{ $complaint->problem_type }}` | Tampilan - Menampilkan Jenis Masalah | VALID |
| 8 | `{{ $complaint->description }}` | Tampilan - Menampilkan Deskripsi Keluhan | VALID |
| 9 | `{{ $complaint->admin_response }}` | Tampilan - Menampilkan Respon Admin (Jika Ada) | VALID |
| 10 | `@foreach($complaint->solutions as $solution) ... @endforeach` | Tampilan - Menampilkan Daftar Solusi yang Diterapkan | VALID |
| 11 | `<a href="{{ route('admin.complaints.edit', $complaint) }}">Edit Keluhan</a>` | Navigasi - Link ke Halaman Edit Keluhan | VALID |
| 12 | `return view('admin.complaints.show', compact('complaint'));` | Selesai - Menampilkan View Detail Keluhan Admin | VALID |

---

## Tabel 13. Uji Coba Whitebox Halaman Kelola Solusi Admin

| No | Source Code | Keterangan | Status |
|----|-------------|------------|--------|
| 1 | `Route::resource('solutions', SolutionController::class);` | Mulai - Membuka Halaman Knowledge Base Solusi | VALID |
| 2 | `$query = Solution::with('creator');` | Query - Mengambil Data Solusi dengan Relasi Creator | VALID |
| 3 | `if ($request->filled('search')) { $query->where(function($q) use ($request) { $q->where('title', 'like', '%' . $request->search . '%')->orWhere('problem_category', 'like', ...)->orWhere('solution_description', 'like', ...); }); }` | Pencarian - Mencari Solusi Berdasarkan Judul, Kategori, atau Deskripsi | VALID |
| 4 | `if ($request->filled('is_active')) { $query->where('is_active', $request->is_active); }` | Filter - Memfilter Berdasarkan Status Aktif/Nonaktif | VALID |
| 5 | `$solutions = $query->latest()->paginate(15);` | Query - Mengambil Data dengan Paginasi 15 per Halaman | VALID |
| 6 | `$totalSolutions = Solution::count();` | Statistik - Menghitung Total Solusi | VALID |
| 7 | `$activeSolutions = Solution::where('is_active', true)->count();` | Statistik - Menghitung Solusi Aktif | VALID |
| 8 | `$totalUsage = Solution::sum('usage_count');` | Statistik - Menghitung Total Penggunaan Solusi | VALID |
| 9 | `return view('admin.solutions.index', compact('solutions', 'totalSolutions', 'activeSolutions', 'totalUsage'));` | Selesai - Menampilkan View Daftar Solusi Knowledge Base | VALID |

---

## Tabel 14. Uji Coba Whitebox Halaman Tambah Solusi Admin

| No | Source Code | Keterangan | Status |
|----|-------------|------------|--------|
| 1 | `Route::get('/solutions/create', [SolutionController::class, 'create']);` | Mulai - Membuka Halaman Form Tambah Solusi | VALID |
| 2 | `$problemCategories = ['Daya Rekat Lemah', 'Pengeringan Cepat', 'Bau Tidak Sedap', 'Kemasan Rusak', ...];` | Data - Menyiapkan Daftar Kategori Masalah | VALID |
| 3 | `<input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Solusi Lem Tidak Merekat" required>` | Form Input - Judul Solusi | VALID |
| 4 | `<select name="problem_category" required> @foreach($problemCategories as $category) <option value="{{ $category }}">{{ $category }}</option> @endforeach </select>` | Form Input - Memilih Kategori Masalah | VALID |
| 5 | `<textarea name="solution_description" rows="4" placeholder="Jelaskan solusi secara singkat dan jelas..." required>{{ old('solution_description') }}</textarea>` | Form Input - Deskripsi Solusi | VALID |
| 6 | `<textarea name="technical_steps" rows="5" placeholder="1. Langkah pertama...">{{ old('technical_steps') }}</textarea>` | Form Input - Langkah Teknis (Opsional) | VALID |
| 7 | `<textarea name="prevention_tips" rows="4" placeholder="- Tip pertama...">{{ old('prevention_tips') }}</textarea>` | Form Input - Tips Pencegahan (Opsional) | VALID |
| 8 | `<input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>` | Form Input - Checkbox Status Aktif Solusi | VALID |
| 9 | `<button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg">Simpan Solusi</button>` | Tombol Simpan - Mengirim Data Solusi | VALID |
| 10 | `$validated = $request->validate(['title' => ['required', 'string', 'max:255'], 'problem_category' => ['required', 'string'], 'solution_description' => ['required', 'string']]);` | Validasi - Memvalidasi Input Solusi | VALID |
| 11 | `$validated['created_by'] = auth()->id(); $validated['is_active'] = $request->has('is_active'); $validated['usage_count'] = 0;` | Proses - Set Creator, Status Aktif, dan Usage Count Awal | VALID |
| 12 | `Solution::create($validated);` | Proses - Menyimpan Solusi Baru ke Database | VALID |
| 13 | `return redirect()->route('admin.solutions.index')->with('success', 'Solusi berhasil ditambahkan ke knowledge base');` | Selesai - Redirect ke Daftar Solusi dengan Pesan Sukses | VALID |

---

## Tabel 15. Uji Coba Whitebox Halaman Edit Solusi Admin

| No | Source Code | Keterangan | Status |
|----|-------------|------------|--------|
| 1 | `Route::get('/solutions/{solution}/edit', [SolutionController::class, 'edit']);` | Mulai - Membuka Halaman Edit Solusi | VALID |
| 2 | `$problemCategories = ['Daya Rekat Lemah', 'Pengeringan Cepat', 'Bau Tidak Sedap', ...];` | Data - Menyiapkan Daftar Kategori Masalah | VALID |
| 3 | `<input type="text" name="title" value="{{ old('title', $solution->title) }}" required>` | Form Input - Judul Solusi (Terisi Data Existing) | VALID |
| 4 | `<select name="problem_category" required> @foreach($problemCategories as $category) <option value="{{ $category }}" {{ old('problem_category', $solution->problem_category) == $category ? 'selected' : '' }}>{{ $category }}</option> @endforeach </select>` | Form Input - Kategori Masalah (Terisi Data Existing) | VALID |
| 5 | `<textarea name="solution_description" rows="4" required>{{ old('solution_description', $solution->solution_description) }}</textarea>` | Form Input - Deskripsi Solusi (Terisi Data Existing) | VALID |
| 6 | `<textarea name="technical_steps" rows="5">{{ old('technical_steps', $solution->technical_steps) }}</textarea>` | Form Input - Langkah Teknis (Terisi Data Existing) | VALID |
| 7 | `<textarea name="prevention_tips" rows="4">{{ old('prevention_tips', $solution->prevention_tips) }}</textarea>` | Form Input - Tips Pencegahan (Terisi Data Existing) | VALID |
| 8 | `<input type="checkbox" name="is_active" value="1" {{ old('is_active', $solution->is_active) ? 'checked' : '' }}>` | Form Input - Checkbox Status Aktif (Terisi Data Existing) | VALID |
| 9 | `<p class="text-sm text-yellow-700">Solusi ini telah digunakan <strong>{{ $solution->usage_count }}x</strong> untuk mengatasi keluhan</p>` | Informasi - Menampilkan Jumlah Penggunaan Solusi | VALID |
| 10 | `<button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg">Simpan Perubahan</button>` | Tombol Simpan - Mengirim Data Pembaruan | VALID |
| 11 | `$validated = $request->validate(['title' => ['required', 'string', 'max:255'], 'problem_category' => ['required', 'string'], 'solution_description' => ['required', 'string']]);` | Validasi - Memvalidasi Input Solusi | VALID |
| 12 | `$validated['is_active'] = $request->has('is_active'); $solution->update($validated);` | Proses - Update Status Aktif dan Simpan Perubahan ke Database | VALID |
| 13 | `return redirect()->route('admin.solutions.index')->with('success', 'Solusi berhasil diperbarui');` | Selesai - Redirect ke Daftar Solusi dengan Pesan Sukses | VALID |

---

## Tabel 16. Uji Coba Whitebox Halaman Detail Solusi Admin

| No | Source Code | Keterangan | Status |
|----|-------------|------------|--------|
| 1 | `Route::get('/solutions/{solution}', [SolutionController::class, 'show']);` | Mulai - Membuka Halaman Detail Solusi | VALID |
| 2 | `$solution->load(['creator', 'complaints']);` | Query - Memuat Data Relasi Creator dan Keluhan Terkait | VALID |
| 3 | `{{ $solution->title }}` | Tampilan - Menampilkan Judul Solusi | VALID |
| 4 | `{{ $solution->problem_category }}` | Tampilan - Menampilkan Kategori Masalah | VALID |
| 5 | `{{ $solution->solution_description }}` | Tampilan - Menampilkan Deskripsi Solusi | VALID |
| 6 | `{{ $solution->technical_steps }}` | Tampilan - Menampilkan Langkah Teknis | VALID |
| 7 | `{{ $solution->prevention_tips }}` | Tampilan - Menampilkan Tips Pencegahan | VALID |
| 8 | `{{ $solution->is_active ? 'Aktif' : 'Nonaktif' }}` | Tampilan - Menampilkan Status Aktif/Nonaktif Solusi | VALID |
| 9 | `{{ $solution->usage_count }}` | Tampilan - Menampilkan Jumlah Penggunaan Solusi | VALID |
| 10 | `{{ $solution->creator->name }}` | Tampilan - Menampilkan Nama Pembuat Solusi | VALID |
| 11 | `@foreach($solution->complaints as $complaint) ... @endforeach` | Tampilan - Menampilkan Daftar Keluhan yang Menggunakan Solusi | VALID |
| 12 | `return view('admin.solutions.show', compact('solution'));` | Selesai - Menampilkan View Detail Solusi | VALID |

---

## Tabel 17. Uji Coba Whitebox Halaman Manajemen User Admin

| No | Source Code | Keterangan | Status |
|----|-------------|------------|--------|
| 1 | `Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');` | Mulai - Membuka Halaman Manajemen User | VALID |
| 2 | `$query = User::where('role', 'user')->withCount('complaints');` | Query - Mengambil Data User dengan Jumlah Keluhan | VALID |
| 3 | `if ($request->filled('search')) { $query->where(function($q) use ($request) { $q->where('name', 'like', '%' . $request->search . '%')->orWhere('email', 'like', ...)->orWhere('phone', 'like', ...); }); }` | Pencarian - Mencari User Berdasarkan Nama, Email, atau Telepon | VALID |
| 4 | `if ($request->filled('is_active')) { $query->where('is_active', $request->is_active); }` | Filter - Memfilter Berdasarkan Status Aktif/Nonaktif | VALID |
| 5 | `$users = $query->latest()->paginate(15);` | Query - Mengambil Data dengan Paginasi 15 per Halaman | VALID |
| 6 | `$totalUsers = User::where('role', 'user')->count();` | Statistik - Menghitung Total User | VALID |
| 7 | `$activeUsers = User::where('role', 'user')->where('is_active', true)->count();` | Statistik - Menghitung User Aktif | VALID |
| 8 | `$inactiveUsers = User::where('role', 'user')->where('is_active', false)->count();` | Statistik - Menghitung User Nonaktif | VALID |
| 9 | `if ($user->role === 'admin') { return back()->with('error', 'Tidak dapat mengubah status akun admin'); }` | Proteksi - Mencegah Toggle Status Akun Admin | VALID |
| 10 | `$user->is_active = !$user->is_active; $user->save();` | Proses - Toggle Status Aktif/Nonaktif User | VALID |
| 11 | `$status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan'; return back()->with('success', "Akun {$user->name} berhasil {$status}");` | Selesai - Redirect Kembali dengan Pesan Sukses Toggle Status | VALID |
| 12 | `return view('admin.users.index', compact('users', 'totalUsers', 'activeUsers', 'inactiveUsers'));` | Selesai - Menampilkan View Manajemen User | VALID |

---

## Tabel 18. Uji Coba Whitebox Halaman Laporan Admin

| No | Source Code | Keterangan | Status |
|----|-------------|------------|--------|
| 1 | `Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');` | Mulai - Membuka Halaman Laporan | VALID |
| 2 | `$dateFrom = $request->input('date_from'); $dateTo = $request->input('date_to');` | Parameter - Mengambil Filter Tanggal dari Request | VALID |
| 3 | `$complaintQuery = Complaint::query(); if ($dateFrom) { $complaintQuery->where('created_at', '>=', $dateFrom . ' 00:00:00'); } if ($dateTo) { $complaintQuery->where('created_at', '<=', $dateTo . ' 23:59:59'); }` | Filter - Menerapkan Filter Rentang Tanggal pada Query | VALID |
| 4 | `$totalComplaints = (clone $complaintQuery)->count();` | Statistik - Menghitung Total Keluhan dalam Periode | VALID |
| 5 | `$complaintsByStatus = (clone $complaintQuery)->select('status', DB::raw('count(*) as total'))->groupBy('status')->get();` | Statistik - Keluhan per Status dalam Periode | VALID |
| 6 | `$complaintsByPriority = (clone $complaintQuery)->select('priority', DB::raw('count(*) as total'))->groupBy('priority')->get();` | Statistik - Keluhan per Prioritas dalam Periode | VALID |
| 7 | `$topProducts = (clone $complaintQuery)->select('product_name', DB::raw('count(*) as total'))->groupBy('product_name')->orderBy('total', 'desc')->limit(10)->get();` | Statistik - 10 Produk dengan Keluhan Terbanyak | VALID |
| 8 | `$topProblems = (clone $complaintQuery)->select('problem_type', DB::raw('count(*) as total'))->groupBy('problem_type')->orderBy('total', 'desc')->limit(10)->get();` | Statistik - 10 Jenis Masalah Terbanyak | VALID |
| 9 | `$dailyTrend = (clone $complaintQuery)->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))->groupBy('date')->orderBy('date', 'asc')->get();` | Statistik - Tren Keluhan Harian | VALID |
| 10 | `$adminPerformance = User::where('role', 'admin')->withCount(['assignedComplaints as total_assigned', 'assignedComplaints as total_resolved' => ...])->get();` | Statistik - Performa Admin (Total Ditugaskan dan Diselesaikan) | VALID |
| 11 | `$avgResolutionTime = (clone $complaintQuery)->whereNotNull('resolved_at')->selectRaw('AVG(DATEDIFF(resolved_at, created_at)) as avg_days')->value('avg_days');` | Statistik - Rata-rata Waktu Penyelesaian (dalam hari) | VALID |
| 12 | `$resolutionRate = $totalComplaints > 0 ? round(($resolvedCount / $totalComplaints) * 100, 2) : 0;` | Perhitungan - Menghitung Persentase Tingkat Penyelesaian | VALID |
| 13 | `Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');` | Fitur Export - Route Download Laporan CSV | VALID |
| 14 | `$filename = 'laporan_keluhan_' . ($dateFrom ?: 'all') . '_to_' . ($dateTo ?: 'all') . '.csv';` | Export - Membuat Nama File CSV Berdasarkan Periode | VALID |
| 15 | `fputcsv($file, ['No. Keluhan', 'Tanggal', 'Nama User', 'Email User', 'Produk', 'Jenis Masalah', 'Deskripsi', 'Status', 'Prioritas', 'Admin', 'Respon Admin', 'Tanggal Selesai']);` | Export - Menulis Header CSV | VALID |
| 16 | `foreach ($complaints as $complaint) { fputcsv($file, [$complaint->complaint_number, ...]); }` | Export - Menulis Data Keluhan ke CSV | VALID |
| 17 | `return response()->stream($callback, 200, $headers);` | Selesai - Mengirim File CSV untuk Didownload | VALID |
| 18 | `return view('admin.reports.index', compact('dateFrom', 'dateTo', 'totalComplaints', ...));` | Selesai - Menampilkan View Laporan dengan Semua Data Statistik | VALID |

---

## Rangkuman Hasil Pengujian White Box Testing

| No | Fitur yang Diuji | Jumlah Test Case | Status |
|----|-------------------|------------------|--------|
| 1 | Login | 11 | ✅ VALID |
| 2 | Register | 15 | ✅ VALID |
| 3 | Dashboard User | 12 | ✅ VALID |
| 4 | Keluhan User | 12 | ✅ VALID |
| 5 | Tambah Keluhan User | 13 | ✅ VALID |
| 6 | Detail Keluhan User | 12 | ✅ VALID |
| 7 | Riwayat User | 13 | ✅ VALID |
| 8 | Profil User | 17 | ✅ VALID |
| 9 | Dashboard Admin Laboratorium | 18 | ✅ VALID |
| 10 | Kelola Keluhan Admin | 10 | ✅ VALID |
| 11 | Edit Keluhan Admin | 14 | ✅ VALID |
| 12 | Detail Keluhan Admin | 12 | ✅ VALID |
| 13 | Kelola Solusi Admin | 9 | ✅ VALID |
| 14 | Tambah Solusi Admin | 13 | ✅ VALID |
| 15 | Edit Solusi Admin | 13 | ✅ VALID |
| 16 | Detail Solusi Admin | 12 | ✅ VALID |
| 17 | Manajemen User Admin | 12 | ✅ VALID |
| 18 | Laporan Admin | 18 | ✅ VALID |
| **Total** | **18 Fitur** | **226 Test Case** | **✅ ALL VALID** |

---

**Keterangan:**
- **VALID** = Source code berjalan sesuai dengan alur logika yang diharapkan
- Setiap tabel pengujian mengikuti alur flowchart dari **Mulai** hingga **Selesai**
- Pengujian mencakup: Routing, Tampilan (View), Validasi Input, Logika Bisnis, Query Database, dan Output/Redirect
