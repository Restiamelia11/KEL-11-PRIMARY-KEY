<?php
include('includes/header.php');
include('config/db.php');

// Handle Add LPA
if (isset($_POST['submit'])) {
    $nama_lpa = $_POST['nama_lpa'];

    // Prepared statement for insert
    $stmt = $conn->prepare("INSERT INTO LPA (nama_LPA) VALUES (?)");
    $stmt->bind_param("s", $nama_lpa);

    if ($stmt->execute()) {
        echo "LPA berhasil ditambahkan!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Handle Edit LPA
$row = null; // Default null untuk mencegah error
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];

    // Prepared statement for select
    $stmt = $conn->prepare("SELECT * FROM LPA WHERE id_LPA = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if ($row) {
        if (isset($_POST['update'])) {
            $nama_lpa = $_POST['nama_lpa'];

            // Prepared statement for update
            $update_stmt = $conn->prepare("UPDATE LPA SET nama_LPA = ? WHERE id_LPA = ?");
            $update_stmt->bind_param("si", $nama_lpa, $edit_id);

            if ($update_stmt->execute()) {
                echo "Data LPA berhasil diperbarui!";
                $update_stmt->close();
                header("Location: lpa.php");
                exit;
            } else {
                echo "Error: " . $update_stmt->error;
            }
        }
    } else {
        echo "Data LPA tidak ditemukan.";
    }
}

// Handle Delete LPA
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Prepared statement for delete
    $delete_stmt = $conn->prepare("DELETE FROM LPA WHERE id_LPA = ?");
    $delete_stmt->bind_param("i", $delete_id);

    if ($delete_stmt->execute()) {
        echo "LPA berhasil dihapus!";
        $delete_stmt->close();
        header("Location: lpa.php");
        exit;
    } else {
        echo "Error: " . $delete_stmt->error;
    }
}

// Fetch all LPA data
$sql = "SELECT * FROM LPA";
$result = $conn->query($sql);
?>

<div class="container">
    <h2>Kelola LPA</h2>

    <!-- Add LPA Form -->
    <h3>Tambah LPA</h3>
    <form method="POST">
        <label for="nama_lpa">Nama LPA</label>
        <input type="text" id="nama_lpa" name="nama_lpa" required>
        <button type="submit" name="submit">Tambah LPA</button>
    </form>

    <!-- Display All LPA -->
    <h3>Daftar LPA</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama LPA</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row_data = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row_data['id_LPA']); ?></td>
                    <td><?php echo htmlspecialchars($row_data['nama_LPA']); ?></td>
                    <td>
                        <a href="lpa.php?edit_id=<?php echo $row_data['id_LPA']; ?>">Edit</a> | 
                        <a href="lpa.php?delete_id=<?php echo $row_data['id_LPA']; ?>" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Edit LPA Form (if editing) -->
    <?php if (isset($edit_id) && $row): ?>
        <h3>Edit LPA</h3>
        <form method="POST">
            <label for="nama_lpa">Nama LPA</label>
            <input type="text" id="nama_lpa" name="nama_lpa" value="<?php echo htmlspecialchars($row['nama_LPA']); ?>" required>
            <button type="submit" name="update">Update LPA</button>
        </form>
    <?php endif; ?>
</div>

<?php include('includes/footer.php'); ?>
