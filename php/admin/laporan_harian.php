<?php
include '../config.php'; // Koneksi ke database

// Ambil data pemesanan untuk laporan harian
$sql = "SELECT * FROM pemesanan WHERE tanggal >= DATE_SUB(CURDATE(), INTERVAL 1 DAY)";

$result = mysqli_query($conn, $sql);

$total_harga_harian = 0; // Variabel untuk menyimpan total harga harian

        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Laporan Harian Pemesanan - Daams Cafe</title>";
        echo "<link rel='stylesheet' href='laporan_harian.css'>"; // Menggunakan CSS yang dibuat khusus
        echo "</head>";
        echo "<body>";
        echo "<header>";
        echo "<nav>";
        echo "<ul>";
        echo "<li><a href='admin_dashboard.php'>Home</a></li>";
        echo "<li><a href='kelola_menu.php'>Kelola Menu</a></li>";
        echo "<li><a href='kelola_products.php'>Kelola Products</a></li>";
        echo "<li><a href='kelola_pengguna.php'>Kelola Pengguna</a></li>";
        echo "<li><a href='kelola_pemesanan.php'>Kelola Pemesanan</a></li>";
        echo "<li><a href='kelola_meja.php'>Kelola Meja</a></li>";
        echo "<li><a href='kelola_reservasi.php'>Kelola Reservasi</a></li>";
        echo "</ul>";
        echo "</nav>";
        echo "</header>";
        echo "<div class='report-container'>";

if (mysqli_num_rows($result) > 0) {
    echo "<h2>Laporan Harian Pemesanan</h2>";
    echo "<table>
            <tr>
                <th>ID Pemesanan</th>
                <th>ID Menu</th>
                <th>ID Pengguna</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>ID Metode</th>
                <th>Total Harga</th>
            </tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        $total_harga_harian += $row['total_harga']; // Tambahkan harga ke total harga harian
        echo "<tr>
                <td>{$row['id_pemesanan']}</td>
                <td>{$row['id_menu']}</td>
                <td>{$row['id_pengguna']}</td>
                <td>{$row['jumlah']}</td>
                <td>{$row['tanggal']}</td>
                <td>{$row['id_metode']}</td>
                <td>" . number_format($row['total_harga'], 2, ',', '.') . "</td>
            </tr>";
    }
    echo "</table>";
    echo "<h3>Total Harga Harian: Rp " . number_format($total_harga_harian, 2, ',', '.') . "</h3>";
} else {
    echo "<p>Tidak ada data pemesanan untuk hari ini.</p>";
}

echo "</div>";
echo "</body>";
echo "</html>";

mysqli_close($conn);
?>
