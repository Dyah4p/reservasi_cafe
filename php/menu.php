<?php
include 'config.php';

$menu_items = [];
$nama_pengguna = isset($_GET['nama_pengguna']) ? $_GET['nama_pengguna'] : '';

// Mendapatkan data dari tabel menu
$sql = "SELECT * FROM menu";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_pengguna = $_POST['nama_pengguna'];
    $tanggal = date("Y-m-d");
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $menu_items = isset($_POST['menu']) ? json_decode($_POST['menu'], true) : [];

    if (empty($menu_items)) {
        die("Data menu tidak terkirim atau format JSON salah.");
    }

    // Mendapatkan ID pengguna berdasarkan nama pengguna
    $sql_pengguna = "SELECT id_pengguna FROM pengguna WHERE nama_pengguna = '$nama_pengguna'";
    $result_pengguna = mysqli_query($conn, $sql_pengguna);

    if (!$result_pengguna) {
        die("Query gagal: " . mysqli_error($conn));
    }

    $row_pengguna = mysqli_fetch_assoc($result_pengguna);
    if (!$row_pengguna) {
        die("Pengguna tidak ditemukan.");
    }

    $id_pengguna = $row_pengguna['id_pengguna'];
    $total_harga = 0;
    $pemesanan_ids = [];

    // Memasukkan data pemesanan ke tabel pemesanan
    $stmt = $conn->prepare("INSERT INTO pemesanan (id_menu, id_pengguna, jumlah, tanggal, id_metode, total_harga) VALUES (?, ?, ?, ?, ?, ?)");

    foreach ($menu_items as $menu_item) {
        $id_menu = $menu_item['id_menu'];
        $jumlah = $menu_item['jumlah'];
        $harga = $menu_item['harga'];

        // Mendapatkan ID pembayaran berdasarkan nama metode pembayaran
        $sql_pembayaran = "SELECT id_metode FROM metode_pembayaran WHERE nama_metode = '$metode_pembayaran'";
        $result_pembayaran = mysqli_query($conn, $sql_pembayaran);
        if (!$result_pembayaran) {
            die("Query gagal: " . mysqli_error($conn));
        }
        $row_pembayaran = mysqli_fetch_assoc($result_pembayaran);
        $id_metode = $row_pembayaran['id_metode'];

        // Hitung total harga untuk item
        $total_harga_item = $harga * $jumlah;
        $total_harga += $total_harga_item;

        // Eksekusi prepared statement
        $stmt->bind_param("iiisis", $id_menu, $id_pengguna, $jumlah, $tanggal, $id_metode, $total_harga_item);
        if (!$stmt->execute()) {
            die("Gagal menyimpan pesanan: " . $stmt->error);
        }

        // Mengumpulkan ID pemesanan
        $pemesanan_ids[] = $stmt->insert_id;
    }

    // Redirect ke halaman konfirmasi
    $confirmation_message = "Pesanan berhasil disimpan dengan total harga: Rp " . number_format($total_harga, 0, ',', '.') . "!";
    header("Location: konfirmasi_pemesanan.php?message=" . urlencode($confirmation_message) . "&nama_pengguna=" . urlencode($nama_pengguna) . "&pemesanan_ids=" . urlencode(implode(',', $pemesanan_ids)));
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu & Order - Daams Cafe</title>
    <link rel="stylesheet" href="menu.css?v=1.0">
    <style>
        .menu-controls {
            display: flex;
            align-items: center;
        }
        .menu-controls > div {
            margin-right: 10px;
        }
        .menu-controls select {
            min-width: 150px;
        }
        .menu-images {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 10px;
        }
        .menu-image-item {
            margin: 10px;
            text-align: center;
        }
        .menu-image-item img {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
        }
        .order-item img {
            max-width: 50px;
            max-height: 50px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="order-container">
        <h2>Menu & Pesanan</h2>
        <p>Selamat datang, <?php echo htmlspecialchars($nama_pengguna, ENT_QUOTES, 'UTF-8'); ?>!</p>
        <div class="order-content">
            <div class="menu-selection">
                <h3>Pilih Menu</h3>
                <div class="menu-controls">
                    <div>
                        <select id="nama_menu" name="nama_menu">
                            <option value="" data-gambar="" data-harga="" data-stok="">Pilih Menu</option>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <option value="<?php echo $row['id_menu']; ?>" data-gambar="<?php echo $row['gambar']; ?>" data-harga="<?php echo $row['harga']; ?>" data-stok="<?php echo $row['stok']; ?>"><?php echo $row['nama_menu']; ?> (Stok: <?php echo $row['stok']; ?>)</option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div>
                        <label for="jumlah_menu">Jumlah:</label>
                        <input type="number" id="jumlah_menu" name="jumlah_menu" min="1">
                    </div>
                    <button type="button" onclick="addMenu()">Tambah Menu</button>
                </div>
                <div class="menu-images">
                    <?php mysqli_data_seek($result, 0); while ($row = mysqli_fetch_assoc($result)): ?>
                        <div class="menu-image-item">
                            <img src="../images/<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama_menu']; ?>">
                            <p><?php echo $row['nama_menu']; ?></p>
                            <p>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
                            <p>Stok: <?php echo $row['stok']; ?></p>
                        </div>
                    <?php endwhile; ?>
                </div>
                <ul id="selected_menus"></ul>
            </div>
            <div class="order-form">
                <h3>Daftar Pesanan</h3>
                <div class="order-list"></div>
                <form method="post" action="">
                    <input type="hidden" name="menu" id="menu-input">
                    <label for="nama_pengguna">Nama Pengguna:</label>
                    <input type="text" id="nama_pengguna" name="nama_pengguna" value="<?php echo htmlspecialchars($nama_pengguna, ENT_QUOTES, 'UTF-8'); ?>" required>

                    <label for="metode_pembayaran">Metode Pembayaran:</label>
                    <select id="metode_pembayaran" name="metode_pembayaran" required>
                        <?php
                        $sql_pembayaran = "SELECT * FROM metode_pembayaran";
                        $result_pembayaran = mysqli_query($conn, $sql_pembayaran);
                        if (!$result_pembayaran) {
                            die("Query gagal: " . mysqli_error($conn));
                        }
                        while ($row_pembayaran = mysqli_fetch_assoc($result_pembayaran)) {
                            echo '<option value="' . htmlspecialchars($row_pembayaran['nama_metode'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($row_pembayaran['nama_metode'], ENT_QUOTES, 'UTF-8') . '</option>';
                        }
                        ?>
                    </select>

                    <p>Total Harga: Rp <span id="total-harga">0</span></p>

                    <button type="submit">Pesan</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let menuItems = [];

        function addMenu() {
            const selectedMenu = document.getElementById('nama_menu');
            const jumlahMenu = document.getElementById('jumlah_menu').value;
            const selectedOption = selectedMenu.options[selectedMenu.selectedIndex];
            const menuId = selectedOption.value;
            const menuName = selectedOption.text;
            const menuHarga = selectedOption.getAttribute('data-harga');
            const menuStok = selectedOption.getAttribute('data-stok');

            if (!menuId || !jumlahMenu || jumlahMenu <= 0) {
                alert("Pilih menu yang valid dan tentukan jumlah yang benar.");
                return;
            }

            if (parseInt(menuStok) < parseInt(jumlahMenu)) {
                alert("Stok tidak mencukupi.");
                return;
            }

            // Mengecek apakah menu sudah ada dalam daftar
            let menuExists = false;
            for (let item of menuItems) {
                if (item.id_menu === menuId) {
                    item.jumlah += parseInt(jumlahMenu);
                    menuExists = true;
                    break;
                }
            }

            // Jika menu belum ada, tambahkan ke daftar
            if (!menuExists) {
                menuItems.push({
                    id_menu: menuId,
                    nama_menu: menuName,
                    harga: parseInt(menuHarga),
                    jumlah: parseInt(jumlahMenu)
                });
            }

            // Update tampilan daftar pesanan
            updateOrderList();
        }

        // Fungsi untuk memperbarui daftar pesanan dan total harga
        function updateOrderList() {
            const orderList = document.querySelector('.order-list');
            orderList.innerHTML = ''; // Reset daftar pesanan

            let totalHarga = 0;
            menuItems.forEach(item => {
                const listItem = document.createElement('div');
                listItem.classList.add('order-item');
                listItem.innerHTML = `
                    <span>${item.nama_menu} (x${item.jumlah})</span>
                    <span>Rp ${item.harga * item.jumlah}</span>
                    <button type="button" onclick="removeMenu(${item.id_menu})">Hapus</button>
                `;
                orderList.appendChild(listItem);
                totalHarga += item.harga * item.jumlah;
            });

            // Update total harga di form
            document.getElementById('total-harga').textContent = totalHarga.toLocaleString('id-ID');
            // Update input menu dalam format JSON untuk dikirim ke server
            document.getElementById('menu-input').value = JSON.stringify(menuItems);
        }

        // Fungsi untuk menghapus item menu dari daftar
        function removeMenu(menuId) {
            menuItems = menuItems.filter(item => item.id_menu !== menuId);
            updateOrderList();
        }
    </script>
</body>
</html>

