<?php
	$sql = "SELECT *
			FROM tbl_noidungtin A, tbl_chude B, tbl_nguoidung C
			WHERE A.MaChuDe = B.MaChuDe AND A.maNguoiDung = C.MaNguoiDung ORDER by `NgayDang` DESC";
	$danhsach = $connect->query($sql);
	//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
	if (!$danhsach) {
		die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
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

    table.DanhSach a {
        text-decoration: none;
        font-size: 16px;
        color: #333;
    }

    table.DanhSach a:hover {
        color: #990000;
        text-decoration: underline;
    }

    table.DanhSach img {
        width: 20px;
        height: 20px;
        transition: transform 0.2s ease;
    }

    table.DanhSach a:hover img {
        transform: scale(1.2);
    }

    a[href*="baiviet_them"] {
        display: block;
        width: fit-content;
        margin: 20px auto;
        padding: 10px 20px;
        background-color: #990000;
        color: white;
        border-radius: 5px;
        font-weight: bold;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    a[href*="baiviet_them"]:hover {
        background-color: #cc0000;
    }
</style>

<h3>Danh sách bài viết</h3>
<table class="DanhSach">
	<tr>
		<th>Mã BV</th>
		<th>Tiêu đề</th>
		<th>Chủ đề</th>
		<th>Người đăng</th>
        <th>Ngày đăng</th>
		<th colspan="3">Hành động</th>
	</tr>
	<?php
		while ($dong = $danhsach->fetch_array(MYSQLI_ASSOC)) {
			echo "<tr>";
				echo "<td>" . $dong['MaBaiViet'] . "</td>";
				echo "<td><a href='index.php?do=baiviet_chitiet&id=" . $dong['MaBaiViet'] . "'>" . $dong['TieuDe'] . "</a></td>";
				echo "<td>" . $dong['TenChuDe'] . "</td>";
				echo "<td>" . $dong['TenNguoiDung'] . "</td>";
                echo "<td>" .date('d/m/Y',strtotime($dong['NgayDang'])) . "</td>";
				
				// Icon kiểm duyệt
				echo "<td align='center'>";
					if($dong['KiemDuyet'] == 0)
						echo "<a href='index.php?do=baiviet_kichhoat&k=1&id=" . $dong['MaBaiViet'] . "' title='Chưa duyệt'><i class='fas fa-ban' style='color: #dc3545;'></i></a>";
					else
						echo "<a href='index.php?do=baiviet_kichhoat&k=0&id=" . $dong['MaBaiViet'] . "' title='Đã duyệt'><i class='fas fa-check-circle' style='color: #28a745;'></i></a>";
				echo "</td>";
				
				// Icon sửa
				echo "<td align='center'><a href='index.php?do=baiviet_sua&id=" . $dong['MaBaiViet'] . "' title='Sửa'><i class='fas fa-edit' style='color: #007bff;'></i></a></td>";

				// Icon xóa
				echo "<td align='center'><a href='index.php?do=baiviet_xoa&id=" . $dong['MaBaiViet'] . "' onclick='return confirm(\"Bạn có muốn xóa bài viết " . $dong['TieuDe'] . " không?\")' title='Xóa'><i class='fas fa-trash-alt' style='color: #dc3545;'></i></a></td>";
			echo "</tr>";
		}
	?>
</table>

<a href="index.php?do=baiviet_them">Đăng bài viết</a>
