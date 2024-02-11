<?php
require('../admin/inc/db_config.php');
require('../admin/inc/essentials.php');

if (isset($_POST['register'])) {
    $data = filteration($_POST);
    // Check if the user already exists
    $u_exist = select("SELECT * FROM `user_cred` WHERE `email`=? OR `phone`=? LIMIT 1", [$data['email'],$data['phone']], "ss");
    if (mysqli_num_rows($u_exist) > 0) {
        $fetch_assoc_user = mysqli_fetch_assoc($u_exist);
        echo ($fetch_assoc_user['email'] === $data['email']) ? 'user_exist' : 'phone_exist';
        exit;
    }
    // Password hashing
    $pass = md5($data['pass']);
    // Profile image upload
    $img = uploadImage($_FILES['profile'], USERS_FOLDER);
    if ($img == 'inv_img') {
        echo 'inv_img';
        exit;
    } elseif ($img == 'upl_failed') {
        echo 'upl_failed';
        exit;
    }
    // Insert user data into the database
    $query_insert = "INSERT INTO `user_cred`(`name`, `email`, `phone`, `profile`, `adresse`, `dob`, `pass`, `status`, `created_at`) VALUES (?,?,?,?,?,?,?,?,?)";
    $values = [$data['name'], $data['email'], $data['phone'], $img, $data['adresse'], $data['dob'], $pass, 0, date('Y-m-d H:i:s')];
    if (insert($query_insert, $values, "sssssssss")) {
        echo 'success';
    } else {
        echo 'ins_failed';
    }
}
if(isset($_POST['login'])){
    $data = filteration($_POST);
    $u_exist = select("SELECT * FROM `user_cred` WHERE `email`=? OR `phone`=? LIMIT 1", [$data['email_mobile'],$data['email_mobile']], "ss");
    if (mysqli_num_rows($u_exist) === 0) {
        echo 'invalid_email_mobile';
        exit;
    }else{
        $fetch_user = mysqli_fetch_assoc($u_exist);
        if (md5($data['pass']) !== $fetch_user['pass']) {
            echo 'inv_pass';
        }else{
            session_start();
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $fetch_user['id'];
            $_SESSION['user_name'] = $fetch_user['name'];
            $_SESSION['user_profile'] = $fetch_user['profile'];
            $_SESSION['user_phone'] = $fetch_user['phone'];
            echo 1;
        }
    }
}
if(isset($_POST['verify_email'])){
    $data = filteration($_POST);
    $u_exist = select("SELECT * FROM `user_cred` WHERE `email`=?",[$data['email']], "s");
    if (mysqli_num_rows($u_exist) === 0) {
        echo 'invalid_email';
        exit;
    }else{
        echo 'valid_email';
    }
}
if(isset($_POST['save_password'])){
    $data = filteration($_POST);
    $hashed_password = md5($data['password']); // You may consider using a stronger hashing algorithm than md5
    $update_qry = "UPDATE user_cred SET pass=? WHERE `email`=?";
    $values = [$hashed_password, $data['email']];

    if (update($update_qry, $values, "ss")) {
        echo 'success_password';
    } else {
        echo 'failed_password';
    }
}
?>