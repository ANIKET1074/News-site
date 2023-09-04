<?php include 'header.php'; ?>
<div id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">

                    <?php
                    include 'config.php';
                    if (array_key_exists('search', $_GET)) {
                        $search_id = mysqli_real_escape_string($conn, $_GET['search']);
                    }

                    // echo '<h2 class="page-heading">' . $row1['first_name'] . ' ' . $row1['last_name'] . '</h2>';
                    echo '<h2 class="page-heading">Search : ' . $search_id . '</h2>';

                    // if (isset($_GET['id'])) {
                    //     $search_id = $_GET['id'];
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
                             WHERE post.title LIKE '%{$search_id}%' OR post.description LIKE '%{$search_id}%'
                             ORDER BY `post_id` LIMIT $offset,$limit";
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
                                                    <a href='author.php?search=<?php echo $row['author'] ?>'><?php echo $row['username'] ?></a>
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
                    <?php
                        }
                    } else {
                        echo "<h2>No record Found</h2>";
                    }
                    ?>
                    <?php

                    $sql1 = "SELECT * FROM post where post.title LIKE '%{$search_id}%'";
                    $result1 = mysqli_query($conn, $sql1) or die("Query failed..");
                    $row1 = mysqli_fetch_assoc($result1);
                    if (mysqli_num_rows($result1) > 0) {
                        $total_records = mysqli_num_rows($result1);

                        $total_page = ceil($total_records / $limit);

                        echo '<ul class="pagination admin-pagination">';

                        if ($page > 1) {
                            echo '<li><a href="category.php?search=' . $search_id . '&page=' . ($page - 1) . '">Pre</a></li>';
                        }
                        for ($i = 1; $i <= $total_page; $i++) {
                            if ($i == $page) {
                                $active = 'active';
                            } else {
                                $active = "";
                            }
                            echo '<li class="' . $active . '"><a href="category.php?search=' . $search_id . '&page=' . $i . '">' . $i . '</a></li>';
                        }
                        if ($page < $total_page) {
                            echo '<li><a href="category.php?search=' . $search_id . '&page=' . ($page + 1) . '">Next</a></li>';
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