<?php
// Memasukkan file header
include('includes/header.php');

// Koneksi ke database
include('config/db.php');

// Query untuk menghitung jumlah universitas
$query_universitas = "SELECT COUNT(*) AS total_universitas FROM universitas";
$result_universitas = mysqli_query($conn, $query_universitas);
$data_universitas = mysqli_fetch_assoc($result_universitas);

// Query untuk menghitung jumlah fakultas
$query_fakultas = "SELECT COUNT(*) AS total_fakultas FROM fakultas";
$result_fakultas = mysqli_query($conn, $query_fakultas);
$data_fakultas = mysqli_fetch_assoc($result_fakultas);

// Query untuk menghitung jumlah program studi
$query_prodi = "SELECT COUNT(*) AS total_prodi FROM prodi";
$result_prodi = mysqli_query($conn, $query_prodi);
$data_prodi = mysqli_fetch_assoc($result_prodi);

// Query untuk menghitung status akreditasi (contoh: jumlah akreditasi yang terverifikasi)
$query_akreditasi = "SELECT COUNT(*) AS total_akreditasi FROM histori_akreditasi WHERE status_akreditasi = 'Terakreditasi'";
$result_akreditasi = mysqli_query($conn, $query_akreditasi);
$data_akreditasi = mysqli_fetch_assoc($result_akreditasi);

?>

<!-- Main Content -->
<div class="container">
    <section class="dashboard">
        <h2>Dashboard Utama</h2>
        <p>Selamat datang di sistem Akreditasi dan Penilaian Mandiri. Di sini Anda bisa mengelola data universitas, fakultas, program studi, dan proses akreditasi.</p>

        <div class="stats">
            <?php if ($data_universitas['total_universitas'] > 0): ?>
                <div class="stat-item fade-in-up">
                    <h3>Total Universitas</h3>
                    <p><?php echo $data_universitas['total_universitas']; ?></p>
                </div>
            <?php else: ?>
                <div class="stat-item fade-in-up">
                    <h3>Total Universitas</h3>
                    <p>Tidak ada data universitas yang tersedia.</p>
                </div>
            <?php endif; ?>

            <?php if ($data_fakultas['total_fakultas'] > 0): ?>
                <div class="stat-item fade-in-up">
                    <h3>Total Fakultas</h3>
                    <p><?php echo $data_fakultas['total_fakultas']; ?></p>
                </div>
            <?php else: ?>
                <div class="stat-item fade-in-up">
                    <h3>Total Fakultas</h3>
                    <p>Tidak ada data fakultas yang tersedia.</p>
                </div>
            <?php endif; ?>

            <?php if ($data_prodi['total_prodi'] > 0): ?>
                <div class="stat-item fade-in-up">
                    <h3>Total Program Studi</h3>
                    <p><?php echo $data_prodi['total_prodi']; ?></p>
                </div>
            <?php else: ?>
                <div class="stat-item fade-in-up">
                    <h3>Total Program Studi</h3>
                    <p>Tidak ada data program studi yang tersedia.</p>
                </div>
            <?php endif; ?>

            
                </div>
    
        </div>

        <p>Gunakan menu di atas untuk mulai mengelola data atau melakukan pengisian penilaian mandiri.</p>
    </section>
</div>
<!-- End of Main Content -->

<?php
// Memasukkan file footer
include('includes/footer.php');

// Menutup koneksi database
mysqli_close($conn);
?>
