<?php
$cd = $_GET["id"];

$sql1 = "SELECT COUNT(MaBaiViet) AS total FROM tbl_noidungtin WHERE MaChuDe = '$cd' AND KiemDuyet = 1";
$danhsach = $connect->query($sql1);

if ($danhsach === false) {
    echo "<p>Lỗi truy vấn dữ liệu: " . $connect->error . "</p>";
    exit();
}

$row1 = $danhsach->fetch_array(MYSQLI_ASSOC);
$total_records = $row1 ? $row1['total'] : 0;

if ($total_records == 0) {
    echo "<p>Không có bài viết nào thuộc chuyên mục này.</p>";
} else {
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $limit = 5;

    $total_page = ceil($total_records / $limit);
    if ($current_page > $total_page) $current_page = $total_page;
    else if ($current_page < 1) $current_page = 1;

    $start = ($current_page - 1) * $limit;

    $sql2 = "SELECT * FROM tbl_noidungtin WHERE MaChuDe = '$cd' AND KiemDuyet = 1 ORDER BY NgayDang DESC LIMIT $start, $limit";
    $danhsach = $connect->query($sql2);

    if (!$danhsach) {
        echo "<p>Lỗi truy vấn dữ liệu.</p>";
        exit();
    }

    echo '<div id="danh-sach-bai-viet">';
    while ($row = $danhsach->fetch_array(MYSQLI_ASSOC)) {
        echo '<div class="baiviet-item">';
        echo '  <img class="baiviet-hinh" src="' . htmlspecialchars($row["HinhAnh"]) . '" alt="Hình bài viết">';
        echo '  <div class="baiviet-noidung">';
        echo '    <h4><a class="tieude-baiviet" href="index.php?do=baiviet_chitiet&id=' . $row['MaBaiViet'] . '">' . htmlspecialchars($row['TieuDe']) . '</a></h4>';
        echo '    <div class="baiviet-tomtat">' . nl2br(htmlspecialchars($row["TomTat"])) . '</div>';
        echo '    <div class="baiviet-ngaydang">' . $row["NgayDang"] . '</div>';
        echo '  </div>';
        echo '</div>';
    }
    echo '</div>';

    echo '<div class="phan-trang">';

    if ($total_page > 1) {
        if ($current_page > 1) {
            echo '<a href="index.php?do=baiviet_chude&id=' . $cd . '&page=' . ($current_page - 1) . '">&laquo; Trước</a> ';
        }

        for ($i = 1; $i <= $total_page; $i++) {
            if ($i == $current_page) {
                echo '<span class="trang-hien-tai">' . $i . '</span> ';
            } else {
                echo '<a href="index.php?do=baiviet_chude&id=' . $cd . '&page=' . $i . '">' . $i . '</a> ';
            }
        }

        if ($current_page < $total_page) {
            echo '<a href="index.php?do=baiviet_chude&id=' . $cd . '&page=' . ($current_page + 1) . '">Sau &raquo;</a>';
        }
    }

    echo '</div>';
}
?>