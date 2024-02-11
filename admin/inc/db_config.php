<?php 
$servername = "localhost";
$username = "root";
$password = "";
$database = "HotelBooking";

$con = mysqli_connect($servername, $username, $password, $database);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
function filteration($data){
    foreach ($data as $key => $value) {
        $value = trim($value);
        $value = stripcslashes($value);
        $value = htmlspecialchars($value);
        $value = strip_tags($value);
        $data[$key] = $value;
    }
    return $data;
}
function select($sql,$values,$datatypes){
    $con = $GLOBALS['con'];
    if($stmt = mysqli_prepare($con,$sql)){
         mysqli_stmt_bind_param($stmt,$datatypes,...$values);
         if(mysqli_stmt_execute($stmt)){
            $res = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            return $res;
         }else{
            mysqli_stmt_close($stmt);
            die("query can not be executed");
         }
    }else{
        die("query can not be prepared");
    }
}

function update($sql,$values,$datatypes){
    $con = $GLOBALS['con'];
    if($stmt = mysqli_prepare($con,$sql)){
         mysqli_stmt_bind_param($stmt,$datatypes,...$values);
         if(mysqli_stmt_execute($stmt)){
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
         }else{
            mysqli_stmt_close($stmt);
            die("query can not be updated");
         }
    }else{
        die("query can not be prepared");
    }
}


function insert($sql,$values,$datatypes){
    $con = $GLOBALS['con'];
    if($stmt = mysqli_prepare($con,$sql)){
         mysqli_stmt_bind_param($stmt,$datatypes,...$values);
         if(mysqli_stmt_execute($stmt)){
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
         }else{
            mysqli_stmt_close($stmt);
            die("query can not be insert");
         }
    }else{
        die("query can not be prepared");
    }
}
function delete($sql,$values,$datatypes){
    $con = $GLOBALS['con'];
    if($stmt = mysqli_prepare($con,$sql)){
         mysqli_stmt_bind_param($stmt,$datatypes,...$values);
         if(mysqli_stmt_execute($stmt)){
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
         }else{
            mysqli_stmt_close($stmt);
            die("query can not be deleted");
         }
    }else{
        die("query can not be prepared");
    }
}

function selectAll($table){
    $con = $GLOBALS['con'];
    $res = mysqli_query($con,"SELECT * FROM $table");
    return $res;
}
?>