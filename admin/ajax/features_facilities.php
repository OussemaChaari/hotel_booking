<?php
require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();


if (isset($_POST['add_feature'])) {
    $form_data = filteration($_POST);

    $q = "INSERT INTO `features` (`name`) VALUES (?)";
    $values = [$form_data['name']];
    $res = insert($q, $values, 's');
    echo $res;
}
if (isset($_POST['get_features'])) {
    $res = selectAll('features');
    $i = 1;

    while ($row = mysqli_fetch_assoc($res)) {
        echo <<<data
        <tr>
            <th scope="row">$i</th>
            <td>{$row['name']}</td>
            <td><button type="button" onclick="rem_feature({$row['id']})" class="btn btn-danger btn-sm">
            <i class="bi bi-trash"></i> Delete
            </button></td>
        </tr>
data;
$i++;

    }
}
if (isset($_POST['rem_feature'])) {
    $form_data = filteration($_POST);
    $values = [$form_data['rem_feature']];
    $q_check = select("SELECT * FROM `room_features` WHERE features_id=?",[$form_data['rem_feature']],"i");
    if(mysqli_num_rows($q_check) === 0){
        $del = "DELETE FROM `features` WHERE `id`=?";
        $res = delete($del,$values,'i');
        echo $res;
    }else{
        echo 'room_added';
    }
    
  
}

if (isset($_POST['add_facilitie'])) {
    $form_data = filteration($_POST);
    $img_r = uploadSVGImage($_FILES['icon'], FACILITIES_FOLDER);
    if ($img_r == 'inv_img') {
        echo $img_r;
    } elseif ($img_r == 'inv_size') {
        echo $img_r;
    } elseif ($img_r == 'upl_failed') {
        echo $img_r;
    } else {
        $q = "INSERT INTO `facilities` (`icon`,`name`,`description`) VALUES (?,?,?)";
        $values = [$img_r,$form_data['name'],$form_data['description']];
        $res = insert($q, $values, 'sss');
        echo $res;
    }
}
if (isset($_POST['get_facilities'])) {
    $res = selectAll('facilities');
    $i = 1;
$path = FACILITIES_IMG_PATH;
    while ($row = mysqli_fetch_assoc($res)) {
        echo <<<data
        <tr>
            <th scope="row">$i</th>
            <td>
            <img src="$path{$row['icon']}" style="width:30px;"/>
            </td>
            <td>{$row['name']}</td>
            <td>{$row['description']}</td>
            <td><button type="button" onclick="rem_facilitie({$row['id']})" class="btn btn-danger btn-sm">
            <i class="bi bi-trash"></i> Delete
            </button></td>
        </tr>
data;
$i++;

    }
}
if (isset($_POST['rem_facilitie'])) {
    $form_data = filteration($_POST);
    $values = [$form_data['rem_facilitie']];
    $q_check = select("SELECT * FROM `room_facilities` WHERE facilities_id=?",[$form_data['rem_facilitie']],"i");
    if(mysqli_num_rows($q_check) === 0){
        $req = "SELECT * FROM `facilities` WHERE `id`=?";
        $res = select($req, $values, "i");
        $img = mysqli_fetch_assoc($res);
        if(deleteImage($img['icon'],FACILITIES_FOLDER)){
            $del = "DELETE FROM `facilities` WHERE `id`=?";
            $res = delete($del,$values,'i');
            echo $res;
        }else{
          echo 0;
        }
    }else{
        echo 'room_added';
    }
    
  
}
?>