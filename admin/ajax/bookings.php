<?php
require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

if (isset($_POST['bookings_orders'])) {
    $res = selectAll("booking_order");
    $data = "";
    while ($row = mysqli_fetch_assoc($res)) {
        if ($row['booking_status'] == "pending") {
            $status = "<button class='btn btn-sm shadow-none toggle-button' onclick=\"toggle_status('$row[booking_id]', 'booked')\">";
            $status .= "<i class='bi bi-toggle-off fs-4'></i>";
        } else {
            $status = "<button class='btn btn-sm shadow-none toggle-button' onclick=\"toggle_status('$row[booking_id]', 'pending')\">";
            $status .= "<i class='bi bi-toggle-on fs-4'></i>";
        }
        $status .= "</button>";
        $data .= "
        <tr class='align-middle'>
            <td>$row[order_id]</td>
            <td>$row[check_in]</td>
            <td>$row[check_out]</td>
            <td>$row[created_at]</td>
            <td>$status</td>
            <td>
                <button type='button' class='btn btn-secondary btn-sm shadow-none' onclick=\"get_details('$row[booking_id]')\" data-bs-toggle='modal' data-bs-target='#modalView'>
                    <i class='bi bi-eye'></i>
                </button>
            </td>
        </tr>";
    }
    echo $data;
}
if (isset($_POST['toggle_status'])) {
    $form_data = filteration($_POST);
    $q = "UPDATE `booking_order` SET `booking_status`=? WHERE `booking_id`=?";
    $values = [$form_data['value'], $form_data['toggle_status']];
    if (update($q, $values, 'si')) {
        echo 1;
    } else {
        echo 0;
    }
}
if (isset($_POST['get_details'])) {
    $form_data = filteration($_POST);
    $q = "SELECT * FROM `booking_details` WHERE `booking_id`=?";
    $values = [$form_data['get_details']];
    $result = select($q, $values, 'i');

    if ($result && mysqli_num_rows($result) > 0) {
        $details = mysqli_fetch_assoc($result);
        echo json_encode(['status' => 1, 'details' => $details]);
    } else {
        echo json_encode(['status' => 0]);
    }
}


if (isset($_POST['get_payement'])) {
    $query = "SELECT pd.*, uc.*, bo.*
              FROM payment_details pd
              JOIN user_cred uc ON pd.user_id = uc.id
              JOIN booking_order bo ON pd.booking_id = bo.booking_id";
    $result = mysqli_query($con, $query);
    if ($result) {
        $data = "";
        while ($row = mysqli_fetch_assoc($result)) {
            $data .= "
            <tr class='align-middle'>
                <td>{$row['name']}</td>
                <td>{$row['payment_method']}</td>
                <td>{$row['account_number']}</td>
                <td>{$row['money_to_payer']}</td>
                <td>
                <a href='../fpdf/payment_details.php?id_payement={$row['id_payement']}' target='_blank' class='btn btn-secondary btn-sm shadow-none'>
                <i class='bi bi-file-earmark-pdf-fill'></i>
            </a>
                </td>
            </tr>";
        }
        echo $data;
    } 
}

?>