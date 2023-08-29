<?php

use PSpell\Config;

include "header.php"; ?>
<?php if ($_SESSION['role'] == '0') {
    header("Location: $hostname/admin/post.php");
}
if (isset($_POST['submit'])) {
    include 'config.php';
    $cat_id = $_POST['cat_id'];
    $category_name = mysqli_real_escape_string($conn, $_POST['cat_name']);
    // print($cat_id);
    // $sql = "UPDATE `category` SET `category_name` = '$category_name' WHERE `category_id` = {$cat_id}";
    $sql = "UPDATE `category` SET `category_name` = '$category_name' WHERE `category`.`category_id` = $cat_id;
    ";
    // $sql = "UPDATE `category` SET category_name = {$category_name} WHERE category_id=`$cat_id`" or die("Query failed.. ");
    $result = mysqli_query($conn, $sql)  or die('Query Failed. ');
    if (mysqli_query($conn, $sql)) {
        header("Location: {$hostname}/admin/category.php");
    }
}
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="adin-heading"> Update Category</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <?php
                // include 'config.php';
                $id = $_GET['id'];
                $sql1 = "SELECT * FROM `category` WHERE `category_id`='$id'";

                $result1 = mysqli_query($conn, $sql1) or die("Query failed..");
                if (mysqli_num_rows($result1) > 0) {
                    while ($row = mysqli_fetch_assoc($result1)) {
                ?>
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                            <div class="form-group">
                                <input type="hidden" name="cat_id" class="form-control" value="<?php echo $row['category_id']; ?>" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Category Name</label>
                                <input type="text" name="cat_name" class="form-control" value="<?php echo $row['category_name'] ?>" placeholder="" required>
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                        </form>

                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>