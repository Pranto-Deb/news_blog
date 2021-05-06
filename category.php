<?php include 'header.php'; ?>
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- post-container -->
                    <div class="post-container">
                        <?php 
                            include 'admin/config.php';
                            if(isset($_GET['cat_id'])){
                                $cat_id = $_GET['cat_id'];


                            $query2   = "SELECT * FROM categories WHERE category_id = '{$cat_id}'";
                            $result2  = mysqli_query($connection, $query2) or die("Query Failed");

                            $row2 = mysqli_fetch_assoc($result2);
                        ?>

                            <h2 class="page-heading"><?php echo strtoupper($row2['category_name']); ?></h2>


                        <?php
                            
                            $limit = 3;
                            if(isset($_GET['page'])){
                                $page_number = $_GET['page'];
                            }
                            else{
                                $page_number = 1;
                            }
                            $offset = ($page_number - 1) * $limit;

                            $query = "SELECT posts.post_id, posts.title, posts.post_date, posts.category, posts.description, posts.post_img, categories.category_name, categories.category_id, users.username FROM posts 
                                LEFT JOIN categories ON posts.category = categories.category_id
                                LEFT JOIN users ON posts.author = users.user_id
                                WHERE posts.category = '{$cat_id}'
                                ORDER BY posts.post_id DESC LIMIT {$offset}, {$limit}";

                            $result = mysqli_query($connection, $query) or die("Query Failed");
                            $count = mysqli_num_rows($result);

                            if($count > 0){
                                while($row = mysqli_fetch_assoc($result)){
                        
                        ?>
                        <div class="post-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <a class="post-img" href="single.php?id=<?php echo $row['post_id']; ?>"><img src="admin/upload/<?php echo $row['post_img']; ?>" height="100%" alt=""/></a>
                                </div>
                                <div class="col-md-8">
                                    <div class="inner-content clearfix">
                                        <h3><a href="single.php?id=<?php echo $row['post_id']; ?>"><?php echo $row['title']; ?></a></h3>
                                        <div class="post-information">
                                            <span>
                                                <i class="fa fa-tags" aria-hidden="true"></i>
                                                <a href="category.php?cat_id=<?php echo $row['category']; ?>"><?php echo $row['category_name']; ?></a>
                                            </span>
                                            <span>
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                <a href='author.php'><?php echo $row['username']; ?></a>
                                            </span>
                                            <span>
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                <?php echo $row['post_date']; ?>
                                            </span>
                                        </div>
                                        <p class="description">
                                            <?php echo substr($row['description'], 0, 249)."....."; ?>
                                        </p>
                                        <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id']; ?>'>read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                                }
                            }else{
                                echo "No record found";
                            }
                            
                            $query1 = "SELECT * FROM posts WHERE posts.category = '{$cat_id}'";
                            $result1 = mysqli_query($connection, $query1) or die('Query Failed');
                            if(mysqli_num_rows($result1)){
                                $total_post = mysqli_num_rows($result1);
                                $total_page = ceil($total_post/$limit);

                                echo "<ul class='pagination admin-pagination'>";
                                    if($page_number > 1){
                                        echo '<li><a href="category.php?cat_id='.$cat_id.'&page='.($page_number - 1).'">prev</a></li>';
                                    }
                                    for($i=1; $i<=$total_page; $i++){
                                        if($i == $page_number){
                                            $active = "active";
                                        }
                                        else{
                                            $active = "";
                                        }
                                        echo '<li class='.$active.'><a href="category.php?cat_id='.$cat_id.'&page='.$i.'">'.$i.'</a></li>';
                                    }
                                    if($total_page > $page_number){
                                        echo '<li><a href="category.php?cat_id='.$cat_id.'&page='.($page_number + 1).'">next</a></li>';
                                    }
                                echo "</ul>";
                            }
                        }
                        
                        ?>
                        
                    </div><!-- /post-container -->
                </div>
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>
