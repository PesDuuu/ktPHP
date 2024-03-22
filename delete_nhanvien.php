<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$user_role = $_SESSION["role"];

if ($user_role !== 'admin') {
    header("Location: index.php");
    exit();
}

require_once("entities/nhanvien.class.php");

if (isset($_GET["id"])) {
    $maNV = $_GET["id"];
    $result = NhanVien::delete_nhanvien($maNV);
    if ($result) {
        header("Location: index.php?deleted");
    } else {
        header("Location: index.php?delete_failed");
    }
}
?>
