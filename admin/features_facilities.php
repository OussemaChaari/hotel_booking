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
    <title>Features & Facilities</title>
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
                <!-- features & facilities -->
                <h4 class="mb-4">Features & Facilities</h4>
                <!-- feature -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Features</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
                                data-bs-target="#features">
                                <i class="bi bi-plus"></i> Add
                            </button>
                        </div>
                        <div class="table-responsive-md" style="height:350px;overflow-y:scroll;">
                            <table class="table table-hover border">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col" width="20%">#</th>
                                        <th scope="col" width="70%">Name</th>
                                        <th scope="col" width="10%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="features-data">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- facilitie  -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Facilities</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
                                data-bs-target="#facilities">
                                <i class="bi bi-plus"></i> Add
                            </button>
                        </div>
                        <div class="table-responsive-md" style="height:350px;overflow-y:scroll;">
                            <table class="table table-hover border">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col" width="10%">#</th>
                                        <th scope="col" width="20%">Icon</th>
                                        <th scope="col" width="20%">Name</th>
                                        <th scope="col" width="40%">Description</th>
                                        <th scope="col" width="10%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="facilities-data">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



    <!-- feature modal  -->
    <div class="modal fade" id="features" tabindex="-1" aria-labelledby="TeamModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" id="features_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Features</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="feature_name" class="form-control shadow-none" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="reset" onclick="feature_name.value=''" class="btn text-secondary shadow-none"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn custom-bg border-0 text-white">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- facilitie modal  -->
    <div class="modal fade" id="facilities" tabindex="-1" aria-labelledby="TeamModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" id="facilities_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Facilitie</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="facility_name" class="form-control shadow-none" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Icon</label>
                            <input type="file" name="facility_icon" accept=".svg" class="form-control shadow-none"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="facility_description" class="form-control shadow-none" rows="2"
                                required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset"
                            onclick="facility_name.value='',facility_icon.value='',facility_description.value=''"
                            class="btn text-secondary shadow-none" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn custom-bg border-0 text-white">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php require('inc/scripts.php'); ?>
    <script src="scripts/features_facilities.js"></script>
</body>

</html>