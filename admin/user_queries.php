<?php
require('inc/essentials.php');
require('inc/db_config.php');
adminLogin();

if (isset($_GET['seen'])) {
    $form_data = filteration($_GET);
    if ($form_data['seen'] == 'all') {
        $q = "UPDATE `user_queries` SET `seen`=?";
        $values = [1];
        if (update($q, $values, 'i')) {
            alert('success', 'Marked all as readed!');
        } else {
            alert('error', 'failed operation!');

        }
    } else {
        $q = "UPDATE `user_queries` SET `seen`=? WHERE `id`=?";
        $values = [1, $form_data['seen']];
        if (update($q, $values, 'ii')) {
            alert('success', 'update successfuly!');
        } else {
            alert('error', 'failed update!');

        }
    }

}

if (isset($_GET['del'])) {
    $form_data = filteration($_GET);
    if ($form_data['del'] == 'all') {
        $q = "DELETE FROM `user_queries`";
        if (mysqli_query($con,$q)) {
            alert('success', 'all data is deleted!');
        } else {
            alert('error', 'failed operation!');

        }
    } else {
        $q = "DELETE FROM `user_queries` WHERE `id`=?";
        $values = [$form_data['del']];
        if (delete($q, $values, 'i')) {
            alert('success', 'delete successfuly!');
        } else {
            alert('error', 'failed delete!');

        }
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Queries</title>
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
                <!-- genral settings -->
                <h4 class="mb-4">Users Queries</h4>
                <!-- Carousel -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <a href="?seen=all" class="btn btn-dark rounded-pill shadow-none btn-sm">
                                <i class="bi bi-check-all"></i> Mark all read</a>
                            <a href="?del=all" class="btn btn-danger rounded-pill shadow-none btn-sm">
                                <i class="bi bi-trash"></i> Delete All</a>
                        </div>
                        <div class="table-responsive-md" style="height:450px;overflow-y:scroll;">
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col">Message</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $queries = "SELECT * FROM `user_queries` ORDER BY `id` DESC";
                                    $querie = mysqli_query($con, $queries);
                                    $i = 1;

                                    while ($row = mysqli_fetch_assoc($querie)) {
                                        $seen = '';
                                        if ($row['seen'] != 1) {
                                            $seen = "<a href='?seen=$row[id]' class='btn btn-sm rounded-pill btn-primary me-2' >Mark as read</a>";
                                        }
                                        $seen .= "<a href='?del=$row[id]' class='btn btn-sm rounded-pill btn-danger'>Delete</a>";

                                        echo <<<query
                                                <tr>
                                                    <th scope="row">$i</th>
                                                    <td>{$row['name']}</td>
                                                    <td>{$row['email']}</td>
                                                    <td>{$row['subject']}</td>
                                                    <td>{$row['message']}</td>
                                                    <td>{$row['date']}</td>
                                                    <td>{$seen}</td>
                                                </tr>
                                            query;
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require('inc/scripts.php'); ?>
</body>

</html>