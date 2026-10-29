<?php
session_start();
require 'koneksi.php';

// Memanggil kamus bahasa eksternal (termasuk logika penangkap ?lang=...)
require 'kamus_bahasa.php';

$error = "";
if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$user, $pass]);
    
    if ($stmt->fetch()) {
        $_SESSION['status_login'] = true;
        header("Location: index.php");
        exit;
    } else {
        $error = $t_err_login;
    }
}
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $t_login_title; ?></title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
            /* Background Gradient Polos tanpa gambar */
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        }
        
        .login-box {
            background: #ffffff;
            padding: 40px 35px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 400px;
        }
        
        .login-box h2 {
            text-align: center;
            color: #1e3c72;
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: 700;
        }
        
        .lang-switch {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .lang-switch a {
            text-decoration: none;
            color: #2a5298;
            font-weight: bold;
            font-size: 13px;
            margin: 0 8px;
            padding: 6px 14px;
            border-radius: 15px;
            background: #eef2f5;
            transition: all 0.3s ease;
        }
        
        .lang-switch a:hover {
            background: #2a5298;
            color: #fff;
        }
        
        .error-message {
            color: #c0392b;
            background-color: #fadbd8;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            font-size: 14px;
            margin-bottom: 20px;
            font-weight: bold;
            display: <?php echo empty($error) ? 'none' : 'block'; ?>;
        }
        
        .input-group {
            margin-bottom: 20px;
        }
        
        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #444;
            font-size: 14px;
        }
        
        .input-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            background-color: #fcfcfc;
        }
        
        .input-group input:focus {
            border-color: #2a5298;
            outline: none;
            box-shadow: 0 0 8px rgba(42, 82, 152, 0.3);
            background-color: #fff;
        }
        
        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(30, 60, 114, 0.3);
            margin-top: 10px;
        }
        
        .btn-login:hover {
            background: linear-gradient(135deg, #162c54 0%, #1e3c72 100%);
            box-shadow: 0 6px 15px rgba(30, 60, 114, 0.4);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

    <div class="login-box">
        <h2><?php echo $t_login_title; ?></h2>
        
        <!-- Pilihan Bahasa -->
        <div class="lang-switch">
            <a href="?lang=id">INDONESIA</a> | <a href="?lang=en">ENGLISH</a>
        </div>
        
        <!-- Pesan Error -->
        <?php if (!empty($error)): ?>
            <div class="error-message">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <!-- Form Login -->
        <form method="POST">
            <div class="input-group">
                <label><?php echo $t_user; ?></label>
                <input type="text" name="username" required>
            </div>
            
            <div class="input-group">
                <label><?php echo $t_pass; ?></label>
                <input type="password" name="password" required>
            </div>
            
            <button type="submit" name="login" class="btn-login"><?php echo $t_login; ?></button>
        </form>
    </div>

</body>
</html>