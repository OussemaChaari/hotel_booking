<?php
require('inc/essentials.php');
require('inc/db_config.php');
adminLogin();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings Orders</title>

    <?php require('inc/links.php'); ?>
    <style>
        #dashboard-menu {
            position: fixed !important;
            height: 100% !important;
        }

        @media screen and (max-width:991px) {
            #dashboard-menu {
                position: fixed;
                height: auto;
            }

            #main-content {
                margin-top: 60px;
            }
        }

        .custom-alert {
            position: fixed;
            top: 80px;
            right: 25px;
        }
    </style>
</head>

<body class="bg-light">
    <?php require('inc/header.php'); ?>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h4 class="mb-4">Bookings Orders</h4>
                <span class="badge bg-info text-dark mb-3 text-wrap p-2">
                    Note: Toggle On represents "Booked," and Toggle Off represents "Pending" status.
                </span>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover border text-center">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col">Order Id</th>
                                        <th scope="col">Check in</th>
                                        <th scope="col">Check out</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">View Details</th>
                                    </tr>
                                </thead>
                                <tbody id="orders-data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='modal fade' id='modalView' tabindex='-1' aria-labelledby='viewModalLabel' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                <strong>Room Name : </strong> <h5 class="mb-1" id="room_name"> </h5>

                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>
                    <div class='row'>
                        <div class='col-md-6'>
                            <h6 class='text-primary'>Details Users</h6>
                            <p><strong>Name:</strong> <span id="user_name" class='text-muted'></span></p>
                            <p><strong>Email:</strong> <span id="user_phone" class='text-muted'></span></p>
                            <p><strong>Adresse:</strong> <span id="user_adresse" class='text-muted'></span></p>
                        </div>
                        <div class='col-md-6'>
                            <h6 class='text-success'>Details Payment</h6>
                            <p><strong>Price Per Night:</strong> <span id="price_night" class='text-muted'></span></p>
                            <p><strong>Total Payment:</strong> <span id="total_payment" class='text-muted'></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require('inc/scripts.php'); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function toggle_status(id, val) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/bookings.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (this.responseText == 1) {
                    alert('success', 'Status Booking Toggled!');
                    get_bookings();
                } else {
                    alert('error', 'Failed to toggle Booking!');
                }
            }
            xhr.send('toggle_status=' + id + '&value=' + val);
        }
        function get_bookings() {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/bookings.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                document.getElementById('orders-data').innerHTML = this.responseText;
            }
            xhr.send('bookings_orders');
        }


        function get_details(id) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/bookings.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                try {
                    const response = JSON.parse(this.responseText);
                    if (response.status == 1) {
                        document.getElementById('room_name').innerText = response.details.room_name;
                        document.getElementById('user_name').innerText = response.details.user_name;
                        document.getElementById('user_phone').innerText = response.details.user_phone;
                        document.getElementById('user_adresse').innerText = response.details.user_adresse;
                        document.getElementById('price_night').innerText = response.details.price;
                        document.getElementById('total_payment').innerText = response.details.total_pay;
                    } else {
                        console.log('No details found');
                    }
                } catch (error) {
                    console.error('Error parsing JSON response');
                }
            }
            xhr.send('get_details=' + id);
        }


        window.onload = function () {
            get_bookings();
        }
    </script>

</body>

</html>