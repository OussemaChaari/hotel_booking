<?php require('inc/essentials.php');
require('inc/db_config.php'); 
session_start();
if(isset($_SESSION['admin_login']) && $_SESSION['admin_login']==true){
    redirect('dashboard.php');
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin login Panel</title>
    <?php require('inc/links.php'); ?>
    <style>
        .login-form {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
        }

        .custom-alert {
            position: fixed;
            top: 25px;
            right: 25px;
        }
    </style>
</head>

<body class="bg-light">

    <div class="login-form text-center rounded bg-white shadow overflow-hidden">
        <form action="" method="POST">
        <span class="badge bg-light text-dark mb-3 text-wrap">
                            Note: email admin, password admin.
                        </span>
            <h4 class="bg-dark text-white py-3">Admin Login</h4>
            <div class="p-4">
                <div class="mb-3">
                    <input type="text" name="admin_name" required class="form-control shadow-none text-center"
                        placeholder="Enter Name">
                </div>
                <div class="mb-3">
                    <input type="password" name="admin_pass" required class="form-control shadow-none text-center"
                        placeholder="Enter Password">
                </div>
                <button type="submit" name="login" class="btn text-white custom-bg box-shadow">login</button>
            </div>

        </form>
    </div>
    <?php
    if (isset($_POST['login'])) {
        $form_data = filteration($_POST);
        $query = "SELECT * FROM admin WHERE `admin_name`=? AND `admin_pass`=?";
        $values = [$form_data['admin_name'], $form_data['admin_pass']];
        $res = select($query, $values, "ss");
        if ($res->num_rows == 1) {
            $row = mysqli_fetch_assoc($res);
            $_SESSION['admin_login'] = true;
            $_SESSION['admin_id'] = $row['id'];
            redirect('dashboard.php');
        } else {
            alert('error', 'Invalid Name Or Password');
        }
    }

    ?>


    <?php require('inc/scripts.php'); ?>

</body>

</html>