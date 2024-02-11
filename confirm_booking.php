<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <?php require('inc/links.php'); ?>
    <title>
        <?= $data_settings['site_title']; ?> - Confirmation
    </title>
    <style>
        .line {
            width: 150px !important;
            margin: 0 auto !important;
            height: 1.7px;
        }
    </style>
</head>

<body class="bg-light">
    <?php require('inc/header.php'); ?>

    <?php
    if (!isset($_GET['id']) || $data_settings['shutdown'] === 1) {
        redirect('rooms.php');
    } else if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
        redirect('rooms.php');
    }
    $data = filteration($_GET);
    $room_res = select("SELECT * FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?", [$data['id'], 1, 0], 'iii');
    if (mysqli_num_rows($room_res) === 0) {
        redirect('rooms.php');
    }
    $room_data = mysqli_fetch_assoc($room_res);
    $_SESSION['room'] = [
        "id" => $room_data['id'],
        "name" => $room_data['name'],
        "price" => $room_data['price'],
        "payement" => null,
        "available" => false
    ];
    $user_res = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1", [$_SESSION['user_id']], "i");
    $user_data = mysqli_fetch_assoc($user_res);
    ?>
    <div class="container">
        <div class="row">
            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold">
                    Confirmation Booking
                </h2>
                <div style="font-size:14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">Home</a>
                    <span class="text-secondary">></span>
                    <a href="rooms.php" class="text-secondary text-decoration-none">Rooms</a>
                    <span class="text-secondary">></span>
                    <a href="" class="text-secondary text-decoration-none">Confirm</a>
                </div>
            </div>
            <div class="col-lg-7 col-md-12 px-4">
                <?php
                $thumb_room = ROOMS_IMG_PATH . "NotFoundImage.png";
                $thumb_q = mysqli_query($con, "SELECT * FROM `rooms_image` WHERE `room_id`='$room_data[id]' AND `thumb`='1'");
                if (mysqli_num_rows($thumb_q) > 0) {
                    $thumb_res = mysqli_fetch_assoc($thumb_q);
                    $thumb_room = ROOMS_IMG_PATH . $thumb_res['images'];
                }
                echo <<<data
                <div class='card p-3 shadow-sm rounded'>
                   <img src="$thumb_room" class="img-fluid rounded mb-3">
                   <h5>$room_data[name]</h5>
                   <h6>$ $room_data[price] per night</h6>
                </div>
                data;

                ?>
            </div>
            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <form action="" id="booking_form">
                            <h6 class="mb-3">Booking Details</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" value="<?= $user_data['name']; ?>"
                                        class="form-control shadow-none" required disabled>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="number" name="phone" value="<?= $user_data['phone']; ?>"
                                        class="form-control shadow-none" required disabled>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Adresse</label>
                                    <textarea name="adresse" class="form-control shadow-none" rows="1" required
                                        disabled><?= $user_data['adresse']; ?></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Check-In</label>
                                    <input name="checkin" type="date" onchange="check_availability()"
                                        class="form-control shadow-none">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Check-Out</label>
                                    <input name="checkout" type="date" onchange="check_availability()"
                                        class="form-control shadow-none">
                                </div>
                                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']; ?>">
                                <div class="col-md-12 mb-3">
                                    <div class="spinner-border text-info mb-3 d-none" id="info_loader" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <h6 class="text-danger mb-3" id="pay_info">Provide Check-In & Check-Out date!</h6>
                                    <button type="submit" name="pay_now" class="btn w-100 btn-success shadow-none"
                                        disabled>Pay Now</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php require('inc/footer.php'); ?>
    <script>
        let booking_form = document.getElementById('booking_form');
        let info_loader = document.getElementById('info_loader');
        let pay_info = document.getElementById('pay_info');
        function check_availability() {
            let checkin_val = booking_form.elements['checkin'].value;
            let checkout_val = booking_form.elements['checkout'].value;
            booking_form.elements['pay_now'].setAttribute('disabled', true);
            if (checkin_val != '' && checkout_val != '') {
                pay_info.classList.add('d-none');
                info_loader.classList.remove('d-none');
                let data = new FormData();
                data.append('check_availability', '');
                data.append('checkin_val', checkin_val);
                data.append('checkout_val', checkout_val);
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/confirm_booking.php", true);
                xhr.onload = function () {
                    let data = JSON.parse(this.responseText);
                    if (data.status == 'check_in_out_equal') {
                        pay_info.innerHTML = 'Check in and Check out dates must be different!';
                    } else if (data.status == 'check_out_earlier') {
                        pay_info.innerHTML = 'The Check Out date cannot be earlier than the Check In date!';
                    } else if (data.status == 'check_in_earlier') {
                        pay_info.innerHTML = 'the Check In date cannot be earlier!';
                    } else if (data.status == 'unavailable') {
                        pay_info.innerHTML = 'This Room is unavailable for this checked in date!';
                    } else {
                        pay_info.innerHTML = "No. of Days :" + data.days + "<br>total amount to pay :" + data.payement;
                        pay_info.classList.replace('text-danger', 'text-dark');
                        booking_form.elements['pay_now'].removeAttribute('disabled');
                    }
                    pay_info.classList.remove('d-none');
                    info_loader.classList.add('d-none');
                }
                xhr.send(data);
            }
        }
        booking_form.addEventListener('submit', (e) => {
            e.preventDefault();
            let data = new FormData();
            data.append('user_id', booking_form.elements['user_id'].value);
            data.append('checkin', booking_form.elements['checkin'].value);
            data.append('checkout', booking_form.elements['checkout'].value);
            data.append('name', booking_form.elements['name'].value);
            data.append('phone', booking_form.elements['phone'].value);
            data.append('adresse', booking_form.elements['adresse'].value);
            data.append('pay_now', '');
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/confirm_booking.php", true);
            xhr.onload = function () {
                let data = JSON.parse(this.responseText);
                if(data.status == 'ins_failed'){
                    showToast('Payement Failed', 'danger');
                }else if(data.status == 'existing_reservation'){
                    showToast('existing reservation', 'danger');
                }else{
                    showToast('Complete the payment procedure', 'success');
                    setTimeout(function () {
                        window.location.href = 'checkout.php?booking_id=' + data.booking_id;
                    }, 4000);
                }
            }
            xhr.send(data);
        });


    </script>
</body>

</html>