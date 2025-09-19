<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <style>
        body {
            margin: 0;
            font-family: "Roboto", Arial, sans-serif;
            background-color: #ffffff;
        }

        .login-wrapper {
            width: 400px;
            margin: 100px auto;
            border: 1px solid #990000;
            padding: 30px;
            background-color: #f9f9f9;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            border-radius: 6px;
        }

        h2 {
            color: #990000;
            text-align: center;
            margin-bottom: 25px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            margin-top: 15px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            background-color: #990000;
            color: white;
            padding: 12px;
            margin-top: 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #b20600;
        }

        .form-footer {
            margin-top: 15px;
            text-align: center;
        }

        .form-footer a {
            color: #990000;
            text-decoration: none;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <h2>Đăng nhập</h2>
    <form action="login_xuly.php" method="POST">
        <label for="username">Tên đăng nhập</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Mật khẩu</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Đăng nhập</button>

        <div class="form-footer">
            <a href="register.php">Chưa có tài khoản? Đăng ký</a>
        </div>
    </form>
</div>

</body>
</html>
