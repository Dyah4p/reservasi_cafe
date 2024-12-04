<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tambah'])) {
        $nama_menu = $_POST['nama_menu'];
        $kategori = $_POST['kategori'];
        $harga = $_POST['harga'];
        $gambar = $_POST['gambar'];
        $stok = $_POST['stok'];
        $sql = "INSERT INTO menu (nama_menu, kategori, harga, gambar, stok) VALUES ('$nama_menu', '$kategori', '$harga', '$gambar', '$stok')";
        if (mysqli_query($conn, $sql)) {
            echo "Menu berhasil ditambahkan!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } elseif (isset($_POST['hapus'])) {
        $id_menu = $_POST['id_menu'];
        $sql = "DELETE FROM menu WHERE id_menu = '$id_menu'";
        if (mysqli_query($conn, $sql)) {
            echo "Menu berhasil dihapus!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } elseif (isset($_POST['edit'])) {
        $id_menu = $_POST['id_menu'];
        $nama_menu = $_POST['nama_menu'];
        $kategori = $_POST['kategori'];
        $harga = $_POST['harga'];
        $gambar = $_POST['gambar'];
        $stok = $_POST['stok'];
        $sql = "UPDATE menu SET nama_menu = '$nama_menu', kategori = '$kategori', harga = '$harga', gambar = '$gambar', stok = '$stok' WHERE id_menu = '$id_menu'";
        if (mysqli_query($conn, $sql)) {
            echo "Menu berhasil diperbarui!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Menu</title>
    <link rel="stylesheet" href="kelola_menu.css">
</head>
<body>
    <div class="container">
        <nav>
            <ul class="horizontal-nav">
                <li><a href="kelola_menu.php">Kelola Menu</a></li>
                <li><a href="kelola_products.php">Kelola Products</a></li>
                <li><a href="kelola_meja.php">Kelola Meja</a></li>
                <li><a href="kelola_pengguna.php">Kelola Pengguna</a></li>
                <li><a href="kelola_pemesanan.php">Kelola Pemesanan</a></li>
                <li><a href="kelola_reservasi.php">Kelola Reservasi</a></li>
                <li><a href="laporan_harian.php">Laporan Harian</a></li>
            </ul>
        </nav>
        
        <h2>Kelola Menu</h2>
        <form method="POST" action="">
            <input type="hidden" name="id_menu" id="id_menu">
            <label for="nama_menu">Nama Menu:</label>
            <input type="text" name="nama_menu" id="nama_menu" required>
            <label for="kategori">Kategori:</label>
            <input type="text" name="kategori" id="kategori" required>
            <label for="harga">Harga:</label>
            <input type="number" name="harga" id="harga" required>
            <label for="gambar">Gambar:</label>
            <input type="text" name="gambar" id="gambar" required>
            <label for="stok">Stok:</label>
            <input type="number" name="stok" id="stok" required>
            <button type="submit" name="tambah">Tambah</button>
        </form>

        <h2>Daftar Menu</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Gambar</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM menu";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['id_menu']}</td>";
                    echo "<td>{$row['nama_menu']}</td>";
                    echo "<td>{$row['kategori']}</td>";
                    echo "<td>{$row['harga']}</td>";
                    echo "<td><img src='../images/{$row['gambar']}' alt='{$row['nama_menu']}' width='50'></td>";
                    echo "<td>{$row['stok']}</td>";
                    echo "<td>
                            <button type='button' onclick=\"editMenu('{$row['id_menu']}', '{$row['nama_menu']}', '{$row['kategori']}', '{$row['harga']}', '{$row['gambar']}', '{$row['stok']}')\">Edit</button>
                            <form method='POST' action='' style='display:inline;'>
                                <input type='hidden' name='id_menu' value='{$row['id_menu']}'>
                                <button type='submit' name='hapus'>Hapus</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function editMenu(id, nama, kategori, harga, gambar, stok) {
            document.getElementById('id_menu').value = id;
            document.getElementById('nama_menu').value = nama;
            document.getElementById('kategori').value = kategori;
            document.getElementById('harga').value = harga;
            document.getElementById('gambar').value = gambar;
            document.getElementById('stok').value = stok;
        }
    </script>
</body>
</html>

<?php
mysqli_close($conn);
?>
