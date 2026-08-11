@extends('layouts.admin')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen User</h2>
            <p class="text-gray-600">Kelola akun user dan verifikasi pendaftaran karyawan baru</p>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3">
        <i class="fas fa-check-circle text-green-500 text-xl"></i>
        <p class="text-green-700 font-medium">{{ session('success') }}</p>
    </div>
    @endif
    @if(session('error'))
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-center gap-3">
        <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
        <p class="text-red-700 font-medium">{{ session('error') }}</p>
    </div>
    @endif

    {{-- Statistics --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="bg-white rounded-xl p-5 shadow-md border-l-4 border-blue-500">
            <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Total User</p>
            <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalUsers }}</h3>
            <i class="fas fa-users text-blue-400 text-2xl mt-2"></i>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-md border-l-4 border-yellow-500 relative overflow-hidden">
            @if($pendingUsers > 0)
            <div class="absolute top-2 right-2 w-3 h-3 bg-yellow-400 rounded-full animate-ping"></div>
            @endif
            <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Menunggu</p>
            <h3 class="text-3xl font-bold text-yellow-600 mt-1">{{ $pendingUsers }}</h3>
            <i class="fas fa-hourglass-half text-yellow-400 text-2xl mt-2"></i>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-md border-l-4 border-green-500">
            <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Aktif</p>
            <h3 class="text-3xl font-bold text-green-600 mt-1">{{ $activeUsers }}</h3>
            <i class="fas fa-check-circle text-green-400 text-2xl mt-2"></i>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-md border-l-4 border-gray-400">
            <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Nonaktif</p>
            <h3 class="text-3xl font-bold text-gray-500 mt-1">{{ $inactiveUsers }}</h3>
            <i class="fas fa-user-slash text-gray-400 text-2xl mt-2"></i>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-md border-l-4 border-red-500">
            <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Ditolak</p>
            <h3 class="text-3xl font-bold text-red-600 mt-1">{{ $rejectedUsers }}</h3>
            <i class="fas fa-ban text-red-400 text-2xl mt-2"></i>
        </div>
    </div>

    {{-- Pending Alert Banner --}}
    @if($pendingUsers > 0)
    <div class="bg-yellow-50 border-2 border-yellow-300 rounded-xl p-5 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center flex-shrink-0 animate-pulse">
                <i class="fas fa-bell text-white text-xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-yellow-800 text-lg">Ada {{ $pendingUsers }} Pendaftaran Menunggu Verifikasi!</h3>
                <p class="text-yellow-700 text-sm">Segera tinjau dan verifikasi pendaftaran akun karyawan baru di bawah ini.</p>
            </div>
        </div>
        <a href="{{ route('admin.users.index', ['registration_status' => 'pending']) }}" 
           class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg font-semibold transition whitespace-nowrap">
            Lihat Sekarang
        </a>
    </div>
    @endif

    {{-- Filters --}}
    <div class="bg-white rounded-xl shadow-md p-6">
        <form method="GET" action="{{ route('admin.users.index') }}" class="grid md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Cari User</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                    placeholder="Nama, email, NIK, telepon...">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Status Verifikasi</label>
                <select name="registration_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="pending"  {{ request('registration_status') == 'pending'  ? 'selected' : '' }}>⏳ Menunggu</option>
                    <option value="approved" {{ request('registration_status') == 'approved' ? 'selected' : '' }}>✅ Disetujui</option>
                    <option value="rejected" {{ request('registration_status') == 'rejected' ? 'selected' : '' }}>❌ Ditolak</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                    <i class="fas fa-search mr-1"></i> Cari
                </button>
                <a href="{{ route('admin.users.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-semibold transition">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>
    </div>

    {{-- Users Table --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        @if($users->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Karyawan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">NIK / Jabatan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Keluhan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status Verifikasi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status Akun</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Terdaftar</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50 transition {{ $user->isPending() ? 'bg-yellow-50 hover:bg-yellow-100' : '' }}">
                        {{-- Nama & Email --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 font-bold text-white
                                    {{ $user->isPending() ? 'bg-yellow-400' : ($user->isApproved() ? 'bg-purple-500' : 'bg-red-400') }}">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- NIK & Jabatan --}}
                        <td class="px-6 py-4">
                            <p class="text-sm font-mono font-semibold text-gray-700">{{ $user->nik ?? '-' }}</p>
                            <p class="text-xs text-gray-500">{{ $user->jabatan ?? '-' }} • {{ $user->departemen ?? '-' }}</p>
                        </td>

                        {{-- Total Keluhan --}}
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $user->complaints_count }} keluhan
                            </span>
                        </td>

                        {{-- Status Verifikasi --}}
                        <td class="px-6 py-4">
                            @if($user->isPending())
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-300">
                                    <i class="fas fa-hourglass-half mr-1 animate-pulse"></i>Menunggu
                                </span>
                            @elseif($user->isApproved())
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>Disetujui
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i>Ditolak
                                </span>
                            @endif
                        </td>

                        {{-- Status Aktif --}}
                        <td class="px-6 py-4">
                            @if($user->is_active)
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-circle mr-1"></i>Aktif
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">
                                    <i class="fas fa-circle mr-1"></i>Nonaktif
                                </span>
                            @endif
                        </td>

                        {{-- Tanggal Daftar --}}
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-600">{{ $user->created_at->format('d M Y') }}</p>
                            <p class="text-xs text-gray-400">{{ $user->created_at->format('H:i') }}</p>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2 flex-wrap">

                                {{-- Tombol Approve (untuk pending) --}}
                                @if($user->isPending())
                                <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                                    @csrf @method('PUT')
                                    <button type="submit" 
                                        onclick="return confirm('Setujui pendaftaran {{ $user->name }} (NIK: {{ $user->nik }})?\n\nUser akan dapat login setelah disetujui.')"
                                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition flex items-center gap-1">
                                        <i class="fas fa-check"></i> Setujui
                                    </button>
                                </form>

                                {{-- Tombol Reject (untuk pending) --}}
                                <button onclick="openRejectModal({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition flex items-center gap-1">
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                                @endif

                                {{-- Toggle Aktif/Nonaktif (hanya untuk approved) --}}
                                @if($user->isApproved())
                                <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}">
                                    @csrf @method('PUT')
                                    <button type="submit"
                                        class="text-xs font-medium px-3 py-1.5 rounded-lg border transition
                                            {{ $user->is_active 
                                                ? 'border-red-300 text-red-600 hover:bg-red-50' 
                                                : 'border-green-300 text-green-600 hover:bg-green-50' }}">
                                        @if($user->is_active)
                                            <i class="fas fa-ban mr-1"></i>Nonaktifkan
                                        @else
                                            <i class="fas fa-check mr-1"></i>Aktifkan
                                        @endif
                                    </button>
                                </form>
                                @endif

                                {{-- Hapus (untuk rejected) --}}
                                @if($user->isRejected())
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Hapus akun {{ $user->name }} secara permanen dari sistem?')"
                                        class="text-xs font-medium px-3 py-1.5 rounded-lg border border-red-300 text-red-600 hover:bg-red-50 transition">
                                        <i class="fas fa-trash mr-1"></i>Hapus
                                    </button>
                                </form>
                                @endif

                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $users->appends(request()->query())->links() }}
        </div>
        @else
        <div class="text-center py-16">
            <i class="fas fa-users text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak Ada User</h3>
            <p class="text-gray-500">Belum ada user yang terdaftar dengan filter ini</p>
        </div>
        @endif
    </div>
</div>

{{-- Modal Tolak Pendaftaran --}}
<div id="rejectModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black bg-opacity-50 backdrop-blur-sm" onclick="closeRejectModal()"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 relative">
            <button onclick="closeRejectModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>

            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-times-circle text-red-500 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Tolak Pendaftaran</h3>
                <p id="rejectUserName" class="text-gray-500 text-sm mt-1"></p>
            </div>

            <form id="rejectForm" method="POST">
                @csrf @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Alasan Penolakan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="rejection_reason" rows="4" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent resize-none"
                        placeholder="Contoh: NIK tidak terdaftar dalam sistem kepegawaian, data tidak valid, bukan karyawan aktif, dll..."></textarea>
                    <p class="text-xs text-gray-400 mt-1">Alasan ini akan dapat dilihat oleh user saat mencoba login.</p>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="closeRejectModal()"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-2.5 rounded-lg font-semibold transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 bg-red-500 hover:bg-red-600 text-white py-2.5 rounded-lg font-semibold transition">
                        <i class="fas fa-times mr-1"></i>Tolak Pendaftaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openRejectModal(userId, userName) {
    document.getElementById('rejectModal').classList.remove('hidden');
    document.getElementById('rejectUserName').textContent = 'Pendaftaran: ' + userName;
    document.getElementById('rejectForm').action = '/admin/users/' + userId + '/reject';
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}
</script>
@endsection