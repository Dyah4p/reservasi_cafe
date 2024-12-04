<?php
include 'config.php';

// Validasi parameter
if (!isset($_GET['message'], $_GET['nama_pengguna'], $_GET['pemesanan_ids'])) {
    die("Data konfirmasi tidak lengkap.");
}

$message = urldecode($_GET['message']);
$nama_pengguna = urldecode($_GET['nama_pengguna']);
$pemesanan_ids = explode(',', urldecode($_GET['pemesanan_ids']));

if (empty($pemesanan_ids)) {
    die("Tidak ada data pemesanan yang ditemukan.");
}

// Query untuk mendapatkan data pemesanan
$sql = "SELECT m.nama_menu, SUM(p.jumlah) AS total_jumlah, SUM(p.total_harga) AS total_harga_menu
        FROM pemesanan p
        JOIN menu m ON p.id_menu = m.id_menu
        WHERE p.id_pemesanan IN (" . implode(',', array_fill(0, count($pemesanan_ids), '?')) . ")
        GROUP BY m.nama_menu";

$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('i', count($pemesanan_ids)), ...$pemesanan_ids);
$stmt->execute();
$result = $stmt->get_result();

$pemesanan_data = [];
$total_harga = 0;

// Proses hasil query
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pemesanan_data[] = $row;
        $total_harga += $row['total_harga_menu'];
    }
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesanan - Daams Cafe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .confirmation-container {
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            background: #f9f9f9;
        }
        .menu-list {
            margin-top: 20px;
        }
        .menu-item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .menu-item:last-child {
            border-bottom: none;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="confirmation-container">
        <h2>Konfirmasi Pesanan</h2>
        <p><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
        <p>Nama Pengguna: <?php echo htmlspecialchars($nama_pengguna, ENT_QUOTES, 'UTF-8'); ?></p>
        <p>Tanggal Pesan: <?php echo date("Y-m-d"); ?></p>
        
        <h3>Menu yang Dipesan:</h3>
        <div class="menu-list">
            <?php if (!empty($pemesanan_data)): ?>
                <?php foreach ($pemesanan_data as $pesanan): ?>
                    <div class="menu-item">
                        <p>Nama Menu: <?php echo htmlspecialchars($pesanan['nama_menu'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p>Jumlah Dipesan: <?php echo htmlspecialchars($pesanan['total_jumlah'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p>Total Harga: Rp <?php echo number_format($pesanan['total_harga_menu'], 0, ',', '.'); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Tidak ada menu yang dipesan.</p>
            <?php endif; ?>
        </div>
        
        <p class="total">Total Harga Semua Pesanan: Rp <?php echo number_format($total_harga, 0, ',', '.'); ?></p>
    </div>

    <script>
        // Data menu yang dipesan dalam format JSON (bisa diambil dari form atau API)
        const menuItems = <?php echo json_encode($pemesanan_data); ?>;

        function renderOrder() {
            const orderList = document.querySelector('.menu-list');
            const totalHargaElement = document.querySelector('.total');
            let totalHarga = 0;
            
            orderList.innerHTML = ''; // Reset daftar pesanan

            menuItems.forEach(item => {
                const menuItemElement = document.createElement('div');
                menuItemElement.classList.add('menu-item');

                // Menambahkan nama, jumlah, dan harga menu ke dalam daftar
                const menuItemName = document.createElement('p');
                menuItemName.textContent = `Nama Menu: ${item.nama_menu}`;
                menuItemElement.appendChild(menuItemName);

                const menuItemQty = document.createElement('p');
                menuItemQty.textContent = `Jumlah Dipesan: ${item.total_jumlah}`;
                menuItemElement.appendChild(menuItemQty);

                const menuItemPrice = document.createElement('p');
                menuItemPrice.textContent = `Total Harga: Rp ${item.total_harga_menu.toLocaleString()}`;
                menuItemElement.appendChild(menuItemPrice);

                totalHarga += item.total_harga_menu;
                orderList.appendChild(menuItemElement);
            });

            // Update total harga di halaman
            totalHargaElement.textContent = `Total Harga Semua Pesanan: Rp ${totalHarga.toLocaleString()}`;
        }

        // Menampilkan pesanan
        renderOrder();
    </script>
</body>
</html>
