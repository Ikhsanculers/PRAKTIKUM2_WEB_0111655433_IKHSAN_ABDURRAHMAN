<?php

session_start();

$konfig = "mysql:host=localhost;dbname=db_kopi_katalog;";

try {
    $koneksi = new PDO($konfig, 'root', '');
} catch (PDOException $e) {
    $error = $e->getMessage();
}

if (isset($_POST['tambah'])) {
    $id = '';
    $kode_menu = $_POST['kode'];
    $nama_menu = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $status_promo = $_POST['status'];

    if (empty($kode_menu) || empty($nama_menu) || empty($kategori)) {
        $error = "Semua field wajib diisi !";
    } elseif ($harga <= 0) {
        $error = "Harga harus lebih dari 0 !";
    } else {
        try {
            $query = "INSERT INTO tb_menu (id_menu, kode_menu, nama_menu, kategori, harga, status_promo) VALUES (:id_menu, :kode_menu, :nama_menu, :kategori, :harga, :status_promo)";
            $komando = $koneksi -> prepare($query);
            $komando ->execute([
                ":id_menu" => $id,
                ":kode_menu" => $kode_menu,
                ":nama_menu" => $nama_menu,
                ":kategori" => $kategori,
                ":harga" => $harga,
                ":status_promo" => $status_promo
            ]);

            header("location:index.php");
        } catch (PDOException $e) {
            if ($e -> errorInfo[1] == 1026) {
                $error = "kode '$kode_menu' menu sudah digunakan!";
            } else {
                $error = "Terjadi kesalahan pada" . $e -> getMessage();
            }
        }
        
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu - Kopi Nusantara</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f7f5f0;
            color: #333333;
            padding: 35px 20px;
        }
        .form-card {
            max-width: 580px;
            margin: 0 auto;
            background: #ffffff;
            padding: 35px;
            border-radius: 12px;
            border: 1px solid #e0d5c1;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        }
        .form-header {
            margin-bottom: 25px;
            border-bottom: 1px solid #efebe9;
            padding-bottom: 15px;
        }
        .form-header h2 {
            color: #4e342e;
            font-size: 22px;
            margin-bottom: 5px;
        }
        .form-header p {
            color: #795548;
            font-size: 13px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-group label {
            display: block;
            margin-bottom: 7px;
            font-size: 13px;
            font-weight: 600;
            color: #4e342e;
        }
        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #d7ccc8;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-control:focus {
            border-color: #6d4c41;
        }
        .btn-group {
            display: flex;
            gap: 12px;
            margin-top: 25px;
        }
        .btn-save {
            flex: 2;
            padding: 11px;
            background-color: #4e342e;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .btn-save:hover {
            background-color: #3e2723;
        }
        .btn-back {
            flex: 1;
            padding: 11px;
            background-color: #efebe9;
            color: #5d4037;
            text-align: center;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            transition: background-color 0.2s;
        }
        .btn-back:hover {
            background-color: #d7ccc8;
        }

        .alert-box {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
            display: block;
        }
    </style>
</head>
<body>

    <div class="form-card">
        <div class="form-header">
            <h2>Tambah Menu Baru</h2>
            <p>Masukkan rincian informasi menu sajian baru ke dalam katalog</p>
        </div>

        <?php if (isset($error)) : ?>
            <div class="alert-box">
                <span><?= $error ?></span>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>Kode Menu</label>
                <input type="text" class="form-control" name="kode" placeholder="Contoh: CF-003">
            </div>

            <div class="form-group">
                <label>Nama Menu</label>
                <input type="text" class="form-control" name="nama" placeholder="Contoh: Caramel Macchiato">
            </div>

            <div class="form-group">
                <label>Kategori Sajian</label>
                <select name="kategori" class="form-control">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Kopi">Kopi</option>
                    <option value="Non-Kopi">Non-Kopi</option>
                    <option value="Makanan Ringan">Makanan Ringan</option>
                </select>
            </div>

            <div class="form-group">
                <label>Harga Normal (Rupiah)</label>
                <input type="number" class="form-control" name="harga" placeholder="Contoh: 25000">
            </div>

            <div class="form-group">
                <label>Status Program Promo</label>
                <select name="status" class="form-control">
                    <option value="Tidak">Tidak Ada Promo</option>
                    <option value="Ya">Promo Aktif (Diskon 10%)</option>
                </select>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn-save" name="tambah">Simpan Menu</button>
                <a href="index.php" class="btn-back">Batal</a>
            </div>
        </form>
    </div>

</body>
</html>