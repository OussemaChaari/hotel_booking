<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <?php require('inc/links.php'); ?>
    <title>
        <?= $data_settings['site_title']; ?> - Rooms
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
    <div class="my-5 px-4 container">
        <h2 class="fw-bold text-center">Our Rooms</h2>
        <div class="line bg-dark"></div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-12 mb-4 mb-lg-0 ps-4">
                <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                    <div class="container-fluid flex-lg-column align-items-stretch">
                        <h4 class="mt-2">Filter</h4>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#filterDropdown" aria-controls="navbarNav" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse flex-column mt-2 align-items-stretch" id="filterDropdown">
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="mb-3 d-flex align-items-center justify-content-between" style="font-size:18px;">
                                <span>Check Avaibility</span>
                                <button id="chk_avail_btn" onclick="check_avail_clear()" class="btn btn-sm text-secondary d-none">Reset</button>
                               </h5>
                                <label class="form-label">Check-in</label>
                                <input type="date" class="form-control shadow-none mb-3" id="check_in" onchange="check_avail_filter()">
                                <label class="form-label">Check-out</label>
                                <input type="date" class="form-control shadow-none" id="check_out" onchange="check_avail_filter()">
                            </div>
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="mb-3 mb-3 d-flex align-items-center justify-content-between" style="font-size:18px;">
                                <span>Guests</span>
                                <button id="guest_btn" onclick="guests_clear()" class="btn btn-sm text-secondary d-none">Reset</button>

                                </h5>
                                <div class="d-flex">
                                    <div class="me-3">
                                        <label class="form-label">Adults</label>
                                        <input type="number" min="1" id="adults" oninput="guest_filter()" class="form-control shadow-none mb-3">
                                    </div>
                                    <div>
                                        <label class="form-label">Children</label>
                                        <input type="number" min="1" id="children" oninput="guest_filter()" class="form-control shadow-none mb-3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="col-lg-9 col-md-12 px-4" id="data_rooms">

            </div>
        </div>
    </div>
    <script>
        let data_rooms = document.getElementById('data_rooms');
        let check_in = document.getElementById('check_in');
        let check_out = document.getElementById('check_out');
        let chk_avail_btn = document.getElementById('chk_avail_btn');
        let adults = document.getElementById('adults');
        let children = document.getElementById('children');
        let guest_btn = document.getElementById('guest_btn');

        function fetch_room() {
            let check_avail = JSON.stringify({
                'checkin': check_in.value,
                'checkout': check_out.value
            });
            let guests = JSON.stringify({
                'adults': adults.value,
                'children': children.value
            });
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "ajax/rooms.php?fetch_room&check_avail="+check_avail+"&guests="+guests, true);
            xhr.onprogress = function () {
                data_rooms.innerHTML = `<div class="spinner-border text-info mb-3 mx-auto d-block" id="rooms_loader" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>`;
            }
            xhr.onload = function () {
                data_rooms.innerHTML = this.responseText;
            }
            xhr.send();
        }
        function check_avail_filter(){
            if(check_in.value != "" && check_out.value !="" ){
                fetch_room();
                chk_avail_btn.classList.remove('d-none');
            }
        }
        function guest_filter(){
            if(adults.value > 0 && children.value > 0 ){
                fetch_room();
                guest_btn.classList.remove('d-none');
            }
        }
        function check_avail_clear(){
            check_in.value = "";
            check_out.value = "";
            chk_avail_btn.classList.add('d-none');
            fetch_room();
        }
        function guests_clear(){
            adults.value = "";
            children.value = "";
            guest_btn.classList.add('d-none');
            fetch_room();
        }
        fetch_room();

    </script>

    <?php require('inc/footer.php'); ?>




</body>

</html>