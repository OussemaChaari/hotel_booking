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
    <title>List Payements</title>

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
                <h4 class="mb-4">List Payements</h4>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover border text-center">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col">User Name</th>
                                        <th scope="col">Payement Method</th>
                                        <th scope="col">Account Number</th>
                                        <th scope="col">Payroll Amount</th>
                                        <th scope="col">Print</th>
                                    </tr>
                                </thead>
                                <tbody id="payement-data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require('inc/scripts.php'); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

        function get_payement() {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/bookings.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                document.getElementById('payement-data').innerHTML = this.responseText;
            }
            xhr.send('get_payement');
        }
        window.onload = function () {
            get_payement();
        }
    </script>

</body>

</html>