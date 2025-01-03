<?php
include('config/db.php');

// Menampilkan data prodi
$query = "SELECT prodi.*, universitas.nama_univ, fakultas.nama_fk, LPA.nama_LPA 
          FROM prodi 
          LEFT JOIN universitas ON prodi.id_univ = universitas.id_univ
          LEFT JOIN fakultas ON prodi.id_fk = fakultas.id_fk
          LEFT JOIN LPA ON prodi.id_LPA = LPA.id_LPA";
$result = mysqli_query($conn, $query);

// Menambahkan prodi
if (isset($_POST['add_prodi'])) {
    $nama_prodi = mysqli_real_escape_string($conn, $_POST['nama_prodi']);
    $jenjang = mysqli_real_escape_string($conn, $_POST['jenjang']);
    $tgl_sk_pendirian = mysqli_real_escape_string($conn, $_POST['tgl_sk_pendirian']);
    $no_sk_pendirian = mysqli_real_escape_string($conn, $_POST['no_sk_pendirian']);
    $id_LPA = mysqli_real_escape_string($conn, $_POST['id_LPA']);
    $id_fk = mysqli_real_escape_string($conn, $_POST['id_fk']);
    $id_univ = mysqli_real_escape_string($conn, $_POST['id_univ']);

    if (!empty($nama_prodi) && !empty($jenjang) && !empty($tgl_sk_pendirian) && !empty($no_sk_pendirian) 
        && !empty($id_LPA) && !empty($id_fk) && !empty($id_univ)) {
        $sql = "INSERT INTO prodi (nama_prodi, jenjang, tgl_sk_pendirian, no_sk_pendirian, id_LPA, id_fk, id_univ) 
                VALUES ('$nama_prodi', '$jenjang', '$tgl_sk_pendirian', '$no_sk_pendirian', '$id_LPA', '$id_fk', '$id_univ')";
        mysqli_query($conn, $sql);
        header("Location: prodi.php");
    } else {
        echo "<script>alert('Semua field harus diisi!');</script>";
    }
}

// Menghapus prodi
if (isset($_GET['delete'])) {
    $kode_dikti = $_GET['delete'];
    $sql = "DELETE FROM prodi WHERE kode_dikti = $kode_dikti";
    mysqli_query($conn, $sql);
    header("Location: prodi.php");
}

// Edit prodi
if (isset($_POST['edit_prodi'])) {
    $kode_dikti = mysqli_real_escape_string($conn, $_POST['kode_dikti']);
    $nama_prodi = mysqli_real_escape_string($conn, $_POST['nama_prodi']);
    $jenjang = mysqli_real_escape_string($conn, $_POST['jenjang']);
    $tgl_sk_pendirian = mysqli_real_escape_string($conn, $_POST['tgl_sk_pendirian']);
    $no_sk_pendirian = mysqli_real_escape_string($conn, $_POST['no_sk_pendirian']);
    $id_LPA = mysqli_real_escape_string($conn, $_POST['id_LPA']);
    $id_fk = mysqli_real_escape_string($conn, $_POST['id_fk']);
    $id_univ = mysqli_real_escape_string($conn, $_POST['id_univ']);

    $sql = "UPDATE prodi 
            SET nama_prodi = '$nama_prodi', jenjang = '$jenjang', tgl_sk_pendirian = '$tgl_sk_pendirian', 
                no_sk_pendirian = '$no_sk_pendirian', id_LPA = '$id_LPA', id_fk = '$id_fk', id_univ = '$id_univ' 
            WHERE kode_dikti = '$kode_dikti'";
    mysqli_query($conn, $sql);
    header("Location: prodi.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Program Studi</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Manajemen Program Studi</h1>

    <!-- Form Tambah Program Studi -->
    <form method="POST">
        <input type="text" name="nama_prodi" placeholder="Nama Program Studi" required>
        <input type="text" name="jenjang" placeholder="Jenjang" required>
        <input type="date" name="tgl_sk_pendirian" required>
        <input type="text" name="no_sk_pendirian" placeholder="No. SK Pendirian" required>
        <select name="id_LPA" required>
            <option value="">Pilih LPA</option>
            <?php
            $lam_query = "SELECT * FROM LPA";
            $lam_result = mysqli_query($conn, $lam_query);
            while ($row = mysqli_fetch_assoc($lam_result)) {
                echo "<option value='" . $row['id_LPA'] . "'>" . $row['nama_LPA'] . "</option>";
            }
            ?>
        </select>
        <select name="id_fk" required>
            <option value="">Pilih Fakultas</option>
            <?php
            $fakultas_query = "SELECT * FROM fakultas";
            $fakultas_result = mysqli_query($conn, $fakultas_query);
            while ($row = mysqli_fetch_assoc($fakultas_result)) {
                echo "<option value='" . $row['id_fk'] . "'>" . $row['nama_fk'] . "</option>";
            }
            ?>
        </select>
        <select name="id_univ" required>
            <option value="">Pilih Universitas</option>
            <?php
            $universitas_query = "SELECT * FROM universitas";
            $universitas_result = mysqli_query($conn, $universitas_query);
            while ($row = mysqli_fetch_assoc($universitas_result)) {
                echo "<option value='" . $row['id_univ'] . "'>" . $row['nama_univ'] . "</option>";
            }
            ?>
        </select>
        <button type="submit" name="add_prodi">Tambah Program Studi</button>
    </form>

    <!-- Tabel Data Program Studi -->
    <table>
        <tr>
            <th>Kode Dikti</th>
            <th>Nama Program Studi</th>
            <th>Jenjang</th>
            <th>Tanggal SK Pendirian</th>
            <th>No. SK Pendirian</th>
            <th>Universitas</th>
            <th>Fakultas</th>
            <th>LPA</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['kode_dikti']; ?></td>
                <td><?php echo $row['nama_prodi']; ?></td>
                <td><?php echo $row['jenjang']; ?></td>
                <td><?php echo $row['tgl_sk_pendirian']; ?></td>
                <td><?php echo $row['no_sk_pendirian']; ?></td>
                <td><?php echo $row['nama_univ']; ?></td>
                <td><?php echo $row['nama_fk']; ?></td>
                <td><?php echo $row['nama_LPA']; ?></td>
                <td>
                    <a href="prodi.php?delete=<?php echo $row['kode_dikti']; ?>">Hapus</a>
                    <!-- Edit Form -->
                    <a href="prodi.php?edit=<?php echo $row['kode_dikti']; ?>">Edit</a>
                    <?php
                    if (isset($_GET['edit']) && $_GET['edit'] == $row['kode_dikti']) {
                    ?>
                        <form method="POST">
                            <input type="hidden" name="kode_dikti" value="<?php echo $row['kode_dikti']; ?>">
                            <input type="text" name="nama_prodi" value="<?php echo $row['nama_prodi']; ?>" required>
                            <input type="text" name="jenjang" value="<?php echo $row['jenjang']; ?>" required>
                            <input type="date" name="tgl_sk_pendirian" value="<?php echo $row['tgl_sk_pendirian']; ?>" required>
                            <input type="text" name="no_sk_pendirian" value="<?php echo $row['no_sk_pendirian']; ?>" required>
                            <select name="id_LPA" required>
                                <option value="<?php echo $row['id_LPA']; ?>"><?php echo $row['nama_LPA']; ?></option>
                                <?php
                                $lam_result = mysqli_query($conn, "SELECT * FROM LPA");
                                while ($lpa_row = mysqli_fetch_assoc($lam_result)) {
                                    echo "<option value='" . $lpa_row['id_LPA'] . "'>" . $lpa_row['nama_LPA'] . "</option>";
                                }
                                ?>
                            </select>
                            <select name="id_fk" required>
                                <option value="<?php echo $row['id_fk']; ?>"><?php echo $row['nama_fk']; ?></option>
                                <?php
                                $fakultas_result = mysqli_query($conn, "SELECT * FROM fakultas");
                                while ($fakultas_row = mysqli_fetch_assoc($fakultas_result)) {
                                    echo "<option value='" . $fakultas_row['id_fk'] . "'>" . $fakultas_row['nama_fk'] . "</option>";
                                }
                                ?>
                            </select>
                            <select name="id_univ" required>
                                <option value="<?php echo $row['id_univ']; ?>"><?php echo $row['nama_univ']; ?></option>
                                <?php
                                $universitas_result = mysqli_query($conn, "SELECT * FROM universitas");
                                while ($universitas_row = mysqli_fetch_assoc($universitas_result)) {
                                    echo "<option value='" . $universitas_row['id_univ'] . "'>" . $universitas_row['nama_univ'] . "</option>";
                                }
                                ?>
                            </select>
                            <button type="submit" name="edit_prodi">Update Program Studi</button>
                        </form>
                    <?php
                    }
                    ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
