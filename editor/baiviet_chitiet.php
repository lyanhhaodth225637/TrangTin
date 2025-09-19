<?php
$MaBV = intval($_GET['id']); // tránh SQL Injection

$sql = "SELECT A.*, B.TenChuDe, C.TenNguoiDung
        FROM tbl_noidungtin A
        JOIN tbl_chude B ON A.MaChuDe = B.MaChuDe
        JOIN tbl_nguoidung C ON A.maNguoiDung = C.MaNguoiDung
        WHERE A.MaBaiViet = $MaBV";

$danhsach = $connect->query($sql);
if (!$danhsach) {
    die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
}

$dong = $danhsach->fetch_array(MYSQLI_ASSOC);

// Tăng lượt xem
$connect->query("UPDATE tbl_noidungtin SET LuotXem = LuotXem + 1 WHERE MaBaiViet = $MaBV");

// Lấy các tin khác cùng lĩnh vực
$sql2 = "SELECT MaBaiViet, TieuDe, NgayDang
         FROM tbl_noidungtin
         WHERE MaChuDe = " . intval($dong['MaChuDe']) . " 
           AND MaBaiViet <> $MaBV
           AND KiemDuyet = 1
         ORDER BY NgayDang DESC
         LIMIT 5";

$danhsach2 = $connect->query($sql2);
if (!$danhsach2) {
    echo "<p>Lỗi truy vấn các bài viết cùng lĩnh vực.</p>";
}

// Xử lý đường dẫn hình ảnh để đúng khi admin và images cùng cấp
$image_path = $dong["HinhAnh"];
if (strpos($image_path, 'images/') === 0) {
    $image_path = '../' . $image_path;
}
?>

<h3 class="tieude-baiviet"><?= htmlspecialchars($dong['TieuDe']) ?></h3>

<p class="ThongTin">
    [<?= htmlspecialchars($dong['TenChuDe']) ?>] Đăng bởi <strong><?= htmlspecialchars($dong['TenNguoiDung']) ?></strong>,
    vào lúc <?= $dong['NgayDang'] ?>, có <?= $dong['LuotXem'] ?> lượt xem.
</p>

<p class="TomTat"><?= nl2br(htmlspecialchars($dong['TomTat'])) ?></p>

<?php if (!empty($dong["HinhAnh"])): ?>
<div class="HinhAnh-ChuThich" style="margin-bottom:15px;">
    <img class="baivietchitiet-hinh" src="<?= htmlspecialchars($image_path) ?>" alt="<?= htmlspecialchars($dong['ChuThichAnh']) ?>" />
    <p class="ChuThichAnh"><?= htmlspecialchars($dong['ChuThichAnh']) ?></p>
</div>
<?php endif; ?>

<div class="NoiDung">
    <?= $dong['NoiDung'] ?>
</div>

<!-- Các tin khác cùng lĩnh vực (nếu có) -->
<div class="tin-khac">
    <h4>Các tin khác cùng lĩnh vực:</h4>
    <ul>
    <?php
    if ($danhsach2) {
        while ($row = $danhsach2->fetch_array(MYSQLI_ASSOC)) {
            echo "<li><a href='index.php?do=baiviet_chitiet&id=" . $row['MaBaiViet'] . "' class='tieude-baiviet'>" . htmlspecialchars($row['TieuDe']) . "</a> <span class='ngay'>(" . $row["NgayDang"] . ")</span></li>";
        }
    }
    ?>
    </ul>
</div>
