<?php 
	$sql = "SELECT * FROM `tbl_nguoidung` WHERE 1";
	$danhsach = $connect->query($sql);
	if (!$danhsach) {
		die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
		exit();
	}
?>

<head>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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

		table.DanhSach i {
			font-size: 18px;
			transition: transform 0.2s ease;
		}

		table.DanhSach a:hover i {
			transform: scale(1.2);
		}

		a[href*="dangky"] {
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

		a[href*="dangky"]:hover {
			background-color: #cc0000;
		}
	</style>
</head>

<h3>Danh sách người dùng</h3>
<table class="DanhSach">
    <tr>
        <th>Mã ND</th>
        <th>Họ và tên</th>
        <th>Tên đăng nhập</th>
        <th>Quyền</th>
        <th colspan="3">Hành động</th>
    </tr>
    <?php
    while ($dong = $danhsach->fetch_array(MYSQLI_ASSOC)) {
        echo "<tr>";
            echo "<td>" . $dong["MaNguoiDung"] . "</td>";
            echo "<td>" . $dong["TenNguoiDung"] . "</td>";
            echo "<td>" . $dong["TenDangNhap"] . "</td>";
            
            // Hiển thị quyền dạng text, không có link nâng/hạ quyền
            echo "<td>";
            switch ($dong["QuyenHan"]) {
                case 0:
                    echo "Khách";
                    break;
                case 1:
                    echo "Quản trị viên";
                    break;
                case 2:
                    echo "Editor";
                    break;
                default:
                    echo "Không rõ";
            }
            echo "</td>";
			
            // Kích hoạt / Khóa tài khoản
            echo "<td align='center'>";
                if ($dong["Khoa"] == 0)
                    echo "<a href='index.php?do=nguoidung_kichhoat&id=" . $dong["MaNguoiDung"] . "&khoa=1' title='Đang hoạt động'><i class='fas fa-check-circle' style='color: #28a745;'></i></a>";
                else
                    echo "<a href='index.php?do=nguoidung_kichhoat&id=" . $dong["MaNguoiDung"] . "&khoa=0' title='Đã khóa'><i class='fas fa-ban' style='color: #dc3545;'></i></a>";
            echo "</td>";

            // Sửa
            echo "<td align='center'><a href='index.php?do=nguoidung_sua&id=" . $dong["MaNguoiDung"] . "' title='Sửa'><i class='fas fa-edit' style='color: #007bff;'></i></a></td>";

            // Xóa
            echo "<td align='center'><a href='index.php?do=nguoidung_xoa&id=" . $dong["MaNguoiDung"] . "' onclick='return confirm(\"Bạn có muốn xóa người dùng " . $dong['TenNguoiDung'] . " không?\")' title='Xóa'><i class='fas fa-trash-alt' style='color: #dc3545;'></i></a></td>";
        echo "</tr>";
    }
    ?>
</table>