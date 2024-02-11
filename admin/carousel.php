<?php
require('inc/essentials.php');
adminLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carousel</title>
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
                <h4 class="mb-4">Carousel</h4>
               

                <!-- Carousel -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Images</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
                                data-bs-target="#carousel">
                                <i class="bi bi-person-plus-fill"></i> Add
                            </button>
                        </div>
                        <div class="row" id="carousel-data">

                        </div>
                    </div>
                </div>

                <!-- modal Carousel  -->
                <div class="modal fade" id="carousel" tabindex="-1" aria-labelledby="carouselModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="" id="carousel_form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Image</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Picture</label>
                                        <input type="file" name="carousel_picture" accept=".jpg, .png"
                                            id="carousel_picture_inp" class="form-control shadow-none" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="carousel_picture.value=''"
                                        class="btn text-secondary shadow-none" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn custom-bg border-0 text-white">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require('inc/scripts.php'); ?>
    <script src="scripts/carousel.js"></script>

</body>

</html>