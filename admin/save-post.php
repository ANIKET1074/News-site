<?php
include 'config.php';

if (isset($_FILES['fileToUpload'])) {
    $errors = array();
    $file_name = $_FILES['fileToUpload']['name'];
    $file_size = $_FILES['fileToUpload']['size'];
    $file_tmp = $_FILES['fileToUpload']['tmp_name'];
    $file_type = $_FILES['fileToUpload']['type'];
    $file_ext = end(explode('.', $file_name));
    $extensions = array("jpeg", "jpg", "png");

    if (in_array($file_ext, $extensions) === false) {
        $errors[] = "This extension file is not valid";
    }
    if ($file_size > 2097152) {
        $errors[] = "File size must be less than 2mb";
    }
    $new_name = time() . "-" . basename($file_name);
    $target =  "upload/" . $new_name;
    $d_name = $new_name;

    if (empty($errors) == true) {
        move_uploaded_file($file_tmp, $target);
    } else {
        print_r($errors);
        die("Error..");
    }
}
session_start();
$title = mysqli_real_escape_string($conn, $_POST['post_title']);
$desc = mysqli_real_escape_string($conn, $_POST['postdesc']);
$category = mysqli_real_escape_string($conn, $_POST['category']);
$dt = date("d M, Y");
$author = $_SESSION['user_id'];

$sql = "INSERT INTO `post` (`title`,`description`,`category`,`post_date`,`author`,`post_img`) VALUES('$title','$desc','$category','$dt','$author','$d_name');";

//concatinating the two sql commands
// $sql .= "UPDATE CATEOGRY SET post = post +1 WHERE `category_id` = '$category'";

//for running the multiple query 
if (mysqli_multi_query($conn, $sql)) {
    header("Location: {$hostname}/admin/post.php");
}
