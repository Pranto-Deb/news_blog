<?php include 'header.php'; ?>
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <?php 
                        include 'admin/config.php';

                        $post_id = $_GET['id'];
                        $query = "SELECT posts.post_id, posts.title, posts.post_date, posts.category, posts.description, posts.post_img, posts.author, categories.category_name, users.username FROM posts 
                            LEFT JOIN categories ON posts.category = categories.category_id
                            LEFT JOIN users ON posts.author = users.user_id
                            WHERE posts.post_id = '{$post_id}'";

                        $result = mysqli_query($connection, $query) or die("Query Failed");
                        $count = mysqli_num_rows($result);

                        if($count > 0){
                            while($row = mysqli_fetch_assoc($result)){
                    ?>
                  <!-- post-container -->
                    <div class="post-container">
                        <div class="post-content single-post">
                            <h3><?php echo $row['title']; ?></h3>
                            <div class="post-information">
                                <span>
                                    <i class="fa fa-tags" aria-hidden="true"></i>
                                    <a href="category.php?cat_id=<?php echo $row['category']; ?>"><?php echo $row['category_name']; ?></a>
                                </span>
                                <span>
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <a href="author.php?auth_id=<?php echo $row['author']; ?>"><?php echo $row['username']; ?></a>
                                </span>
                                <span>
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                    <?php echo $row['post_date']; ?>
                                </span>
                            </div>
                            <img class="single-feature-image" src="admin/upload/<?php echo $row['post_img']; ?>" alt=""/>
                            <p class="description">
                                <?php echo $row['description']; ?>
                            </p>
                        </div>
                    </div>
                    <!-- /post-container -->
                    <?php 
                            }
                        }else{
                            echo "No record found";
                        }
                    ?>
                </div>
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>
