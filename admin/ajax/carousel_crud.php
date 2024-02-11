<?php
require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

if (isset($_POST['add_image'])) {
    $img_r = uploadImage($_FILES['picture'], CAROUSEL_FOLDER);
    if ($img_r == 'inv_img') {
        echo $img_r;
    } elseif ($img_r == 'inv_size') {
        echo $img_r;
    } elseif ($img_r == 'upl_failed') {
        echo $img_r;
    } else {
        $q = "INSERT INTO `carousel` (`image`) VALUES (?)";
        $values = [$img_r];
        $res = insert($q, $values, 's');
        echo $res;
    }
}
if (isset($_POST['get_carousel'])) {
    $res = selectAll('carousel');
    while ($row = mysqli_fetch_assoc($res)) {
        $path = CAROUSEL_IMG_PATH;
        echo <<<data
        <div class="col-md-2 mb-3">
            <div class="card bg-dark text-white">
                <img src="$path$row[image]" class="card-img" alt="...">
                <div class="card-img-overlay text-end">
                    <button class="btn btn-danger btn-sm shadow-none" onclick="rem_carousel($row[id])">
                        <i class="bi bi-trash"></i> Delete</button>
                </div>
            </div>
        </div>
data;
    }
}
if (isset($_POST['rem_carousel'])) {
    $form_data = filteration($_POST);
    $values = [$form_data['rem_carousel']];
    $req = "SELECT * FROM `carousel` WHERE `id`=?";
    $res = select($req, $values, "i");
    $img = mysqli_fetch_assoc($res);
    if(deleteImage($img['image'],CAROUSEL_FOLDER)){
        $del = "DELETE FROM `carousel` WHERE `id`=?";
        $res = delete($del,$values,'i');
        echo $res;
    }else{
      echo 0;
    }
}
?>