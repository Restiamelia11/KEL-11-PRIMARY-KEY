<?php
include('config/db.php');

// Menampilkan data fakultas
$query = "SELECT * FROM fakultas";
$result = mysqli_query($conn, $query);

// Menambahkan fakultas
if (isset($_POST['add_fakultas'])) {
    $id_univ = $_POST['id_univ'];
    $nama_fk = $_POST['nama_fk'];
    $sql = "INSERT INTO fakultas (id_univ, nama_fk) VALUES ('$id_univ', '$nama_fk')";
    mysqli_query($conn, $sql);
    header("Location: fakultas.php");
    exit();
}

// Menghapus fakultas
if (isset($_GET['delete'])) {
    $id_fk = $_GET['delete'];
    $sql = "DELETE FROM fakultas WHERE id_fk = $id_fk";
    mysqli_query($conn, $sql);
    header("Location: fakultas.php");
    exit();
}

// Mengambil data untuk form edit
if (isset($_GET['id_fk'])) {
    $id_fk = $_GET['id_fk'];
    $edit_query = "SELECT * FROM fakultas WHERE id_fk = $id_fk";
    $edit_result = mysqli_query($conn, $edit_query);
    $edit_row = mysqli_fetch_assoc($edit_result);
}

// Edit fakultas
if (isset($_POST['edit_fakultas'])) {
    $id_fk = $_POST['id_fk'];
    $id_univ = $_POST['id_univ'];
    $nama_fk = $_POST['nama_fk'];
    $sql = "UPDATE fakultas SET nama_fk = '$nama_fk', id_univ = '$id_univ' WHERE id_fk = $id_fk";
    mysqli_query($conn, $sql);
    header("Location: fakultas.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Fakultas</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Manajemen Fakultas</h1>

    <!-- Form Tambah Fakultas -->
    <h2>Tambah Fakultas</h2>
    <form method="POST">
        <input type="text" name="nama_fk" placeholder="Nama Fakultas" required>
        <select name="id_univ" required>
            <?php
                $universitas_query = "SELECT * FROM universitas";
                $universitas_result = mysqli_query($conn, $universitas_query);
                while ($row = mysqli_fetch_assoc($universitas_result)) {
                    echo "<option value='" . $row['id_univ'] . "'>" . $row['nama_univ'] . "</option>";
                }
            ?>
        </select>
        <button type="submit" name="add_fakultas">Tambah Fakultas</button>
    </form>

    <!-- Form Edit Fakultas -->
    <?php if (isset($edit_row)) { ?>
    <h2>Edit Fakultas</h2>
    <form method="POST">
        <input type="hidden" name="id_fk" value="<?php echo $edit_row['id_fk']; ?>">
        <input type="text" name="nama_fk" value="<?php echo $edit_row['nama_fk']; ?>" required>
        <select name="id_univ" required>
            <?php
                $universitas_query = "SELECT * FROM universitas";
                $universitas_result = mysqli_query($conn, $universitas_query);
                while ($row = mysqli_fetch_assoc($universitas_result)) {
                    $selected = ($edit_row['id_univ'] == $row['id_univ']) ? 'selected' : '';
                    echo "<option value='" . $row['id_univ'] . "' $selected>" . $row['nama_univ'] . "</option>";
                }
            ?>
        </select>
        <button type="submit" name="edit_fakultas">Update Fakultas</button>
    </form>
    <?php } ?>

    <!-- Tabel Data Fakultas -->
    <h2>Data Fakultas</h2>
    <table>
        <tr>
            <th>Nama Fakultas</th>
            <th>Universitas</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['nama_fk']; ?></td>
                <td><?php echo $row['id_univ']; ?></td>
                <td>
                    <a href="fakultas.php?delete=<?php echo $row['id_fk']; ?>">Hapus</a> |
                    <a href="fakultas.php?id_fk=<?php echo $row['id_fk']; ?>">Edit</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
