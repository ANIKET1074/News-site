<?php
include 'config.php';
$id = $_GET['id'];

// $cat_id = 

$sql1 = "SELECT * FROM post WHERE post_id = '$id'";
$result1 = mysqli_query($conn, $sql1);

$row = mysqli_fetch_assoc($result1);

//here unlink we use for deleting the image from the folder
unlink("upload/" . $row['post_img']);

$sql = "DELETE FROM post WHERE post_id = '$id'";
$result = mysqli_query($conn, $sql);
if ($result) {
    header("Location: $hostname/admin/post.php");
} else {
    echo "Query failed";
}
