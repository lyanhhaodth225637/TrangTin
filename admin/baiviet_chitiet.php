<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once "../includes/config.php"; // đường dẫn tùy bạn
include_once "../includes/thuvien.php";

// Lấy ID bài viết
$MaBV = intval($_GET['id']); // tránh SQL Injection

// Kiểm tra quyền admin
$is_admin = (isset($_SESSION['QuyenHan']) && $_SESSION['QuyenHan'] == 1);

// Truy vấn bài viết (không kiểm tra KiemDuyet để admin xem được)
$sql = "SELECT A.*, B.TenChuDe, C.TenNguoiDung
        FROM tbl_noidungtin A
        JOIN tbl_chude B ON A.MaChuDe = B.MaChuDe
        JOIN tbl_nguoidung C ON A.MaNguoiDung = C.MaNguoiDung
        WHERE A.MaBaiViet = $MaBV";

$danhsach = $connect->query($sql);
if (!$danhsach || $danhsach->num_rows == 0) {
    die("Bài viết không tồn tại hoặc đã bị xóa.");
}

$dong = $danhsach->fetch_array(MYSQLI_ASSOC);

// Tăng lượt xem
$connect->query("UPDATE tbl_noidungtin SET LuotXem = LuotXem + 1 WHERE MaBaiViet = $MaBV");

// Lấy các bài viết liên quan (ẩn bài chưa duyệt nếu không phải admin)
$sql2 = "SELECT MaBaiViet, TieuDe, NgayDang
         FROM tbl_noidungtin
         WHERE MaChuDe = " . intval($dong['MaChuDe']) . " 
           AND MaBaiViet <> $MaBV"
           . ($is_admin ? "" : " AND KiemDuyet = 1") . "
         ORDER BY NgayDang DESC
         LIMIT 5";
$danhsach2 = $connect->query($sql2);

// Xử lý ảnh
$image_path = $dong["HinhAnh"];
if (strpos($image_path, 'images/') === 0) {
    $image_path = '../' . $image_path;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết bài viết</title>
    <style>
        .tieude-baiviet {
            font-size: 24px;
            color: #990000;
            font-weight: bold;
            margin-top: 20px;
            text-align: center;
        }
        .ThongTin {
            text-align: center;
            color: #333;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .TomTat {
            font-style: italic;
            margin: 15px 0;
            padding: 10px;
            background: #f2f2f2;
            border-left: 4px solid #990000;
        }
        .baivietchitiet-hinh {
            max-width: 100%;
            display: block;
            margin: auto;
            border-radius: 5px;
        }
        .ChuThichAnh {
            text-align: center;
            font-size: 13px;
            color: #666;
        }
        .NoiDung {
            margin-top: 20px;
            line-height: 1.7;
        }
        .tin-khac {
            margin-top: 30px;
            padding: 10px;
            border-top: 1px solid #ccc;
        }
        .tin-khac ul {
            list-style: none;
            padding-left: 0;
        }
        .tin-khac li {
            margin-bottom: 5px;
        }
        .ngay {
            color: gray;
            font-size: 12px;
        }
        .duyet-xoa {
            text-align: center;
            margin-top: 15px;
        }
        .duyet-xoa a {
            margin: 0 10px;
            font-weight: bold;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 5px;
        }
        .duyet {
            background-color: #28a745;
            color: white;
        }
        .xoa {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>

<h3 class="tieude-baiviet"><?= htmlspecialchars($dong['TieuDe']) ?></h3>

<p class="ThongTin">
    [<?= htmlspecialchars($dong['TenChuDe']) ?>] Đăng bởi <strong><?= htmlspecialchars($dong['TenNguoiDung']) ?></strong>,
    vào lúc <?= $dong['NgayDang'] ?>, có <?= $dong['LuotXem'] ?> lượt xem.
</p>

<!-- Nút Duyệt / Xóa nếu là admin -->
<?php if ($is_admin && $dong['KiemDuyet'] == 0): ?>
<div class="duyet-xoa">
    <a class="duyet" href="index.php?do=baiviet_kichhoat&id=<?= $MaBV ?>&duyet=1" onclick="return confirm('Duyệt bài viết này?')">✔ Duyệt bài</a>
    <a class="xoa" href="index.php?do=baiviet_kichhoat&id=<?= $MaBV ?>&xoa=1" onclick="return confirm('Xóa bài viết này?')">✖ Xóa bài</a>
</div>
<?php endif; ?>

<p class="TomTat"><?= nl2br(htmlspecialchars($dong['TomTat'])) ?></p>

<?php if (!empty($dong["HinhAnh"])): ?>
    <div class="HinhAnh-ChuThich">
        <img class="baivietchitiet-hinh" src="<?= htmlspecialchars($image_path) ?>" alt="<?= htmlspecialchars($dong['ChuThichAnh']) ?>" />
        <p class="ChuThichAnh"><?= htmlspecialchars($dong['ChuThichAnh']) ?></p>
    </div>
<?php endif; ?>

<div class="NoiDung">
    <?= $dong['NoiDung'] ?>
</div>

<!-- Tin liên quan -->
<?php if ($danhsach2 && $danhsach2->num_rows > 0): ?>
    <div class="tin-khac">
        <h4>Các tin khác cùng lĩnh vực:</h4>
        <ul>
        <?php while ($row = $danhsach2->fetch_array(MYSQLI_ASSOC)): ?>
            <li>
                <a href="index.php?do=baiviet_chitiet&id=<?= $row['MaBaiViet'] ?>" class="tieude-baiviet"><?= htmlspecialchars($row['TieuDe']) ?></a>
                <span class="ngay">(<?= $row["NgayDang"] ?>)</span>
            </li>
        <?php endwhile; ?>
        </ul>
    </div>
<?php endif; ?>

</body>
</html>
