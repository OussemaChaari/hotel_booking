<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Poppins:wght@500;600;700;800&family=Rubik:ital,wght@0,400;0,500;1,300;1,400&display=swap">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="css/style.css">
<?php
session_start();
require('admin/inc/db_config.php');
require('admin/inc/essentials.php');
$contact_q = "SELECT * FROM `contact_details` WHERE `id`=?";
$values = [1];
$res = select($contact_q, $values, "i");
$data_contact = mysqli_fetch_assoc($res);

$settings_q = "SELECT * FROM `settings` WHERE `id`=?";
$res_settings = select($settings_q, $values, "i");
$data_settings = mysqli_fetch_assoc($res_settings);
if ($data_settings['shutdown'] === 1) {
    echo <<<alertbar
    <div class='bg-danger text-center p-2 fw-bold'>
    <i class="bi bi-exclamation-triangle-fill"></i>  Bookings are temporarily closed!
    </div>
alertbar;
}
?>