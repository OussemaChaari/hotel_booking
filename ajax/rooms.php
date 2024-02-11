<?php
require('../admin/inc/db_config.php');
require('../admin/inc/essentials.php');
session_start();
if (isset($_GET['fetch_room'])) {
    $check_avail = json_decode($_GET['check_avail'], true);
    $guests = json_decode($_GET['guests'], true);
    $adults = $guests['adults'];
    $children = $guests['children'];

    if ($check_avail['checkin'] != '' && $check_avail['checkout'] != '') {
        $today_date = new DateTime(date("Y-m-d"));
        $checkin_data = new DateTime($check_avail['checkin']);
        $checkout_data = new DateTime($check_avail['checkout']);
        if ($checkin_data == $checkout_data) {
            echo "<h3 class='text-center text-danger'>checkin et checkout is equal</h3>";
            exit;
        } else if ($checkout_data < $checkin_data) {
            echo "<h3 class='text-center text-danger'>checkout earlier</h3>";
            exit;
        } else if ($checkin_data < $today_date) {
            echo "<h3 class='text-center text-danger'>checkin earlier</h3>";
            exit;
        }
    }
    $count_rooms = 0;
    $output = "";
    $settings_q = "SELECT * FROM `settings` WHERE `id`=1";
    $data_settings = mysqli_fetch_assoc(mysqli_query($con, $settings_q));
    $rooms_query = "SELECT r.*, bo.check_in, bo.check_out
                    FROM rooms r
                    LEFT JOIN booking_order bo ON r.id = bo.room_id
                    WHERE r.status = ? AND r.removed = ? AND (bo.check_in IS NULL OR (bo.check_out <= ? OR bo.check_in >= ?))
                    AND r.adult >= ? AND r.children >= ?
                    ORDER BY r.id DESC";

    $rooms_res = select($rooms_query, [1, 0, $check_avail['checkin'], $check_avail['checkout'],$adults,$children], "iissii");
    while ($room_data = mysqli_fetch_assoc($rooms_res)) {
        // get features
        $fea_q = mysqli_query($con, "SELECT f.name FROM `features` f INNER JOIN `room_features` rfea ON f.id= rfea.features_id WHERE rfea.room_id ='$room_data[id]'");
        $features_data = "";
        while ($fea_row = mysqli_fetch_assoc($fea_q)) {
            $features_data .= "<span class='badge bg-info me-2 rounded-pill text-dark text-wrap'>
                        $fea_row[name]
                    </span>";
        }
        //get facilities
        $fac_q = mysqli_query($con, "SELECT f.name FROM `facilities` f INNER JOIN `room_facilities` rfac ON f.id= rfac.facilities_id WHERE rfac.room_id ='$room_data[id]'");
        $facilities_data = "";
        while ($fac_row = mysqli_fetch_assoc($fac_q)) {
            $facilities_data .= "<span class='badge bg-info me-2 rounded-pill text-dark text-wrap'>
                        $fac_row[name]
                    </span>";
        }
        // get thumbail of images
        $thumb_room = ROOMS_IMG_PATH . "NotFoundImage.png";
        $thumb_q = mysqli_query($con, "SELECT * FROM `rooms_image` WHERE `room_id`='$room_data[id]' AND `thumb`='1'");
        if (mysqli_num_rows($thumb_q) > 0) {
            $thumb_res = mysqli_fetch_assoc($thumb_q);
            $thumb_room = ROOMS_IMG_PATH . $thumb_res['images'];
        }
        $book_btn = "";
        if ($data_settings['shutdown'] === 0) {
            $login = 0;
            if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
                $login = 1;
            }
            $book_btn = "<button onclick='checkLoginToBook({$login}, {$room_data['id']})' class='btn btn-sm text-white w-100 custom-bg shadow-none mb-2'>Book Now</button>";
        }
        $output .= "
                    <div class='card mb-4 border-0 shadow'>
                        <div class='row g-0 p-3 align-items-center'>
                            <div class='col-md-5 mb-lg-0 mb-md-0 mb-3'>
                                <img src='$thumb_room' class='img-fluid rounded'>
                            </div>
                            <div class='col-md-5 px-lg-3 px-md-3 px-0'>
                                <h5 class='mb-3'>{$room_data['name']}</h5>
                                <div class='features mb-3'>
                                    <h6 class='mb-1'>Features</h6>
                                    $features_data
                                </div>
                                <div class='facilities mb-3'>
                                    <h6 class='mb-1'>Facilities</h6>
                                    $facilities_data
                                </div>
                                <div class='guests'>
                                    <h6 class='mb-1'>Guests</h6>
                                    <span class='badge bg-info rounded-pill text-dark text-wrap'>
                                        {$room_data['adult']} Adult
                                    </span>
                                    <span class='badge bg-info rounded-pill text-dark text-wrap'>
                                        {$room_data['children']} Children
                                    </span>
                                </div>
                            </div>
                            <div class='col-md-2 text-center'>
                                <h6 class='mb-4'>$ {$room_data['price']} per night</h6>
                                $book_btn
                                <a href='details_room.php?id={$room_data['id']}' class='btn btn-sm w-100 btn-outline-dark'>Show details</a>
                            </div>
                        </div>
                    </div>
                ";
        $count_rooms++;

    }
    if ($count_rooms > 0) {
        echo $output;
    } else {
        echo '<h3 class="text-center text-danger">No Rooms To Show</h3>';
    }
}
?>