<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <?php require('inc/links.php'); ?>
    <title><?= $data_settings['site_title']; ?> - Contact</title>
    <style>
        .line {
            width: 150px !important;
            margin: 0 auto !important;
            height: 1.7px;
        }

        .custom-alert {
            position: fixed !important;
            top: 80px !important;
            right: 25px !important;
        }
    </style>
</head>

<body class="bg-light">
    <?php require('inc/header.php'); ?>
    <div class="my-5 px-4 container">
        <h2 class="fw-bold text-center">Contact Us</h2>
        <div class="line bg-dark"></div>
        <p class="text-center mt-3">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam ab possimus, optio quos sunt voluptatem
            ipsam facere harum sint dicta sapiente explicabo, tempore vero aperiam quasi a, fugiat eius placeat.
        </p>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4">
                    <iframe class="w-100 rounded mb-4" src="<?= $data_contact['iframe']; ?>" height="350px" style="border:0;"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <h5>Adresse</h5>
                    <a href="<?= $data_contact['gmap']; ?>" target="_blank" class="text-decoration-none d-inline-block">
                        <i class="bi bi-geo-alt-fill"></i>
                        <?= $data['address']; ?>
                    </a>
                    <h5 class="mt-4">Call us</h5>
                    <a href="tel:+<?= $data_contact['pn1']; ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i> +
                        <?= $data_contact['pn1']; ?>
                    </a>
                    <br />
                    <?php
                    if ($data_contact['pn2'] != '') {
                        echo <<<data
                    <a href="tel: +{$data_contact['pn2']}" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i> +{$data_contact['pn2']}
                    </a>
                    data;
                    }
                    ?>
                    <h5 class="mt-4">Email</h5>
                    <a href="mailto:<?= $data_contact['email']; ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-envelope-fill"></i>
                        <?= $data_contact['email']; ?>
                    </a>
                    <h5 class="mt-4">Follow us</h5>
                    <?php
                    if ($data_contact['tw'] != '') {
                        echo <<<data
                    <a href="{$data_contact['tw']}" class="d-inline-block  text-dark fs-5 me-2">
                        <i class="bi bi-twitter me-1"></i>
                    </a>
                    data;
                    }
                    ?>
                    <?php
                    if ($data_contact['fb'] != '') {
                        echo <<<data
                    <a href="{$data_contact['fb']}" class="d-inline-block  text-dark fs-5 me-2">
                        <i class="bi bi-facebook me-1"></i>
                    </a>
                    data;
                    }
                    ?>
                    <?php
                    if ($data_contact['insta'] != '') {
                        echo <<<data
                    <a href="{$data_contact['insta']}" class="d-inline-block  text-dark fs-5">
                        <i class="bi bi-instagram me-1"></i>
                    </a>
                    data;
                    }
                    ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 px-4">
                <div class="bg-white rounded shadow p-4">
                    <form action="" method="POST">
                        <h5>Send Message</h5>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight:500;">Name</label>
                            <input type="text" name="name" class="form-control shadow-none" required>
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight:500;">Email</label>
                            <input type="email" name="email" class="form-control shadow-none" required>
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight:500;">Subject</label>
                            <input type="text" name="subject" class="form-control shadow-none" required>
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight:500;">message</label>
                            <textarea name="message" class="form-control shadow-none" rows="5" style="resize:none;"
                                required></textarea>
                        </div>
                        <button type="submit" name="send"
                            class="btn text-white shadow-none custom-bg mt-3">Send</button>

                    </form>
                </div>

            </div>
        </div>
    </div>
    <?php
    if (isset($_POST['send'])) {
        $form_data = filteration($_POST);
        $user_queries = "INSERT INTO `user_queries`(`name`, `email`, `subject`, `message`) VALUES (?,?,?,?)";
        $values = [$form_data['name'], $form_data['email'], $form_data['subject'], $form_data['message']];
        $res = insert($user_queries, $values, "ssss");
        if ($res == 1) {
            alert('success', 'Mail Send!');
        } else {
            alert('error', 'Try again later!');
        }
    }


    ?>
    <?php require('inc/footer.php'); ?>
</body>

</html>