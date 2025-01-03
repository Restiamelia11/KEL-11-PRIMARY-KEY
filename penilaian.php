<?php
include('includes/header.php');
include('config/db.php');

// Handle Add Penilaian Mandiri
if (isset($_POST['submit'])) {
    $prodi_kode_dikti = $_POST['prodi_kode_dikti'];
    $prodi_LPA_id_LPA = $_POST['prodi_LPA_id_LPA'];
    $indikator = $_POST['indikator'];
    $elemen = $_POST['elemen'];
    $penilaian = $_POST['penilaian'];

    $sql = "INSERT INTO penilaian_mandiri (prodi_kode_dikti, prodi_LPA_id_LPA, indikator, elemen, penilaian) 
            VALUES ('$prodi_kode_dikti', '$prodi_LPA_id_LPA', '$indikator', '$elemen', '$penilaian')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Penilaian Mandiri berhasil ditambahkan!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Handle Edit Penilaian Mandiri
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $sql = "SELECT * FROM penilaian_mandiri WHERE id_penilaian_mandiri = $edit_id";
    $result = $conn->query($sql);
    $edit_row = $result->fetch_assoc();
}

// Handle Update Penilaian Mandiri
if (isset($_POST['update'])) {
    $id_penilaian_mandiri = $_POST['id_penilaian_mandiri'];
    $prodi_kode_dikti = $_POST['prodi_kode_dikti'];
    $prodi_LPA_id_LPA = $_POST['prodi_LPA_id_LPA'];
    $indikator = $_POST['indikator'];
    $elemen = $_POST['elemen'];
    $penilaian = $_POST['penilaian'];

    $sql = "UPDATE penilaian_mandiri 
            SET prodi_kode_dikti = '$prodi_kode_dikti', prodi_LPA_id_LPA = '$prodi_LPA_id_LPA', 
                indikator = '$indikator', elemen = '$elemen', penilaian = '$penilaian' 
            WHERE id_penilaian_mandiri = '$id_penilaian_mandiri'";

    if ($conn->query($sql) === TRUE) {
        echo "Penilaian Mandiri berhasil diperbarui!";
        header("Location: penilaian.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

// Handle Delete Penilaian Mandiri
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM penilaian_mandiri WHERE id_penilaian_mandiri = $delete_id";

    if ($conn->query($sql) === TRUE) {
        echo "Penilaian Mandiri berhasil dihapus!";
        header("Location: penilaian.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch all Penilaian Mandiri data
$sql = "SELECT * FROM penilaian_mandiri";
$result = $conn->query($sql);
?>

<div class="container">
    <h2>Kelola Penilaian Mandiri</h2>

    <!-- Add Penilaian Mandiri Form -->
    <h3>Tambah Penilaian Mandiri</h3>
    <form method="POST">
        <label for="prodi_kode_dikti">Kode Dikti</label>
        <input type="number" id="prodi_kode_dikti" name="prodi_kode_dikti" required>

        <label for="prodi_LPA_id_LPA">ID LPA</label>
        <input type="number" id="prodi_LPA_id_LPA" name="prodi_LPA_id_LPA" required>

        <label for="indikator">Indikator</label>
        <input type="text" id="indikator" name="indikator" required>

        <label for="elemen">Elemen</label>
        <input type="text" id="elemen" name="elemen" required>

        <label for="penilaian">Penilaian</label>
        <input type="text" id="penilaian" name="penilaian" required>

        <button type="submit" name="submit">Tambah Penilaian Mandiri</button>
    </form>

    <!-- Edit Penilaian Mandiri Form (Only if edit is requested) -->
    <?php if (isset($edit_row)): ?>
        <h3>Edit Penilaian Mandiri</h3>
        <form method="POST">
            <input type="hidden" name="id_penilaian_mandiri" value="<?php echo $edit_row['id_penilaian_mandiri']; ?>">

            <label for="prodi_kode_dikti">Kode Dikti</label>
            <input type="number" id="prodi_kode_dikti" name="prodi_kode_dikti" value="<?php echo $edit_row['prodi_kode_dikti']; ?>" required>

            <label for="prodi_LPA_id_LPA">ID LPA</label>
            <input type="number" id="prodi_LPA_id_LPA" name="prodi_LPA_id_LPA" value="<?php echo $edit_row['prodi_LPA_id_LPA']; ?>" required>

            <label for="indikator">Indikator</label>
            <input type="text" id="indikator" name="indikator" value="<?php echo $edit_row['indikator']; ?>" required>

            <label for="elemen">Elemen</label>
            <input type="text" id="elemen" name="elemen" value="<?php echo $edit_row['elemen']; ?>" required>

            <label for="penilaian">Penilaian</label>
            <input type="text" id="penilaian" name="penilaian" value="<?php echo $edit_row['penilaian']; ?>" required>

            <button type="submit" name="update">Update Penilaian Mandiri</button>
        </form>
    <?php endif; ?>

    <!-- Display All Penilaian Mandiri -->
    <h3>Daftar Penilaian Mandiri</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Kode Dikti</th>
                <th>ID LPA</th>
                <th>Indikator</th>
                <th>Elemen</th>
                <th>Penilaian</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id_penilaian_mandiri']; ?></td>
                    <td><?php echo $row['prodi_kode_dikti']; ?></td>
                    <td><?php echo $row['prodi_LPA_id_LPA']; ?></td>
                    <td><?php echo $row['indikator']; ?></td>
                    <td><?php echo $row['elemen']; ?></td>
                    <td><?php echo $row['penilaian']; ?></td>
                    <td>
                        <a href="penilaian.php?edit_id=<?php echo $row['id_penilaian_mandiri']; ?>">Edit</a> | 
                        <a href="penilaian.php?delete_id=<?php echo $row['id_penilaian_mandiri']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('includes/footer.php'); ?>
