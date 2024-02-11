<?php 
require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();
if (isset($_POST['get_users'])) {
    $res = selectAll("user_cred");
    $i = 1;
    $data = "";
    $path = USERS_IMG_PATH;
    while ($row = mysqli_fetch_assoc($res)) {
        if ($row['status'] == 1) {
            $status = "<button class='btn btn-sm shadow-none toggle-button' onclick='toggle_status($row[id], 0)'>";
            $status .= "<span class='badge bg-success'><i class='bi bi-check-lg'></i></span>";
        } else {
            $status = "<button class='btn btn-sm shadow-none toggle-button' onclick='toggle_status($row[id], 1)'>";
            $status .= "<span class='badge bg-warning'><i class='bi bi-x-lg'></i></span>";
        }
        $status .= "</button>";
        $data .= "
        <tr class='align-middle'>
            <td>$i</td>
            <td><img src='$path$row[profile]' style='width:20px;height:20px;'/>
            $row[name]</td>
            <td>$row[email]</td>
            <td>$row[phone]</td>
            <td>$row[adresse]</td>
            <td>$row[dob]</td>
            <td>$status</td>
            <td>$row[created_at]</td>
            <td><button type='button' onclick='remove_user($row[id])' class='btn btn-danger me-2 shadow-none btn-sm'><i class='bi bi-trash'></i></button></td>
        </tr>";
        $i++;

    }
    echo $data;
}
if (isset($_POST['toggle_status'])) {
    $form_data = filteration($_POST);
    $q = "UPDATE `user_cred` SET `status`=? WHERE `id`=?";
    $values = [$form_data['value'], $form_data['toggle_status']];
    if (update($q, $values, 'ii')) {
        echo 1;
    } else {
        echo 0;
    }
}
if (isset($_POST['remove_user'])) {
    $form_data = filteration($_POST);
    $req = select("SELECT * FROM `user_cred` WHERE `id`=?", [$form_data['user_id']], "i");
    while ($res = mysqli_fetch_assoc($req)) {
        deleteImage($res['profile'], USERS_FOLDER);
    }
    $res =  delete("DELETE FROM `user_cred` WHERE `id`=?",[$form_data['user_id']], "i");
    if ($res) {
        echo 1;
    } else {
        echo 0;
    }   
}
if (isset($_POST['search_users'])) {
    $form_data = filteration($_POST);
         
    // Validate and sanitize the input (assuming you have a function named "validate_input")
    $search_term = $form_data['name'];

    // Perform the search query
    $search_query = "SELECT * FROM user_cred WHERE name LIKE ?";
    $search_term = "%{$search_term}%"; // Add wildcard characters for a partial search
    $search_result = select($search_query, [$search_term], "s");

    // Display the search result
    $data = "";
    $path = USERS_IMG_PATH;
    $i = 1;
    

    while ($row = mysqli_fetch_assoc($search_result)) {
        if ($row['status'] == 1) {
            $status = "<button class='btn btn-sm shadow-none toggle-button' onclick='toggle_status($row[id], 0)'>";
            $status .= "<span class='badge bg-success'><i class='bi bi-check-lg'></i></span>";
        } else {
            $status = "<button class='btn btn-sm shadow-none toggle-button' onclick='toggle_status($row[id], 1)'>";
            $status .= "<span class='badge bg-warning'><i class='bi bi-x-lg'></i></span>";
        }
        $status .= "</button>";
        $data .= "
        <tr class='align-middle'>
            <td>$i</td>
            <td><img src='{$path}{$row['profile']}' style='width:20px;height:20px;'/>
                {$row['name']}</td>
            <td>{$row['email']}</td>
            <td>{$row['phone']}</td>
            <td>{$row['adresse']}</td>
            <td>{$row['dob']}</td>
            <td>$status</td>
            <td>{$row['created_at']}</td>
            <td><button type='button' onclick=\"remove_user({$row['id']})\" class='btn btn-danger me-2 shadow-none btn-sm'><i class='bi bi-trash'></i></button></td>
        </tr>";
        $i++;
    }

    echo $data;
}
?>