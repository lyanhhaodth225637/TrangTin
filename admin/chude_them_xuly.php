<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

ob_start(); // ✅ Bắt đầu buffering

include_once "../includes/config.php";
include_once "../includes/thuvien.php";

$TenChuDe = $_POST['TenChuDe'] ?? '';

if(trim($TenChuDe) == "") {
    ThongBaoLoi("Tên chủ đề không được bỏ trống!");
} else {
    $sql = "INSERT INTO `tbl_chude`(`TenChuDe`) VALUES ('$TenChuDe')";
    $danhsach = $connect->query($sql);
    
    if (!$danhsach) {
        die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
    } else {
        header("Location: index.php?do=chude");
        exit(); // ✅ Đảm bảo không có gì chạy sau redirect
    }
}

ob_end_flush(); // ✅ Gửi output nếu có (chỉ khi cần thiết)
?>
