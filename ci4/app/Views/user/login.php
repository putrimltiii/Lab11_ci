<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f4f4;
        }

        #login-wrapper {
            width: 400px;
            margin: 100px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        #login-wrapper h1 {
            color: #2f66a5;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .mb-3 {
            margin-bottom: 15px;
        }

        .mb-3 label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .btn-primary {
            background: #2f66a5;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            width: 100%;
        }

        .btn-primary:hover {
            background: #4c8ed9;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div id="login-wrapper">
    <h1>Sign In</h1>

    <?php if(session()->getFlashdata('flash_msg')): ?>
    <div class="alert-danger">
        <?= session()->getFlashdata('flash_msg') ?>
    </div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="mb-3">
            <label for="InputForEmail">Email address</label>
            <input type="email" name="email" class="form-control"
                   id="InputForEmail" value="<?= set_value('email') ?>">
        </div>
        <div class="mb-3">
            <label for="InputForPassword">Password</label>
            <input type="password" name="password" class="form-control"
                   id="InputForPassword">
        </div>
        <button type="submit" class="btn-primary">Login</button>
    </form>
</div>
</body>
</html>