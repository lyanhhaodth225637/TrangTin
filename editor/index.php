<?php
	ob_start(); // Bắt đầu bộ đệm đầu ra	
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}
	include_once "../includes/config.php";
	include_once "../includes/thuvien.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Trang Tin Điện Tử</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="../css/style.css" />
	<script type="text/javascript" src="scripts/jquery-1.4.1.js"></script>
	<script type="text/javascript" src="scripts/basic.js"></script>
</head>
<body>
	<div id="TrangWeb">
		<div id="PhanDau"></div>

		<div style="display: flex;">
			<div id="PhanMenu1">
				<a class="menu" href="index.php?do=home">Trang chủ</a>
				<?php if (isset($_SESSION['MaNguoiDung'])): ?>
					<a class="menu" href="../logout.php">Đăng xuất</a>
				<?php else: ?>
					<a class="menu" href="../login.php">Đăng nhập</a>
				<?php endif; ?>
			</div>
			<div id="PhanMenu2" style="margin-left: auto;">
				<form action="index.php?do=search_xuly" method="post" style="margin: 0; padding: 2px;">
				<input type="text" name="search" placeholder="Tìm kiếm..." />
				<input type="submit" name="ok" value="Tìm" />
				</form>
			</div>
		</div>

		<div id="PhanGiua" style="display: flex; margin-top: 5px;">
			<div id="BenTrai">
				<h3>Chức năng</h3>
                <div id="menudung">
                    <ul>
                        <li><a href="index.php?do=baiviet_them">Đăng bài</a></li>
						<li><a href="index.php?do=chude_them">Thêm chủ đề</a></li>
						<li><a href="index.php?do=hosocanhan"><?= htmlspecialchars($_SESSION['TenNguoiDung']) ?></a></li>
                        <li><a href="index.php?do=doimatkhau">Đổi mật khẩu</a></li>
                    </ul>
                </div>
				<br>
				<h3>Chuyên mục</h3>
				<?php
					$sql = "SELECT * FROM `tbl_chude` WHERE 1";
					$danhsach = $connect->query($sql);
					if (!$danhsach) {
						die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
					}
				?>
				<div id="menudung">
					<ul>
						<?php
							while ($row = $danhsach->fetch_array(MYSQLI_ASSOC)) {
								echo "<li><a href='index.php?do=baiviet_chude&id=" . $row['MaChuDe'] . "'>" . $row['TenChuDe'] . "</a></li>";
							}
						?>  
					</ul>
				</div>
			</div>	

			<div id="Giua">
				<?php
					$do = isset($_GET['do']) ? $_GET['do'] : "home";
					include $do . ".php";
				?>
			</div>
		</div>

		<div id="PhanCuoi">
			<p><strong>News</strong> - Trang thông tin điện tử về viễn thông</p>
			<p>📍 Địa chỉ: 123 Đường Công Nghệ, TP. TechCity | ☎️ Hotline: (0123) 456 789</p>
			<p>📧 Email: <a href="mailto:contact@vienthong.vn">contact@vienthong.vn</a> | 🌐 Website: <a href="https://www.vienthong.vn">www.vienthong.vn</a></p>
			<p>&copy; 2025 News. Mọi quyền được bảo lưu.</p>
		</div>
	</div>
	<?php
	ob_end_flush(); // Kết thúc bộ đệm và gửi nội dung ra ngoài
	?>
</body>
</html>
