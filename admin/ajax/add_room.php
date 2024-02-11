<?php
require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();


if (isset($_POST['add_room'])) {
    $features = filteration(json_decode($_POST['features']));
    $facilities = filteration(json_decode($_POST['facilities']));
    $form_data = filteration($_POST);
    $flag = 0;
    $q = "INSERT INTO `rooms` (`name`, `area`, `price`, `quantity`, `adult`, `children`, `description`) VALUES (?,?,?,?,?,?,?)";
    $values = [$form_data['name'], $form_data['area'], $form_data['price'], $form_data['quantity'], $form_data['adult'], $form_data['children'], $form_data['description']];
    if (insert($q, $values, 'siiiiis')) {
        $flag = 1;
    }
    $room_id = mysqli_insert_id($con);
    $q2 = "INSERT INTO `room_facilities`(`room_id`, `facilities_id`) VALUES (?,?)";
    if ($stmt = mysqli_prepare($con, $q2)) {
        foreach ($facilities as $f) {
            mysqli_stmt_bind_param($stmt, 'ii', $room_id, $f);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        $flag = 0;
        die("query can not be prepared");
    }
    $q3 = "INSERT INTO `room_features`(`room_id`, `features_id`) VALUES (?,?)";
    if ($stmt = mysqli_prepare($con, $q3)) {
        foreach ($features as $f) {
            mysqli_stmt_bind_param($stmt, 'ii', $room_id, $f);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        $flag = 0;
        die("query can not be prepared");
    }
    if ($flag) {
        echo 1;
    } else {
        echo 0;
    }
}
if (isset($_POST['get_rooms'])) {
    $res = select("SELECT * FROM `rooms` WHERE `removed`=?",[0],"i");
    $i = 1;
    $data = "";
    while ($row = mysqli_fetch_assoc($res)) {
        if ($row['status'] == 1) {
            $status = '<button onclick=\'toggle_status(' . $row['id'] . ', 0)\' class="btn btn-dark btn-sm shadow-none">active</button>';
        } else {
            $status = '<button onclick=\'toggle_status(' . $row['id'] . ', 1)\' class="btn btn-warning btn-sm shadow-none">inactive</button>';
        }
        $data .= "
        <tr class='align-middle'>
            <td>$i</td>
            <td>$row[name]</td>
            <td>$row[area]</td>
            <td>
            <span class='badge rounded-pill bg-light text-dark'>Adult:$row[adult]</span><br>
            <span class='badge rounded-pill bg-light text-dark'>Children:$row[children]</span>
            </td>
            <td>$row[price]</td>
            <td>$row[quantity]</td>
            <td>$status</td>
            <td>
            <button type='button' onclick='edit_details($row[id])' class='btn btn-primary me-2 shadow-none btn-sm' data-bs-toggle='modal'
            data-bs-target='#edit_room_modal'>
            <i class='bi bi-pencil-square'></i>
            <button type='button' onclick=\"room_images($row[id],'$row[name]')\" class='btn btn-info shadow-none btn-sm' data-bs-toggle='modal'
            data-bs-target='#room_images'>
            <i class='bi bi-images'></i>
        </button>
        <button type='button' onclick=\"remove_room($row[id])\" class='btn btn-danger me-2 shadow-none btn-sm'>
        <i class='bi bi-trash'></i>

        </button>
        </td>
        </tr>";
        $i++;

    }
    echo $data;
}
if (isset($_POST['remove_room'])) {
    $form_data = filteration($_POST);
    $values = [$form_data['room_id']];

    // Supprimer les images associées à la chambre
    $req = select("SELECT * FROM `rooms_image` WHERE `room_id`=?", [$form_data['room_id']], "i");
    while ($res = mysqli_fetch_assoc($req)) {
        deleteImage($res['images'], ROOMS_FOLDER);
    }
    // Supprimer les enregistrements dans les tables associées
    $res2 = delete("DELETE FROM `rooms_image` WHERE `room_id`=?", [$form_data['room_id']], "i");
    $res3 = delete("DELETE FROM `room_facilities` WHERE `room_id`=?", [$form_data['room_id']], "i");
    $res4 = delete("DELETE FROM `room_features` WHERE `room_id`=?", [$form_data['room_id']], "i");
    $res5 = update("UPDATE `rooms` SET `removed`=? WHERE `id`=?", [1, $form_data['room_id']], "ii");

    if ($res2 || $res3 || $res4 || $res5) {
        echo 1;
    } else {
        echo 0;
    }
}
if (isset($_POST['toggle_status'])) {
    $form_data = filteration($_POST);
    $q = "UPDATE `rooms` SET `status`=? WHERE `id`=?";
    $values = [$form_data['value'], $form_data['toggle_status']];
    if (update($q, $values, 'ii')) {
        echo 1;
    } else {
        echo 0;
    }
}
if (isset($_POST['get_room'])) {
    $form_data = filteration($_POST);
    $res = select("SELECT * FROM `rooms` WHERE `id`=?", [$form_data['get_room']], "i");
    $res1 = select("SELECT * FROM `room_features` WHERE `room_id`=?", [$form_data['get_room']], "i");
    $res2 = select("SELECT * FROM `room_facilities` WHERE `room_id`=?", [$form_data['get_room']], "i");

    $room_data = mysqli_fetch_assoc($res);
    $features = [];
    if (mysqli_num_rows($res1) > 0) {
        while ($row = mysqli_fetch_assoc($res1)) {
            array_push($features, $row['features_id']);
        }
    }
    $facilities = [];
    if (mysqli_num_rows($res2) > 0) {
        while ($row = mysqli_fetch_assoc($res2)) {
            array_push($facilities, $row['facilities_id']);
        }
    }
    $data = ['room_data' => $room_data, 'features' => $features, 'facilities' => $facilities];
    $data = json_encode($data);
    echo $data;
}
if (isset($_POST['edit_room'])) {
    $features = filteration(json_decode($_POST['features']));
    $facilities = filteration(json_decode($_POST['facilities']));
    $form_data = filteration($_POST);
    $flag = 0;
    $q = "UPDATE `rooms` SET `name`=?,`area`=?,`price`=?,`quantity`=?,`adult`=?,`children`=?,`description`=? WHERE `id`=?";
    $values = [$form_data['name'], $form_data['area'], $form_data['price'], $form_data['quantity'], $form_data['adult'], $form_data['children'], $form_data['description'], $form_data['room_id']];
    if (update($q, $values, 'siiiiisi')) {
        $flag = 1;
    }
    $del_features = delete("DELETE FROM `room_features` WHERE `room_id`=?", [$form_data['room_id']], "i");
    $del_facilities = delete("DELETE FROM `room_facilities` WHERE `room_id`=?", [$form_data['room_id']], "i");
    if (!($del_features && $del_facilities)) {
        $flag = 0;
    }
    $q2 = "INSERT INTO `room_facilities`(`room_id`, `facilities_id`) VALUES (?,?)";
    if ($stmt = mysqli_prepare($con, $q2)) {
        foreach ($facilities as $f) {
            mysqli_stmt_bind_param($stmt, 'ii', $form_data['room_id'], $f);
            mysqli_stmt_execute($stmt);
        }
        $flag = 1;
        mysqli_stmt_close($stmt);
    } else {
        $flag = 0;
        die("query can not be prepared");
    }
    $q3 = "INSERT INTO `room_features`(`room_id`, `features_id`) VALUES (?,?)";
    if ($stmt = mysqli_prepare($con, $q3)) {
        foreach ($features as $f) {
            mysqli_stmt_bind_param($stmt, 'ii', $form_data['room_id'], $f);
            mysqli_stmt_execute($stmt);
        }
        $flag = 1;
        mysqli_stmt_close($stmt);
    } else {
        $flag = 0;
        die("query can not be prepared");
    }
    if ($flag) {
        echo 1;
    } else {
        echo 0;
    }
}


if (isset($_POST['add_image'])) {
    $form_data = filteration($_POST);
    $img_r = uploadImage($_FILES['image'], ROOMS_FOLDER);
    if ($img_r == 'inv_img') {
        echo $img_r;
    } elseif ($img_r == 'inv_size') {
        echo $img_r;
    } elseif ($img_r == 'upl_failed') {
        echo $img_r;
    } else {
        $q = "INSERT INTO `rooms_image`(`room_id`, `images`) VALUES (?,?)";
        $values = [$form_data['room_id'], $img_r];
        $res = insert($q, $values, 'is');
        echo $res;
    }
}
if (isset($_POST['get_room_images'])) {
    $form_data = filteration($_POST);
    $res = select("SELECT * FROM `rooms_image` WHERE `room_id`=?", [$form_data['get_room_images']], "i");
    $path = ROOMS_IMG_PATH;
    $data = "";
    while ($row = mysqli_fetch_assoc($res)) {
        if ($row['thumb'] == 1) {
            $thumb = "<i class='bi bi-check-lg text-light bg-success px-2 rounded fs-5'></i>";
        } else {
            $thumb = "<button type='button' onclick='thumb_img($row[id],$row[room_id])' class='btn btn-secondary me-2 shadow-none'>
            <i class='bi bi-check-lg'></i>
         </button>";
        }
        $data .= "
        <tr class='align-middle'>
            <td><img src='$path$row[images]' style='width:30px'/></td>
            <td>$thumb</td>
            <td>
            <button type='button' onclick='rem_img($row[id],$row[room_id])' class='btn btn-danger me-2 shadow-none'>
               <i class='bi bi-trash'></i>
            </button>
           </td>
        </tr>";
    }
    echo $data;
}

if (isset($_POST['rem_img'])) {
    $form_data = filteration($_POST);
    $values = [$form_data['image_id'], $form_data['room_id']];
    $req = "SELECT * FROM `rooms_image` WHERE `id`=? AND `room_id`=?";
    $res = select($req, $values, "ii");
    $img = mysqli_fetch_assoc($res);
    if (deleteImage($img['images'], ROOMS_FOLDER)) {
        $del = "DELETE FROM `rooms_image` WHERE `id`=? AND `room_id`=?";
        $res = delete($del, $values, 'ii');
        echo $res;
    } else {
        echo 0;
    }
}

if (isset($_POST['thumb_img'])) {
    $form_data = filteration($_POST);
    $req1 = "UPDATE `rooms_image` SET `thumb`=? WHERE `room_id`=?";
    $values1 = [0, $form_data['room_id']];
    $res = update($req1, $values1, "ii");

    $req2 = "UPDATE `rooms_image` SET `thumb`=? WHERE `id`=? AND `room_id`=?";
    $values2 = [1, $form_data['image_id'], $form_data['room_id']];
    $res = update($req2, $values2, "iii");
    echo $res;

}
?>