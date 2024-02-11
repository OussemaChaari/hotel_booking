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
    <title>Rooms</title>

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
                <h4 class="mb-4">Rooms</h4>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
                                data-bs-target="#add_room_modal">
                                <i class="bi bi-plus"></i> Add Room
                            </button>
                        </div>

                        <div class="table-responsive-lg" style="height:450px;overflow-y:scroll;">
                            <table class="table table-hover border text-center">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Area</th>
                                        <th scope="col">Guests</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">quantity</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="rooms-data">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Rooms modal  -->
    <div class="modal fade" id="add_room_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="" id="add_room_form" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Room</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Area</label>
                                <input type="number" min="1" name="area" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" name="price" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" min="1" name="quantity" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Adult(max.)</label>
                                <input type="number" min="1" name="adult" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Children(min.)</label>
                                <input type="number" min="1" name="children" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Features</label>
                                <div class="row">
                                    <?php
                                    $res = selectAll('features');

                                    while ($opt = mysqli_fetch_assoc($res)) {
                                        echo <<<HTML
                                            <div class='col-md-3'>
                                                <label>
                                                    <input type='checkbox' name='features' value='{$opt['id']}' class='form-check-input'/>
                                                    {$opt['name']}
                                                </label>
                                            </div>
                                    HTML;
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Facilities</label>
                                <div class="row">
                                    <?php
                                    $res = selectAll('facilities');

                                    while ($opt = mysqli_fetch_assoc($res)) {
                                        echo <<<HTML
                                            <div class='col-md-3'>
                                                <label>
                                                    <input type='checkbox' name='facilities' value='{$opt['id']}' class='form-check-input'/>
                                                    {$opt['name']}
                                                </label>
                                            </div>
                                    HTML;
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" rows="4" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn text-secondary shadow-none"
                            data-bs-dismiss="modal">Close</button>

                        <button type="submit" class="btn custom-bg border-0 text-white">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>




    <!-- Rooms modal Edit -->
    <div class="modal fade" id="edit_room_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="" id="edit_room_form" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Room</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Area</label>
                                <input type="number" min="1" name="area" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" name="price" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" min="1" name="quantity" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Adult(max.)</label>
                                <input type="number" min="1" name="adult" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Children(min.)</label>
                                <input type="number" min="1" name="children" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Features</label>
                                <div class="row">
                                    <?php
                                    $res = selectAll('features');

                                    while ($opt = mysqli_fetch_assoc($res)) {
                                        echo <<<HTML
                                            <div class='col-md-3'>
                                                <label>
                                                    <input type='checkbox' name='features' value='{$opt['id']}' class='form-check-input'/>
                                                    {$opt['name']}
                                                </label>
                                            </div>
                                    HTML;
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Facilities</label>
                                <div class="row">
                                    <?php
                                    $res = selectAll('facilities');

                                    while ($opt = mysqli_fetch_assoc($res)) {
                                        echo <<<HTML
                                            <div class='col-md-3'>
                                                <label>
                                                    <input type='checkbox' name='facilities' value='{$opt['id']}' class='form-check-input'/>
                                                    {$opt['name']}
                                                </label>
                                            </div>
                                    HTML;
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" rows="4" class="form-control"></textarea>
                            </div>
                            <input type="hidden" name="room_id">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn text-secondary shadow-none"
                            data-bs-dismiss="modal">Close</button>

                        <button type="submit" class="btn custom-bg border-0 text-white">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Rooms modal images -->

    <div class="modal fade" id="room_images" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="image_alert">

                    </div>
                    <div class="border-bottom border-3 pb-3 mb-3">
                        <form action="" id="add_image_form">
                            <label class="form-label">Add Image</label>
                            <input type="file" name="image" accept=".jpg, .png" id="picture_inp"
                                class="form-control shadow-none mb-3" required>
                            <button class="btn custom-bg border-0 text-white">Save</button>
                            <input type="hidden" name="room_id">
                        </form>
                    </div>
                    <div class="table-responsive-lg" style="height:350px;overflow-y:scroll;">
                        <table class="table table-hover border text-center">
                            <thead>
                                <tr class="bg-dark text-light sticky-top">
                                    <th scope="col" width="60%">Image</th>
                                    <th scope="col">Thumb</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody id="images-data">

                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>


    <?php require('inc/scripts.php'); ?>
    <script src="scripts/rooms.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>