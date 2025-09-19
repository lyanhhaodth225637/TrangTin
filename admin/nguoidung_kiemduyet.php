<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once '../includes/config.php';

// Chỉ admin mới được truy cập
if (!isset($_SESSION['QuyenHan']) || $_SESSION['QuyenHan'] != 1) {
    echo "Bạn không có quyền truy cập trang này.";
    exit();
}

// Truy vấn người dùng chưa duyệt
$sql = "SELECT MaNguoiDung, TenNguoiDung, TenDangNhap FROM tbl_nguoidung WHERE TrangThai = 0 ORDER BY MaNguoiDung DESC";
$result = $connect->query($sql);

if (!$result) {
    echo "Lỗi truy vấn: " . $connect->error;
    exit();
}
?>

<style>
    h3 {
        text-align: center;
        margin-top: 20px;
        color: #333;
    }

    table {
        width: 90%;
        margin: 20px auto;
        border-collapse: collapse;
        background-color: #f9f9f9;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    th, td {
        border: 1px solid #ccc;
        padding: 12px;
        text-align: center;
    }

    th {
        background-color: #990000;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .btn {
        padding: 6px 12px;
        text-decoration: none;
        border-radius: 4px;
        color: white;
        font-weight: bold;
        margin: 0 5px;
    }

    .btn.duyet {
        background-color: #28a745;
    }

    .btn.xoa {
        background-color: #dc3545;
    }

    .btn:hover {
        opacity: 0.85;
    }

    p.center {
        text-align: center;
    }
</style>

<h3>Danh sách người dùng đang chờ duyệt</h3>

<?php
if ($result->num_rows === 0) {
    echo '<p class="center">Không có người dùng nào đang chờ duyệt.</p>';
} else {
    echo '<table>';
    echo '<tr><th>STT</th><th>Tên người dùng</th><th>Tên đăng nhập</th><th>Thao tác</th></tr>';
    $i = 1;
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $i++ . '</td>';
        echo '<td>' . htmlspecialchars($row['TenNguoiDung']) . '</td>';
        echo '<td>' . htmlspecialchars($row['TenDangNhap']) . '</td>';
        echo '<td>';
        echo '<a class="btn duyet" href="index.php?do=nguoidung_kichhoat&id=' . $row['MaNguoiDung'] . '&duyet=1" onclick="return confirm(\'Bạn có chắc muốn duyệt tài khoản này?\')">Duyệt</a>';
        echo '<a class="btn xoa" href="index.php?do=nguoidung_kichhoat&id=' . $row['MaNguoiDung'] . '&xoa=1" onclick="return confirm(\'Bạn có chắc muốn xóa tài khoản này?\')">Xóa</a>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
}
?>
