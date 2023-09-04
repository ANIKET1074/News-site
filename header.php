<!-- <style>
    .login {
        border: 1px solid black;
        padding: 1rem 2rem;
        padding: 1rem 2rem;
        background-color: rgba(244, 116, 42, 0.834);
        color: black;
        border-radius: 1rem;
    }

    .login:hover {
        background-color: white;
        color: black;
    }
</style> -->

<?php
include 'config.php';
$url = basename($_SERVER['PHP_SELF']);
// echo $url;

switch ($url) {
    case 'single.php':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT * FROM post WHERE post_id = {$id}";
            $result = mysqli_query($conn, $sql) or die("Query Failed. ");
            $row = mysqli_fetch_assoc($result);

            $row_title = $row['title'] . ' News';
        } else {
            $row_title = "No Post Found";
        }
        break;
    case 'author.php':
        if (isset($_GET['aid'])) {
            $auth_id = $_GET['aid'];
            $sql = "SELECT * FROM user WHERE user_id = {$auth_id}";
            $result = mysqli_query($conn, $sql) or die("Query Failed. ");
            $row = mysqli_fetch_assoc($result);
            $row_title = 'News by ' . $row['first_name'] . ' ' . $row['last_name'];
        } else {
            $row_title = "";
        }
        break;
    case 'category.php':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT * FROM category WHERE category_id = {$id}";
            $result = mysqli_query($conn, $sql) or die("Query Failed. ");
            $row = mysqli_fetch_assoc($result);

            $row_title = $row['category_name'] . ' News';
        } else {
            $row_title = "No Post found";
        }
        break;
    case 'search.php':
        if (isset($_GET['search'])) {
            $row_title = $_GET['search'];
        } else {
            $row_title = "No Post Found";
        }

        break;
    default:
        $row_title = "News-Site";
        break;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $row_title ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class=" col-md-offset-4 col-md-4">
                    <?php
                    $sql = "SELECT * FROM `settings`";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row['website_logo'] == "") {
                                echo '<a href="index.php"><h1>' . $row['website_name'] . '</h1></a>';
                            } else {
                                echo '<a href="index.php"><img class="logo" src="admin/images/' . $row['website_logo'] . '"></a>';
                            }
                        }
                    }

                    ?>
                </div>
                <!-- /LOGO -->
                <!-- <div><a href="admin" class="login">Login</a></div> -->
            </div>
        </div>
    </div>
    <!-- /HEADER -->
    <!-- Menu Bar -->
    <div id="menu-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    include 'config.php';

                    if (isset($_GET['id'])) {
                        $cat_id = $_GET['id'];
                    }

                    $sql = "SELECT `category`  ,`category_id`, `category_name` ,COUNT(*) AS 'post_count'  
                     FROM `post`
                     LEFT JOIN category ON post.category = category.category_id  
                      GROUP by `category`   ORDER BY COUNT(*) DESC;";
                    $result = mysqli_query($conn, $sql) or die("Query Failed : Category");

                    if (mysqli_num_rows($result) > 0) {
                        $active = "";
                    ?>
                        <ul class='menu'>
                            <li><a href="<?php echo $hostname ?>">Home</a></li>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                if (isset($_GET['id'])) {
                                    if ($row['category_id'] == $cat_id) {
                                        $active = "active";
                                    } else {
                                        $active = "";
                                    }
                                }
                                echo  "<li><a class='{$active}' href='category.php?id={$row["category_id"]}'>" .
                                    $row['category_name'] . "</a></li>";
                            }
                            ?>
                        </ul>
                    <?php }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /Menu Bar -->