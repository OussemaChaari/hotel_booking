<?php
define('SITE_URL', 'http://127.0.0.1/HotelBooking/');
define('ABOUT_IMG_PATH', SITE_URL.'images/about/');
define('CAROUSEL_IMG_PATH', SITE_URL.'images/carousel/');
define('FACILITIES_IMG_PATH', SITE_URL.'images/facilities/');
define('ROOMS_IMG_PATH', SITE_URL.'images/rooms/');
define('USERS_IMG_PATH', SITE_URL.'images/users/');


define('UPLOAD_IMAGE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/HotelBooking/images/');
define('ABOUT_FOLDER', 'about/');
define('CAROUSEL_FOLDER', 'carousel/');
define('FACILITIES_FOLDER', 'facilities/');
define('ROOMS_FOLDER', 'rooms/');
define('USERS_FOLDER', 'users/');


function adminLogin()
{
  session_start();
  if (!isset($_SESSION['admin_login'])) {
    redirect('index.php');
    exit;
  }
}
function redirect($url)
{
  echo "<script>
    window.location.href='$url';
    </script>";
  exit;
}
function alert($type, $msg)
{
  $bs_class = ($type == "success") ? "alert-success" : "alert-danger";
  echo '<div class="alert ' . $bs_class . ' alert-dismissible fade show custom-alert" role="alert">
      <strong>' . $msg . '</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}

function uploadImage($image, $folder)
{
  $valid_mine = ['image/png', 'image/jpg'];
  $img_mine = $image['type'];
  if (!in_array($img_mine, $valid_mine)) {
    return 'inv_img';
  }elseif(($image['size']/(1024*1024))>2){
    return 'inv_size';
  } else {
    $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
    $rname = 'IMG_' . random_int(11111, 99999) . ".$ext";
    $img_path = UPLOAD_IMAGE_PATH . $folder . $rname;
    if (move_uploaded_file($image['tmp_name'], $img_path)) {
      return $rname;
    } else {
      return 'upl_failed';
    }
  }

}
function deleteImage($image,$folder){
    if(unlink(UPLOAD_IMAGE_PATH.$folder.$image)){
      return true;
    }else{
      return false;
    }
}



function uploadSVGImage($image, $folder)
{
  $valid_mine = ['image/svg+xml'];
  $img_mine = $image['type'];
  if (!in_array($img_mine, $valid_mine)) {
    return 'inv_img';
  }elseif(($image['size']/(1024*1024))>1){
    return 'inv_size';
  } else {
    $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
    $rname = 'IMG_' . random_int(11111, 99999) . ".$ext";
    $img_path = UPLOAD_IMAGE_PATH . $folder . $rname;
    if (move_uploaded_file($image['tmp_name'], $img_path)) {
      return $rname;
    } else {
      return 'upl_failed';
    }
  }
}

?>