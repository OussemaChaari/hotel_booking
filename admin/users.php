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
    <title>Users</title>

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
                <h4 class="mb-4">Users</h4>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <input type="text" oninput="search_users(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Search Users">
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover border text-center">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Date Of birth</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date Creation</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="users-data">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
  


    <?php require('inc/scripts.php'); ?>
    <script src="scripts/users.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>