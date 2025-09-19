<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Đăng ký</title>
    <style>
        /* Reset cơ bản */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Roboto", Arial, sans-serif;
            background: linear-gradient(135deg, #f5f5f5, #ffffff);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
            background-color: #fff;
            border: 1.5px solid #990000;
            border-radius: 8px;
            padding: 35px 30px;
            box-shadow: 0 8px 20px rgba(153, 0, 0, 0.15);
            transition: box-shadow 0.3s ease;
        }
        .login-wrapper:hover {
            box-shadow: 0 12px 30px rgba(153, 0, 0, 0.3);
        }

        h2 {
            color: #990000;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        label {
            font-weight: 600;
            display: block;
            margin-bottom: 8px;
            margin-top: 20px;
            color: #333;
            user-select: none;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 12px 14px;
            font-size: 16px;
            border: 1.8px solid #ccc;
            border-radius: 6px;
            transition: border-color 0.25s ease, box-shadow 0.25s ease;
            font-family: inherit;
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        select:focus {
            border-color: #990000;
            box-shadow: 0 0 8px rgba(153, 0, 0, 0.4);
            outline: none;
        }

        button {
            width: 100%;
            background-color: #990000;
            color: #fff;
            padding: 14px;
            margin-top: 30px;
            font-size: 18px;
            font-weight: 700;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            letter-spacing: 0.05em;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            user-select: none;
        }

        button:hover,
        button:focus {
            background-color: #b20600;
            box-shadow: 0 4px 14px rgba(178, 6, 0, 0.6);
            outline: none;
        }

        .form-footer {
            margin-top: 25px;
            text-align: center;
            font-size: 14px;
            color: #555;
        }

        .form-footer a {
            color: #990000;
            text-decoration: none;
            font-weight: 600;
            transition: text-decoration 0.2s ease;
        }

        .form-footer a:hover,
        .form-footer a:focus {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <h2>Đăng ký tài khoản</h2>
    <form action="register_xuly.php" method="POST" novalidate>
        <label for="fullname">Tên đầy đủ</label>
        <input type="text" name="fullname" id="fullname" required autocomplete="name" />

        <label for="username">Tên đăng nhập</label>
        <input type="text" name="username" id="username" required autocomplete="username" />

        <label for="password">Mật khẩu</label>
        <input type="password" name="password" id="password" required autocomplete="new-password" />

        <label for="password_confirm">Xác nhận mật khẩu</label>
        <input type="password" name="password_confirm" id="password_confirm" required autocomplete="new-password" />

        <label for="role">Chọn vai trò:</label>
        <select name="quyenhan" id="role" required>
            <option value="0">Khách</option>
            <option value="2">Editor (chờ duyệt)</option>
        </select>
        
        <button type="submit">Đăng ký</button>

        <div class="form-footer">
            <a href="login.php">Đã có tài khoản? Đăng nhập</a>
        </div>
    </form>
</div>

</body>
</html>
