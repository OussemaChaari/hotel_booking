<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <?php require('inc/links.php'); ?>
    <title><?= $data_settings['site_title']; ?> - Facilities</title>
    <style>
        .pop:hover {
            border-top-color: var(--teal) !important;
            transform: scale(1.03);
            transition: all 0.3s;
        }

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

        <h2 class="fw-bold text-center">Our Facilities</h2>
        <div class="line bg-dark"></div>
        <p class="text-center mt-3">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam ab possimus, optio quos sunt voluptatem
            ipsam facere harum sint dicta sapiente explicabo, tempore vero aperiam quasi a, fugiat eius placeat.
        </p>
    </div>
    <div class="container">
        <div class="row">
            <?php
            $res = selectAll('facilities');
            $path = FACILITIES_IMG_PATH;

            while ($row = mysqli_fetch_assoc($res)) {
                echo <<<data
    <div class="col-lg-4 col-md-6 mb-5 px-4">
        <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
            <div class="d-flex align-items-center mb-2">
                <img src="{$path}{$row['icon']}" alt="" width="40px">
                <h5 class="m-0 ms-3">{$row['name']}</h5>
            </div>
            <p>
                {$row['description']}
            </p>
        </div>
    </div>
data;
            }
            ?>


        </div>
    </div>
    <?php require('inc/footer.php'); ?>



</body>

</html>