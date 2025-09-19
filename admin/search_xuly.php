<?php
if (isset($_REQUEST['ok'])) {

    $search = addslashes($_POST['search']);

    $sql = "SELECT * FROM tbl_noidungtin WHERE TieuDe LIKE '%$search%' OR NoiDung LIKE '%$search%'";
    $danhsach = $connect->query($sql);

    if (!$danhsach) {
        die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
        exit();
    }

    $num = mysqli_num_rows($danhsach);

    if (empty($search)) {
        echo "<p style='color: red;'>Hãy nhập dữ liệu vào ô tìm kiếm</p>";
    } else {
        if ($num > 0) {
            echo "<p><strong>$num</strong> kết quả trả về với từ khóa <b>$search</b></p>";
            // Dùng class baiviet-item để trình bày từng bài viết
            while ($row = $danhsach->fetch_assoc()) {
                echo "<div class='baiviet-item'>";
                // Nếu có hình ảnh thì có thể thêm div ảnh, hiện tạm không có hình nên bỏ
                echo "<div class='baiviet-noidung'>";
                echo "<h4><a href='index.php?do=baiviet_chitiet&id=" . $row['MaBaiViet'] . "' class='tieude-baiviet'>" . htmlspecialchars($row['TieuDe']) . "</a></h4>";
                echo "<p class='baiviet-ngaydang'>Ngày đăng: " . htmlspecialchars($row['NgayDang']) . "</p>";
                echo "<p class='baiviet-tomtat'>" . htmlspecialchars($row['TomTat']) . "</p>";
                echo "<p class='baiviet-chitiet'><a href='index.php?do=baiviet_chitiet&id=" . $row['MaBaiViet'] . "'>Chi tiết &raquo;</a></p>";
                echo "</div>"; // baiviet-noidung
                echo "</div>"; // baiviet-item
            }
        } else {
            echo "<p>Không tìm thấy kết quả!</p>";
        }
    }
}
?>
