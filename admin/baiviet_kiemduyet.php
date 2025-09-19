<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once "../includes/config.php";
include_once "../includes/thuvien.php";

// Chỉ admin mới được truy cập
if (!isset($_SESSION['QuyenHan']) || $_SESSION['QuyenHan'] != 1) {
    echo "Bạn không có quyền truy cập trang này.";
    exit();
}

// Truy vấn các bài viết chưa duyệt
$sql = "SELECT A.MaBaiViet, A.TieuDe, A.NgayDang, B.TenChuDe, C.TenNguoiDung
        FROM tbl_noidungtin A
        JOIN tbl_chude B ON A.MaChuDe = B.MaChuDe
        JOIN tbl_nguoidung C ON A.MaNguoiDung = C.MaNguoiDung
        WHERE A.KiemDuyet = 0
        ORDER BY A.NgayDang DESC";

$result = $connect->query($sql);

if (!$result) {
    echo "Lỗi truy vấn: " . $connect->error;
    exit();
}
?>

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<style>
    h3 {
        color: #990000;
        font-weight: bold;
        text-align: center;
        margin-top: 20px;
        margin-bottom: 25px;
    }

    table.DanhSach {
        width: 90%;
        margin: 0 auto;
        border-collapse: collapse;
        background-color: #fbe2e2;
        border: 1px solid #990000;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(153, 0, 0, 0.2);
        font-family: Arial, sans-serif;
    }

    table.DanhSach th,
    table.DanhSach td {
        padding: 12px 15px;
        text-align: center;
        border-bottom: 1px solid #d69c9c;
    }

    table.DanhSach th {
        background-color: #990000;
        color: white;
    }

    table.DanhSach tr:nth-child(even) {
        background-color: #f9dede;
    }

    table.DanhSach tr:hover {
        background-color: #f4c7c7;
        transition: 0.2s;
    }

    .icon-action {
        margin: 0 10px;
        font-size: 18px;
    }

    .icon-approve {
        color: #28a745;
    }

    .icon-delete {
        color: #dc3545;
    }

    .icon-approve:hover,
    .icon-delete:hover {
        transform: scale(1.2);
        transition: 0.2s;
    }

    table.DanhSach td a {
        text-decoration: none; /* bỏ gạch chân */
        color: inherit; /* màu chữ kế thừa, nếu muốn giữ màu như bình thường */
    }

    table.DanhSach td a:hover {
        text-decoration: underline; /* có thể cho hiện gạch chân khi hover, tùy chọn */
        color: #990000; /* màu đỏ khi hover, bạn có thể thay đổi */
    }
</style>

<h3>Danh sách bài viết đang chờ duyệt</h3>

<?php
if ($result->num_rows == 0) {
    echo '<p style="text-align:center;">Không có bài viết nào đang chờ duyệt.</p>';
} else {
    echo '<table class="DanhSach">';
    echo '<tr>';
    echo '<th>STT</th>';
    echo '<th>Tiêu đề</th>';
    echo '<th>Chủ đề</th>';
    echo '<th>Tác giả</th>';
    echo '<th>Ngày đăng</th>';
    echo '<th>Thao tác</th>';
    echo '</tr>';

    $index = 1;
    while ($row = $result->fetch_assoc()) {
        $id = $row['MaBaiViet'];
        $tieude = htmlspecialchars($row['TieuDe']);
        $chude = htmlspecialchars($row['TenChuDe']);
        $tacgia = htmlspecialchars($row['TenNguoiDung']);
        $ngaydang = $row['NgayDang'];

        echo '<tr>';
        echo '<td>' . $index++ . '</td>';
        echo '<td><a href="index.php?do=baiviet_chitiet&id=' . $id . '">' . $tieude . '</a></td>';
        echo '<td>' . $chude . '</td>';
        echo '<td>' . $tacgia . '</td>';
        echo '<td>' . $ngaydang . '</td>';
        echo '<td>';
        echo '<a href="index.php?do=baiviet_kichhoat&id=' . $id . '&duyet=1" class="icon-action" title="Duyệt" onclick="return confirm(\'Duyệt bài viết này?\')"><i class="fas fa-check-circle icon-approve"></i></a>';
        echo '<a href="index.php?do=baiviet_kichhoat&id=' . $id . '&xoa=1" class="icon-action" title="Xóa" onclick="return confirm(\'Bạn có chắc muốn xóa bài viết này?\')"><i class="fas fa-trash-alt icon-delete"></i></a>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
}
?>
