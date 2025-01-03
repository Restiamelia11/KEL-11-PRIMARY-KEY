<?php
include('includes/header.php');
include('config/db.php');

// Handle Add Akreditasi
if (isset($_POST['submit'])) {
    $kode_dikti = $_POST['kode_dikti'];
    $kode_lam = $_POST['kode_lam'];
    $tgl_mulai_akreditasi = $_POST['tgl_mulai_akreditasi'];
    $tgl_akhir_akreditasi = $_POST['tgl_akhir_akreditasi'];
    $status_akreditasi = $_POST['status_akreditasi'];

    $stmt = $conn->prepare("INSERT INTO histori_akreditasi (kode_dikti, kode_lam, tgl_mulai_akreditasi, tgl_akhir_akreditasi, status_akreditasi) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $kode_dikti, $kode_lam, $tgl_mulai_akreditasi, $tgl_akhir_akreditasi, $status_akreditasi);

    if ($stmt->execute()) {
        header("Location: akreditasi.php?message=success_add");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Handle Edit Akreditasi
$edit_data = [];
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $stmt = $conn->prepare("SELECT * FROM histori_akreditasi WHERE id_history = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_data = $result->fetch_assoc();

    if (!$edit_data) {
        echo "<p style='color: red;'>Data yang diminta tidak ditemukan.</p>";
    } elseif (isset($_POST['update'])) {
        $kode_dikti = $_POST['kode_dikti'];
        $kode_lam = $_POST['kode_lam'];
        $tgl_mulai_akreditasi = $_POST['tgl_mulai_akreditasi'];
        $tgl_akhir_akreditasi = $_POST['tgl_akhir_akreditasi'];
        $status_akreditasi = $_POST['status_akreditasi'];

        $stmt = $conn->prepare("UPDATE histori_akreditasi SET kode_dikti = ?, kode_lam = ?, tgl_mulai_akreditasi = ?, tgl_akhir_akreditasi = ?, status_akreditasi = ? WHERE id_history = ?");
        $stmt->bind_param("sssssi", $kode_dikti, $kode_lam, $tgl_mulai_akreditasi, $tgl_akhir_akreditasi, $status_akreditasi, $edit_id);

        if ($stmt->execute()) {
            header("Location: akreditasi.php?message=success_edit");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}

// Handle Delete Akreditasi
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM histori_akreditasi WHERE id_history = ?");
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        header("Location: akreditasi.php?message=success_delete");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch all Akreditasi data
$result = $conn->query("SELECT * FROM histori_akreditasi");
?>

<div class="container">
    <h2>Kelola Akreditasi</h2>

    <!-- Add Akreditasi Form -->
    <h3>Tambah Akreditasi</h3>
    <form method="POST">
        <label for="kode_dikti">Kode Dikti</label>
        <input type="text" id="kode_dikti" name="kode_dikti" required>

        <label for="kode_lam">Kode LAM</label>
        <input type="text" id="kode_lam" name="kode_lam" required>

        <label for="tgl_mulai_akreditasi">Tanggal Mulai Akreditasi</label>
        <input type="date" id="tgl_mulai_akreditasi" name="tgl_mulai_akreditasi" required>

        <label for="tgl_akhir_akreditasi">Tanggal Akhir Akreditasi</label>
        <input type="date" id="tgl_akhir_akreditasi" name="tgl_akhir_akreditasi" required>

        <label for="status_akreditasi">Status Akreditasi</label>
        <input type="text" id="status_akreditasi" name="status_akreditasi" required>

        <button type="submit" name="submit">Tambah Akreditasi</button>
    </form>

    <!-- Display All Akreditasi -->
    <h3>Daftar Akreditasi</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Kode Dikti</th>
                <th>Kode LAM</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Akhir</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id_history']; ?></td>
                    <td><?php echo $row['kode_dikti']; ?></td>
                    <td><?php echo $row['kode_lam']; ?></td>
                    <td><?php echo $row['tgl_mulai_akreditasi']; ?></td>
                    <td><?php echo $row['tgl_akhir_akreditasi']; ?></td>
                    <td><?php echo $row['status_akreditasi']; ?></td>
                    <td>
                        <a href="akreditasi.php?edit_id=<?php echo $row['id_history']; ?>">Edit</a> | 
                        <a href="akreditasi.php?delete_id=<?php echo $row['id_history']; ?>" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Edit Akreditasi Form -->
    <?php if (!empty($edit_data)): ?>
        <h3>Edit Akreditasi</h3>
        <form method="POST">
            <label for="kode_dikti">Kode Dikti</label>
            <input type="text" id="kode_dikti" name="kode_dikti" value="<?php echo $edit_data['kode_dikti']; ?>" required>

            <label for="kode_lam">Kode LAM</label>
            <input type="text" id="kode_lam" name="kode_lam" value="<?php echo $edit_data['kode_lam']; ?>" required>

            <label for="tgl_mulai_akreditasi">Tanggal Mulai Akreditasi</label>
            <input type="date" id="tgl_mulai_akreditasi" name="tgl_mulai_akreditasi" value="<?php echo $edit_data['tgl_mulai_akreditasi']; ?>" required>

            <label for="tgl_akhir_akreditasi">Tanggal Akhir Akreditasi</label>
            <input type="date" id="tgl_akhir_akreditasi" name="tgl_akhir_akreditasi" value="<?php echo $edit_data['tgl_akhir_akreditasi']; ?>" required>

            <label for="status_akreditasi">Status Akreditasi</label>
            <input type="text" id="status_akreditasi" name="status_akreditasi" value="<?php echo $edit_data['status_akreditasi']; ?>" required>

            <button type="submit" name="update">Update Akreditasi</button>
        </form>
    <?php endif; ?>
</div>

<?php include('includes/footer.php'); ?>
