<?php
require('../admin/inc/db_config.php');
require('../admin/inc/essentials.php');

if(isset($_POST['update_profile'])){
    $data = filteration($_POST);
    session_start();
    $u_exist = select("SELECT * FROM `user_cred` WHERE `phone`=? AND `id`=? LIMIT 1", 
    [$data['phone'],$_SESSION['user_id']], "ii");
    if(mysqli_num_rows($u_exist)!=0){
        echo 'phone_already';
        exit;
    }
    $query = "UPDATE `user_cred` SET `name`=?,`email`=?,`phone`=?,`adresse`=?,`dob`=? WHERE `id`=?";
    $values = [$data['name'],$data['email'],$data['phone'],$data['adresse'],$data['dob'],$_SESSION['user_id']];
    if(update($query,$values,"ssissi")){
        echo 1;
    }else{
        echo 0;
    }

}
?>