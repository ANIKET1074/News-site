<?php include 'header.php'; ?>
<div id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                    <?php

                    // $sql1 = "SELECT * ,COUNT(*) AS 'post_count'  
                    // FROM `post`
                    // LEFT JOIN category ON post.category = category.category_id  
                    // WHERE category_id = {$cat_id}
                    //  GROUP by `category`   ORDER BY COUNT(*) DESC";
                    ?>
                    <?php
                    include 'config.php';
                    if (array_key_exists('id', $_GET)) {
                        $cat_id = $_GET['id'];
                    }
                    $sql1 = "SELECT * FROM category where category_id = $cat_id";
                    $result1 = mysqli_query($conn, $sql1) or die("Query failed..");
                    while ($row1 = mysqli_fetch_assoc($result1)) {
                        echo '<h2 class="page-heading"> ' . $row1['category_name'] . '</h2>';
                    };
                    // if (isset($_GET['id'])) {
                    //     $cat_id = $_GET['id'];
                    // }
                    $limit = 3;
                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];
                    } else {
                        $page = 1;
                    }


                    $offset = ($page - 1) * $limit;
                    $sql = "SELECT * FROM `post` 
                        LEFT JOIN category ON post.category = category.category_id  
                        LEFT JOIN user ON post.author = user.user_id
                        WHERE category = $cat_id
                        ORDER BY `post_id` DESC LIMIT $offset,$limit";
                    $result = mysqli_query($conn, $sql) or die("Query failed ");




                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {

                    ?>
                            <div class="post-content">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a class="post-img" href="single.php?id=<?php echo $row['post_id'] ?>"><img src="admin/upload/<?php echo $row['post_img'] ?>" alt="" /></a>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="inner-content clearfix">
                                            <h3><a href='single.php?id=<?php echo $row['post_id'] ?>'><?php echo $row['title'] ?></a>
                                            </h3>
                                            <div class="post-information">
                                                <span>
                                                    <i class="fa fa-tags" aria-hidden="true"></i>
                                                    <a href='category.php?id=<?php echo $row['category'] ?>'><?php echo $row['category_name'] ?></a>
                                                </span>
                                                <span>
                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                    <a href='author.php?aid=<?php echo $row['author'] ?>'><?php echo $row['username'] ?></a>
                                                </span>
                                                <span>
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    <?php echo $row['post_date'] ?>
                                                </span>
                                            </div>
                                            <p class="description">
                                                <?php echo substr($row['description'], 0, 130) . "..." ?>
                                            </p>
                                            <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id'] ?>'>read
                                                more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <ul class='pagination'>
                        <li class="active"><a href="">1</a></li>
                        <li><a href="">2</a></li>
                        <li><a href="">3</a></li>
                    </ul> -->
                    <?php
                        }
                    } else {
                        echo "<h2>No record Found</h2>";
                    }
                    ?>
                    <?php

                    $sql1 = "SELECT * FROM post WHERE category=$cat_id";
                    $result1 = mysqli_query($conn, $sql1);
                    if (mysqli_num_rows($result1) > 0) {
                        $total_records = mysqli_num_rows($result1);

                        $total_page = ceil($total_records / $limit);

                        echo '<ul class="pagination admin-pagination">';

                        if ($page > 1) {
                            echo '<li><a href="category.php?id=' . $cat_id . '&page=' . ($page - 1) . '">Pre</a></li>';
                        }
                        for ($i = 1; $i <= $total_page; $i++) {
                            if ($i == $page) {
                                $active = 'active';
                            } else {
                                $active = "";
                            }
                            echo '<li class="' . $active . '"><a href="category.php?id=' . $cat_id . '&page=' . $i . '">' . $i . '</a></li>';
                        }
                        if ($page < $total_page) {
                            echo '<li><a href="category.php?id=' . $cat_id . '&page=' . ($page + 1) . '">Next</a></li>';
                        }
                        echo "</ul>";
                    } ?>
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>