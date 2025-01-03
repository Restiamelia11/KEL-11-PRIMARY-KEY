<?php
include('config/db.php');

// Handle Create
if (isset($_POST['submit'])) {
    $nama_lam = $_POST['nama_lam'];

    $sql = "INSERT INTO lam (nama_lam) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nama_lam);

    if ($stmt->execute()) {
        echo "Data LAM berhasil ditambahkan!";
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
}

// Handle Update
if (isset($_POST['update'])) {
    $id_lam = $_POST['id_lam'];
    $nama_lam = $_POST['nama_lam'];

    $sql = "UPDATE lam SET nama_lam = ? WHERE id_lam = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nama_lam, $id_lam);

    if ($stmt->execute()) {
        echo "Data LAM berhasil diperbarui!";
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
}

// Handle Delete
if (isset($_GET['delete_id'])) {
    $id_lam = $_GET['delete_id'];

    $sql = "DELETE FROM lam WHERE id_lam = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_lam);

    if ($stmt->execute()) {
        echo "Data LAM berhasil dihapus!";
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
}

// Fetch All Data
$sql = "SELECT * FROM lam";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola LAM</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Kelola LAM</h2>

        <!-- Form Tambah LAM -->
        <h3>Tambah LAM</h3>
        <form method="POST">
            <label for="nama_lam">Nama LAM</label>
            <input type="text" id="nama_lam" name="nama_lam" required>
            <button type="submit" name="submit">Tambah</button>
        </form>

        <!-- Tabel Data LAM -->
        <h3>Daftar LAM</h3>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama LAM</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_lam']; ?></td>
                        <td><?php echo $row['nama_lam']; ?></td>
                        <td>
                            <a href="?edit_id=<?php echo $row['id_lam']; ?>">Edit</a> | 
                            <a href="?delete_id=<?php echo $row['id_lam']; ?>">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Form Edit LAM -->
        <?php if (isset($_GET['edit_id'])): ?>
            <?php
            $edit_id = $_GET['edit_id'];
            $sql = "SELECT * FROM lam WHERE id_lam = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $edit_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            ?>
            <h3>Edit LAM</h3>
            <form method="POST">
                <input type="hidden" name="id_lam" value="<?php echo $row['id_lam']; ?>">
                <label for="nama_lam">Nama LAM</label>
                <input type="text" id="nama_lam" name="nama_lam" value="<?php echo $row['nama_lam']; ?>" required>
                <button type="submit" name="update">Update</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
