<?php

session_start();

$konfig = "mysql:host=localhost;dbname=db_kopi_katalog;";

try {
    $koneksi = new PDO($konfig, 'root', '');
} catch (PDOException $e) {
    $error = $e->getMessage();
}

$id = $_GET['id'] ?? '';

$query = "DELETE FROM tb_menu WHERE id_menu = :id_menu";
$komando = $koneksi -> prepare($query);
$komando -> execute([
    ":id_menu" => $id
]);
$result = $komando -> fetch(PDO::FETCH_ASSOC);

header("location:index.php");
exit();

?>