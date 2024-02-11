<?php
require('../admin/inc/db_config.php');
require('../admin/inc/essentials.php');

if(isset($_POST['check_availability'])){
    $data = filteration($_POST);
    $status = "";
    $today_date = new DateTime(date("Y-m-d"));
    $checkin_data = new DateTime($data['checkin_val']);
    $checkout_data = new DateTime($data['checkout_val']);
    if($checkin_data == $checkout_data){
      $status = "check_in_out_equal";
      $result = json_encode(["status"=>$status]);
    }else if($checkout_data < $checkin_data){
        $status = "check_out_earlier";
        $result = json_encode(["status"=>$status]);
    }else if($checkin_data < $today_date){
        $status = "check_in_earlier";
        $result = json_encode(["status"=>$status]);
    }


    if($status!=''){
        echo $result;
    }else{
        session_start();
        $_SESSION['room'];
        $count_days = date_diff($checkin_data,$checkout_data)->days;
        $payement = $_SESSION['room']['price'] * $count_days;
        $_SESSION['room']['payement'] = $payement;
        $_SESSION['room']['available'] = true;
        $result = json_encode(["status"=>"available","days"=>$count_days,"payement"=>$payement]);
        echo $result;
    }
}
if (isset($_POST['pay_now'])) {
    $status = "";
    session_start();
    $form_data = filteration($_POST);
    $existing_reservation_query = "SELECT * FROM `booking_order` WHERE `room_id`=? AND (
        (`check_in` <= ? AND `check_out` >= ?) OR 
        (`check_in` <= ? AND `check_out` >= ?) OR
        (`check_in` >= ? AND `check_out` <= ?)
    )";
    $params = 'issssss';
    $values = [$_SESSION['room']['id'],$form_data['checkin'],$form_data['checkin'],$form_data['checkout'],$form_data['checkout'],$form_data['checkin'],$form_data['checkout']];
    $existing_reservation_result = select($existing_reservation_query, $values, $params);
    if (mysqli_num_rows($existing_reservation_result) > 0) {
        $status = 'existing_reservation';
        echo json_encode(['status' => $status]);
        exit;
    } else {
        $orderId = 'ORD_' . $form_data['user_id'] . '_' . uniqid();
        $query1 = "INSERT INTO `booking_order`(`user_id`, `room_id`, `check_in`, `check_out`, `order_id`) 
                   VALUES (?,?,?,?,?)";
        $insert_result1 = insert($query1, [$form_data['user_id'], $_SESSION['room']['id'], $form_data['checkin'], $form_data['checkout'], $orderId], "iisss");
        $booking_id = mysqli_insert_id($con);
        $query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total_pay`, `user_name`, `user_phone`, `user_adresse`) 
                   VALUES (?,?,?,?,?,?,?)";
        $insert_result2 = insert($query2, [$booking_id, $_SESSION['room']['name'], $_SESSION['room']['price'], $_SESSION['room']['payement'], $form_data['name'], $form_data['phone'], $form_data['adresse']], "isiisss");

        if ($insert_result1 && $insert_result2) {
            echo json_encode(['status' => 'success', 'booking_id' => $booking_id]);
        } else {
            $status = 'ins_failed';
            echo json_encode(['status' => $status]);

        }
    }
}
if(isset($_POST['pay_money'])){
    session_start();
    $form_data = filteration($_POST);
    $user_id = $_SESSION['user_id'];
    $payment_method = $form_data['payment_method'];
    $account_number = $form_data['account_number'];
    $money_to_payer = $form_data['money_payer'];
    $booking_id = $form_data['booking_id'];


    $query = "INSERT INTO payment_details (user_id,booking_id, payment_method, account_number, money_to_payer)
              VALUES (?,?, ?, ?, ?)";
    $insert_result = insert($query, [$user_id,$booking_id, $payment_method, $account_number, $money_to_payer], "iisss");

    if($insert_result){
        echo 'success';
    } else {
        echo 'failure';
    }
}

?>