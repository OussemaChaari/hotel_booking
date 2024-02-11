<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php require('inc/links.php'); ?>

    <title>
        <?= $data_settings['site_title']; ?>
    </title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

</head>

<body class="bg-light">

    <?php require('inc/header.php'); ?>
    <!-- carousel  -->

    <div class="px-lg-4 mt-4">
        <div class="swiper swiper-container">
            <div class="swiper-wrapper">
                <?php
                $res = selectAll('carousel');
                while ($row = mysqli_fetch_assoc($res)) {
                    $path = CAROUSEL_IMG_PATH;
                    echo <<<data
            <div class="swiper-slide">
                    <img src="$path$row[image]" alt="" class="w-100 d-block">
                </div>
            
    data;
                }
                ?>


            </div>
        </div>
    </div>
    
    <!-- our Rooms  -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold">Our Rooms</h2>
    <div class="container">
        <div class="row">
            <?php
            $rooms_res = select("SELECT * FROM `rooms` WHERE `status`=? AND `removed`=? ORDER by `id` DESC LIMIT 3", [1, 0], "ii");
            while ($room_data = mysqli_fetch_assoc($rooms_res)) {
                // get features
                $fea_q = mysqli_query($con, "SELECT f.name FROM `features` f INNER JOIN `room_features` rfea ON f.id= rfea.features_id WHERE rfea.room_id ='$room_data[id]'");
                $features_data = "";
                while ($fea_row = mysqli_fetch_assoc($fea_q)) {
                    $features_data .= "<span class='badge bg-info me-2 rounded-pill text-dark text-wrap'>
                        $fea_row[name]
                    </span>";
                }
                //get facilities
                $fac_q = mysqli_query($con, "SELECT f.name FROM `facilities` f INNER JOIN `room_facilities` rfac ON f.id= rfac.facilities_id WHERE rfac.room_id ='$room_data[id]'");
                $facilities_data = "";
                while ($fac_row = mysqli_fetch_assoc($fac_q)) {
                    $facilities_data .= "<span class='badge bg-info me-2 rounded-pill text-dark text-wrap'>
                        $fac_row[name]
                    </span>";
                }
                // get thumbail of images
                $thumb_room = ROOMS_IMG_PATH . "NotFoundImage.png";
                $thumb_q = mysqli_query($con, "SELECT * FROM `rooms_image` WHERE `room_id`='$room_data[id]' AND `thumb`='1'");
                if (mysqli_num_rows($thumb_q) > 0) {
                    $thumb_res = mysqli_fetch_assoc($thumb_q);
                    $thumb_room = ROOMS_IMG_PATH . $thumb_res['images'];
                }
                $book_btn = "";
                if ($data_settings['shutdown'] === 0) {
                    $login = 0;
                    if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
                        $login = 1;
                    }
                    $book_btn = "<button onclick='checkLoginToBook({$login}, {$room_data['id']})' class='btn btn-sm text-white custom-bg shadow-none'>Book Now</button>";
                }
                echo <<<data
                    <div class="col-lg-4 col-md-6 my-3">
                        <div class="card border-0 shadow" style="max-width:350px;margin:auto;">
                            <img src="$thumb_room" class="card-img-top" style="height:180px;">
                            <div class="card-body">
                                <h5 class="card-title">{$room_data['name']}</h5>
                                <h6 class="mb-4">$ {$room_data['price']} per night</h6>
                                <div class="features mb-4">
                                    <h6 class="mb-1">Features</h6>
                                    $features_data
                                </div>
                                <div class="facilities mb-4">
                                    <h6 class="mb-1">Facilities</h6>
                                    $facilities_data

                                </div>
                                <div class="guests mb-4">
                                    <h6 class="mb-1">Guests</h6>
                                    <span class="badge bg-info rounded-pill text-dark text-wrap">
                                    {$room_data['adult']} Adult
                                    </span>
                                    <span class="badge bg-info rounded-pill text-dark text-wrap">
                                    {$room_data['children']} Children
                                    </span>
                                </div>
                                <div class="rating mb-4">
                                    <h6 class="mb-1">Rating</h6>
                                    <span class="badge bg-light rounded-pill">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-evenly mb-2">
                                $book_btn
                                    <a href="details_room.php?id={$room_data['id']}" class="btn btn-sm btn-outline-dark">Show details</a>
                                </div>
                            </div>
                        </div>
                 </div>
                data;
            }
            ?>
            <div class="col-lg-12 text-center mt-5">
                <a href="rooms.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">
                    More Rooms >>>
                </a>
            </div>
        </div>
    </div>
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold">Our Facilities</h2>
    <div class="container">
        <div class="row justify-content-evenly px-lg-0 px-md-0 px-sm-0">
            <?php
            $res = mysqli_query($con, "SELECT * FROM `facilities` ORDER BY id ASC LIMIT 2");
            $path = FACILITIES_IMG_PATH;

            while ($row = mysqli_fetch_assoc($res)) {
                echo <<<data
    <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-4">
        <img src="{$path}{$row['icon']}" alt="" style="width:80px;">
        <h5 class="mt-3">{$row['name']}</h5>
    </div>
data;
            }
            ?>


            <div class="col-lg-12 text-center mt-5">
                <a href="facilities.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">
                    More Facilities >>>
                </a>
            </div>
        </div>
    </div>

    <!-- testimonials  -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold">Our Testimonials</h2>
    <div class="container mt-5">
        <div class="swiper swiper-testimonials">
            <div class="swiper-wrapper mb-5">
            <?php
            $res = mysqli_query($con, "SELECT * FROM `team_details`");
            $path_about = ABOUT_IMG_PATH;
            while ($row = mysqli_fetch_assoc($res)) {
                echo <<<data
                <div class="swiper-slide bg-white p-4">
                <div class="profile d-flex align-items-center mb-3">
                    <img src="{$path_about}{$row['picture']}" alt="">
                    <h6 class="m-0 ms-2">{$row['name']}</h6>
                </div>
               
            </div>
data;
            }
            ?>
                
                
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <div class="col-lg-12 text-center mt-5">
            <a href="about.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">
                Know More >>>
            </a>
        </div>
    </div>

    <!-- Reach Us  -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold">Reach Us</h2>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
                <iframe class="w-100 rounded" src="<?= $data_contact['iframe']; ?>" height="350px" style="border:0;"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

            </div>
            <div class="col-lg-4 col-md-4">
                <div class="bg-white p-4 rounded mb-4">
                    <h5>Call us</h5>
                    <a href="tel: +<?= $data_contact['pn1']; ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i>
                        +
                        <?= $data_contact['pn1']; ?>
                    </a><br>
                    <?php
                    if ($data_contact['pn2'] != '') {
                        echo <<<data
        <a href="tel:+{$data_contact['pn2']}" class="d-inline-block mb-2 text-decoration-none text-dark">
            <i class="bi bi-telephone-fill"></i> +{$data_contact['pn2']}
        </a>
data;
                    }
                    ?>

                </div>
                <div class="bg-white p-4 rounded">
                    <h5>Follow us</h5>
                    <?php
                    if ($data_contact['tw'] != '') {
                        echo <<<data
                    <a href="{$data_contact['tw']}" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-twitter me-1"></i> {$data_contact['tw']}
                        </span>
                    </a>
                    data;
                    }
                    ?>
                    <br />
                    <?php
                    if ($data_contact['fb'] != '') {
                        echo <<<data
                    <a href="{$data_contact['fb']}" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-facebook me-1"></i> {$data_contact['fb']}
                        </span>
                    </a>
                    data;
                    }
                    ?>
                    <br />
                    <?php
                    if ($data_contact['insta'] != '') {
                        echo <<<data
                    <a href="{$data_contact['insta']}" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-instagram me-1"></i> {$data_contact['insta']}
                        </span>
                    </a>
                    data;
                    }
                    ?>
                    <br />

                </div>
            </div>
        </div>
    </div>

    <?php require('inc/footer.php'); ?>

    <br><br><br>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper1 = new Swiper('.swiper-container', {
            spaceBetween: 30,
            effect: 'fade',
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            }
        });
        const swiper2 = new Swiper(".swiper-testimonials", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "auto",
            slidesPerView: 3,
            loop: true,
            coverflowEffect: {
                rotate: 50,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadows: false,
            },
            pagination: {
                el: ".swiper-pagination",
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                }
            }
        });
    </script>

</body>

</html>