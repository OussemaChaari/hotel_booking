<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <?php require('inc/links.php'); ?>
    <title><?= $data_settings['site_title']; ?> - details room</title>
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
    if (!isset($_GET['id'])) {
        redirect('rooms.php');
    }
    $data = filteration($_GET);
    $room_res = select("SELECT * FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?", [$data['id'], 1, 0], 'iii');
    if (mysqli_num_rows($room_res) === 0) {
        redirect('rooms.php');
    }
    $room_data = mysqli_fetch_assoc($room_res);
    ?>


    <div class="container">
        <div class="row">
            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold">
                    <?= $room_data['name']; ?>
                </h2>
                <div style="font-size:14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">Home</a>
                    <span class="text-secondary">></span>
                    <a href="rooms.php" class="text-secondary text-decoration-none">Rooms</a>
                </div>
            </div>
            <div class="col-lg-7 col-md-12 px-4">
                <div id="carousel_room" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        $room_img = ROOMS_IMG_PATH . "NotFoundImage.png";
                        $img_q = mysqli_query($con, "SELECT * FROM `rooms_image` WHERE `room_id`='$room_data[id]'");

                        if (mysqli_num_rows($img_q) > 0) {
                            $active_class = 'active';
                            while ($img_res = mysqli_fetch_assoc($img_q)) {
                                echo "<div class='carousel-item $active_class'>
                    <img src='" . ROOMS_IMG_PATH . $img_res['images'] . "' class='d-block w-100 rounded'>
                  </div>";
                                $active_class = '';
                            }
                        } else {
                            echo "<div class='carousel-item active'>
                <img src='$room_img' class='d-block w-100'>
              </div>";
                        }
                        ?>

                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel_room"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel_room"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <?php
                        echo <<<price
                    <h4 class="mb-4">$ {$room_data['price']} per night</h4>

                    price;
                        echo <<<rating
                    <span class="badge bg-light rounded-pill">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                            </span>

                    rating;


                        $fea_q = mysqli_query($con, "SELECT f.name FROM `features` f INNER JOIN `room_features` rfea ON f.id= rfea.features_id WHERE rfea.room_id ='$room_data[id]'");
                        $features_data = "";
                        while ($fea_row = mysqli_fetch_assoc($fea_q)) {
                            $features_data .= "<span class='badge bg-info me-2 rounded-pill text-dark text-wrap'>
                                            {$fea_row['name']}
                                        </span>";
                        }
                        
                        echo <<<features
                        <div class='features mb-3 mt-2'>
                        <h6 class="mb-1">Features</h6>
                            {$features_data}
                        </div>
                    features;


                        $fac_q = mysqli_query($con, "SELECT f.name FROM `facilities` f INNER JOIN `room_facilities` rfac ON f.id= rfac.facilities_id WHERE rfac.room_id ='$room_data[id]'");
                        $facilities_data = "";
                        while ($fac_row = mysqli_fetch_assoc($fac_q)) {
                            $facilities_data .= "<span class='badge bg-info me-2 rounded-pill text-dark text-wrap'>
                        $fac_row[name]
                    </span>";
                        }
                        echo <<<facilities
                        <div class='facilities mb-3 mt-2'>
                        <h6 class="mb-1">Facilities</h6>
                            {$facilities_data}
                        </div>
                        facilities;

                        echo <<<guests
                        <div class='mb-3 mt-2'>

                        <h6 class="mb-1">Guests</h6>
                                    <span class="badge bg-info rounded-pill text-dark text-wrap">
                                        {$room_data['adult']} Adult
                                    </span>
                                    <span class="badge bg-info rounded-pill text-dark text-wrap">
                                        {$room_data['children']} Children
                                    </span>
                                    </div>
                        guests;
                        echo <<<area
                        <div class='mb-3 mt-2'>
                        <h6 class='mb-1'>Area</h6>
                        <span class="badge bg-info rounded-pill text-dark text-wrap">
                        {$room_data['area']} sq . ft
                                    </span>
                                    </div>
                        area;
                        $book_btn = "";
                        if ($data_settings['shutdown'] === 0) {
                            $login = 0;
                            if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
                                $login = 1;
                            }
                            $book_btn = "<button onclick='checkLoginToBook({$login}, {$room_data['id']})' class='btn text-white w-100 custom-bg shadow-none mb-1'>Book Now</button>";
                        }
                        echo <<<book
                        $book_btn
                        book;
                        ?>



                    </div>
                </div>
            </div>
            <div class="col-12 mt-4 px-4">
                <div class="mb-4">
                    <h5>Description</h5>
                    <p>
                        <?= $room_data['description']; ?>
                    </p>
                </div>
                <div class="mb-4">
                    <h5>Reviews & Ratings</h5>
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <img src="images/testimonials/pic-3.png" alt="">
                            <h6 class="m-0 ms-2">Name</h6>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio nobis voluptates dolore
                            laudantium
                            libero deleniti possimus, accusamus vel esse consequatur deserunt aperiam odit quam voluptas
                            dolores quo ad? Facere, cumque?</p>
                        <div class="rating">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require('inc/footer.php'); ?>




</body>

</html>