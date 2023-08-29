<?php
include 'config.php';

if (empty($_FILES['new-image']['name'])) {
    $file_name = $_POST['old-image'];
} else {
    $errors = array();
    $file_name = $_FILES['new-image']['name'];
    $file_size = $_FILES['new-image']['size'];
    $file_tmp = $_FILES['new-image']['tmp_name'];
    $file_type = $_FILES['new-image']['type'];
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

$sql = "UPDATE post SET title='{$_POST["post_title"]}',description='{$_POST["postdesc"]}',category={$_POST["category"]},post_img='$d_name' WHERE post_id={$_POST["post_id"]}";

$result = mysqli_query($conn, $sql);
if ($result) {
    header("Location: {$hostname}/admin/post.php");
} else {
    echo "Query failed";
}
