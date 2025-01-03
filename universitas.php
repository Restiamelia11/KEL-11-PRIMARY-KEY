<?php
// Include database connection configuration
include('config/db.php');

// Initialize variables
$id_univ = "";
$nama_univ = "";

// Menampilkan data universitas
$query = "SELECT * FROM universitas";
$result = mysqli_query($conn, $query);

// Menambahkan universitas
if (isset($_POST['add_univ'])) {
    $nama_univ = $_POST['nama_univ'];
    $sql = "INSERT INTO universitas (nama_univ) VALUES ('$nama_univ')";
    mysqli_query($conn, $sql);
    header("Location: universitas.php");
}

// Menghapus universitas
if (isset($_GET['delete'])) {
    $id_univ = $_GET['delete'];
    $sql = "DELETE FROM universitas WHERE id_univ = $id_univ";
    mysqli_query($conn, $sql);
    header("Location: universitas.php");
}

// Edit universitas
if (isset($_GET['edit'])) {
    $id_univ = $_GET['edit'];
    // Fetch the current data of the university
    $sql = "SELECT * FROM universitas WHERE id_univ = $id_univ";
    $result_edit = mysqli_query($conn, $sql);
    $row_edit = mysqli_fetch_assoc($result_edit);
    $nama_univ = $row_edit['nama_univ'];
}

// Update universitas after edit
if (isset($_POST['edit_univ'])) {
    $id_univ = $_POST['id_univ'];
    $nama_univ = $_POST['nama_univ'];
    $sql = "UPDATE universitas SET nama_univ = '$nama_univ' WHERE id_univ = $id_univ";
    mysqli_query($conn, $sql);
    header("Location: universitas.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Universitas</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Manajemen Universitas</h1>

    <!-- Form untuk menambah universitas -->
    <h3>Tambah Universitas</h3>
    <form method="POST">
        <input type="text" name="nama_univ" placeholder="Nama Universitas" required>
        <button type="submit" name="add_univ">Tambah Universitas</button>
    </form>

    <?php if (isset($_GET['edit'])): ?>
    <!-- Form untuk mengedit universitas -->
    <h3>Edit Universitas</h3>
    <form method="POST">
        <input type="hidden" name="id_univ" value="<?php echo $id_univ; ?>">
        <input type="text" name="nama_univ" value="<?php echo $nama_univ; ?>" required>
        <button type="submit" name="edit_univ">Update Universitas</button>
    </form>
    <?php endif; ?>

    <!-- Tabel untuk menampilkan universitas -->
    <h3>Daftar Universitas</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama Universitas</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['id_univ']; ?></td>
                <td><?php echo $row['nama_univ']; ?></td>
                <td>
                    <a href="universitas.php?delete=<?php echo $row['id_univ']; ?>">Hapus</a> |
                    <a href="universitas.php?edit=<?php echo $row['id_univ']; ?>">Edit</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
