<?php
include 'config.php';

if (empty($_FILES['logo']['name'])) {
    $file_name = $_POST['old_logo'];
} else {
    $errors = array();
    $file_name = $_FILES['logo']['name'];
    $file_size = $_FILES['logo']['size'];
    $file_tmp = $_FILES['logo']['tmp_name'];
    $file_type = $_FILES['logo']['type'];
    $file_ext = end(explode('.', $file_name));
    $extensions = array("jpeg", "jpg", "png");

    if (in_array($file_ext, $extensions) === false) {
        $errors[] = "This extension file is not valid";
    }
    if ($file_size > 2097152) {
        $errors[] = "File size must be less than 2mb";
    }
    if (empty($errors) == true) {
        move_uploaded_file($file_tmp, "images/" . $file_name);
    } else {
        print_r($errors);
        die("Error..");
    }
}

$sql = "UPDATE settings SET website_name='{$_POST["website_name"]}',website_logo='{$file_name}',footer_desc='{$_POST["footer_desc"]}'";

$result = mysqli_query($conn, $sql);
if ($result) {
    header("Location: {$hostname}/admin/settings.php");
} else {
    echo "Query failed";
}
