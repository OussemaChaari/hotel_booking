<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <?php require('inc/links.php'); ?>
    <title><?= $data_settings['site_title']; ?> - About</title>
    <style>
        .line {
            width: 150px !important;
            margin: 0 auto !important;
            height: 1.7px;
        }

        .box {
            border-top-color: var(--teal) !important;
        }
    </style>
</head>

<body class="bg-light">
    <?php require('inc/header.php'); ?>
    <div class="my-5 px-4 container">

        <h2 class="fw-bold text-center">About</h2>
        <div class="line bg-dark"></div>
        <p class="text-center mt-3">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam ab possimus, optio quos sunt voluptatem
            ipsam facere harum sint dicta sapiente explicabo, tempore vero aperiam quasi a, fugiat eius placeat.
        </p>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-4 order-lg-1 order-md-1 order-2">
                <h3 class="mb-3">lorem ispum dolor</h3>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta inventore enim perspiciatis maiores
                    natus modi exercitationem doloremque facere. Soluta temporibus incidunt expedita ad fugit corrupti
                    repellat harum modi reiciendis quas.
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta inventore enim perspiciatis maiores
                    natus modi exercitationem doloremque facere. Soluta temporibus incidunt expedita ad fugit corrupti
                    repellat harum modi reiciendis quas.
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta inventore enim perspiciatis maiores
                    natus modi exercitationem doloremque facere. Soluta temporibus incidunt expedita ad fugit corrupti
                    repellat harum modi reiciendis quas.
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta inventore enim perspiciatis maiores
                    natus modi exercitationem doloremque facere. Soluta temporibus incidunt expedita ad fugit corrupti
                    repellat harum modi reiciendis quas.
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta inventore enim perspiciatis maiores
                    natus modi exercitationem doloremque facere. Soluta temporibus incidunt expedita ad fugit corrupti
                    repellat harum modi reiciendis quas.
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta inventore enim perspiciatis maiores
                    natus modi exercitationem doloremque facere. Soluta temporibus incidunt expedita ad fugit corrupti
                    repellat harum modi reiciendis quas.
                </p>
            </div>
            <div class="col-lg-6 col-md-6 mb-4 order-lg-2 order-md-2 order-1">
                <img src="images/testimonials/pic-2.png" alt="" class="w-100">
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-3 col-md-3 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/about/rooms.png" alt="" width="150px" height="80px">
                    <h4 class="mt-4">+100 rooms</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/about/customers.png" alt="" width="150px" height="80px">
                    <h4 class="mt-4">+200 customers</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/about/reviews.png" alt="" width="150px" height="80px">
                    <h4 class="mt-4">+300 reviews</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/about/staff.png" alt="" width="150px" height="80px">
                    <h4 class="mt-4">+200 staffs</h4>
                </div>
            </div>
        </div>
    </div>

    <h3 class="my-5 fw-bold text-center">Managements Team</h3>
    <div class="container px-4">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper mb-5">



                <?php
                $all_team = selectAll('team_details');
                $path = ABOUT_IMG_PATH;
                while ($row = mysqli_fetch_assoc($all_team)) {
                    echo <<<data
        <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                    <img src="$path$row[picture]" alt="" class="w-100">
                    <h5 class="mt-2">$row[name]</h5>
                </div>
        data;
                }

                ?>


            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <?php require('inc/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper2 = new Swiper(".mySwiper", {
            slidesPerView: 4,
            spaceBetween: 40,
            loop: true,
            autoplay: {
                delay: 2500, // Délai entre chaque diapositive en millisecondes
                disableOnInteraction: false, // Empêcher la désactivation de l'autoplay après une interaction utilisateur
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
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 3,
                }
            }
        });
    </script>


</body>

</html>