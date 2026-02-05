<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Complaint;
use App\Models\Solution;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin CS',
            'email' => 'admin@esabumindo.com',
            'nik' => 'ADM001',
            'jabatan' => 'Administrator',
            'departemen' => 'IT & CS',
            'phone' => '081234567890',
            'address' => 'Jakarta Pusat',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Create Regular Users
        $user1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'nik' => 'EMP001',
            'jabatan' => 'Staff Produksi',
            'departemen' => 'Produksi',
            'phone' => '081234567891',
            'address' => 'Bandung, Jawa Barat',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $user2 = User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
            'nik' => 'EMP002',
            'jabatan' => 'Supervisor QC',
            'departemen' => 'Quality Control',
            'phone' => '081234567892',
            'address' => 'Surabaya, Jawa Timur',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Create Sample Complaints
        Complaint::create([
            'user_id' => $user1->id,
            'complaint_number' => 'CPL-20240101-0001',
            'product_name' => 'Super Glue 50ml',
            'problem_type' => 'Tidak Merekat dengan Baik',
            'description' => 'Lem yang saya beli tidak bisa merekat dengan kuat. Sudah dicoba beberapa kali tetapi tetap mudah lepas.',
            'incident_date' => now()->subDays(2),
            'status' => 'in_progress',
            'priority' => 'high',
            'assigned_to' => $admin->id,
        ]);

        Complaint::create([
            'user_id' => $user2->id,
            'complaint_number' => 'CPL-20240101-0002',
            'product_name' => 'Wood Glue 100ml',
            'problem_type' => 'Cepat Kering',
            'description' => 'Lem kayu yang saya beli cepat sekali mengering bahkan sebelum diaplikasikan.',
            'incident_date' => now()->subDays(1),
            'status' => 'submitted',
            'priority' => 'medium',
        ]);

        Complaint::create([
            'user_id' => $user1->id,
            'complaint_number' => 'CPL-20240101-0003',
            'product_name' => 'Epoxy Resin',
            'problem_type' => 'Bau Menyengat',
            'description' => 'Produk memiliki bau yang sangat menyengat dan membuat pusing saat digunakan.',
            'incident_date' => now()->subDays(3),
            'status' => 'resolved',
            'priority' => 'low',
            'assigned_to' => $admin->id,
            'admin_response' => 'Sudah kami ganti dengan produk baru yang lebih baik.',
            'resolved_at' => now(),
        ]);

        // Create Sample Solutions
        $solution1 = Solution::create([
            'title' => 'Solusi Lem Tidak Merekat',
            'problem_category' => 'Daya Rekat Lemah',
            'solution_description' => 'Pastikan permukaan bersih dan kering sebelum aplikasi. Bersihkan dari debu, minyak, atau kotoran.',
            'technical_steps' => '1. Bersihkan permukaan dengan alkohol\n2. Keringkan sempurna\n3. Aplikasikan lem tipis merata\n4. Tekan kuat selama 30 detik\n5. Diamkan 24 jam untuk hasil maksimal',
            'prevention_tips' => '- Simpan lem di tempat sejuk dan kering\n- Tutup rapat setelah digunakan\n- Periksa tanggal kedaluwarsa\n- Gunakan sesuai petunjuk',
            'is_active' => true,
            'usage_count' => 5,
            'created_by' => $admin->id,
        ]);

        $solution2 = Solution::create([
            'title' => 'Mengatasi Lem yang Cepat Mengering',
            'problem_category' => 'Pengeringan Cepat',
            'solution_description' => 'Lem yang cepat kering biasanya karena paparan udara atau suhu penyimpanan yang tidak tepat.',
            'technical_steps' => '1. Simpan di suhu ruangan (20-25°C)\n2. Hindari paparan sinar matahari langsung\n3. Tutup rapat setelah pemakaian\n4. Gunakan dalam waktu singkat setelah dibuka',
            'prevention_tips' => '- Beli sesuai kebutuhan\n- Periksa seal kemasan saat pembelian\n- Catat tanggal pembukaan pertama',
            'is_active' => true,
            'usage_count' => 3,
            'created_by' => $admin->id,
        ]);

        Solution::create([
            'title' => 'Penanganan Bau Lem yang Menyengat',
            'problem_category' => 'Bau Tidak Sedap',
            'solution_description' => 'Gunakan di area berventilasi baik dan gunakan masker jika perlu.',
            'technical_steps' => '1. Buka jendela untuk sirkulasi udara\n2. Gunakan kipas angin jika tersedia\n3. Pakai masker saat aplikasi\n4. Istirahat sejenak jika merasa pusing\n5. Cuci tangan setelah penggunaan',
            'prevention_tips' => '- Pilih produk low-VOC\n- Gunakan sarung tangan\n- Jangan gunakan di ruang tertutup\n- Jauhkan dari anak-anak',
            'is_active' => true,
            'usage_count' => 2,
            'created_by' => $admin->id,
        ]);

        echo "Database seeded successfully!\n";
        echo "Admin Login: admin@esabumindo.com / admin123\n";
        echo "User Login: budi@example.com / password123\n";
    }
}