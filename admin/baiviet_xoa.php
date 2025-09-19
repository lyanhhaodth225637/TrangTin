<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kết nối CSDL nếu chưa có
include_once "../includes/config.php";

if (isset($_GET['id'])) {
    $MaBV = intval($_GET['id']); // Ép kiểu an toàn

    // Xóa bài viết
    $sql = "DELETE FROM `tbl_noidungtin` WHERE MaBaiViet = $MaBV";
    $danhsach = $connect->query($sql);

    if (!$danhsach) {
        die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
    } else {
        // Xác định nơi cần quay lại
        $returnTo = isset($_GET['returnto']) ? $_GET['returnto'] : 'baiviet';
        header("Location: index.php?do=" . urlencode($returnTo));
        exit();
    }
} else {
    echo "Thiếu ID bài viết cần xóa.";
}
?>
