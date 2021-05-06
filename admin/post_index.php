<?php include "header.php"; ?>
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <h1 class="admin-heading">All Posts</h1>
                </div>
                <div class="col-md-2">
                    <a class="add-new" href="add_post.php">add post</a>
                </div>
                <div class="col-md-12">
                    <?php 
                        include 'config.php';

                        $limit = 3;
                        if(isset($_GET['page'])){
                            $page_number = $_GET['page'];
                        }
                        else{
                            $page_number = 1;
                        }
                        $offset = ($page_number - 1) * $limit;

                        if($_SESSION['user_role'] == '1'){
                            $query = "SELECT posts.post_id, posts.title, posts.post_date, posts.category, posts.post_img, categories.category_name, users.username FROM posts 
                                LEFT JOIN categories ON posts.category = categories.category_id
                                LEFT JOIN users ON posts.author = users.user_id
                                ORDER BY posts.post_id DESC LIMIT {$offset}, {$limit}";
                        }
                        elseif($_SESSION['user_role'] == '0'){
                            $query = "SELECT posts.post_id, posts.title, posts.post_date, posts.category, categories.category_name, users.username FROM posts 
                                LEFT JOIN categories ON posts.category = categories.category_id
                                LEFT JOIN users ON posts.author = users.user_id
                                WHERE posts.author = {$_SESSION['user_id']}
                                ORDER BY posts.post_id DESC LIMIT {$offset}, {$limit}";

                        }

                        $result = mysqli_query($connection, $query) or die("Query Failed");
                        $count = mysqli_num_rows($result);
                    ?>
                    <table class="content-table">
                        <thead>
                            <th>S.No.</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Author</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php 
                                $serial = 1;
                                if($count > 0){
                                while($row = mysqli_fetch_assoc($result)){
                            ?>
                            <tr>
                                <td class='id'><?php echo $serial++; ?></td>
                                <td><?php echo $row['title']; ?></td>
                                <td><img src="upload/<?php echo $row['post_img']; ?>" height="50" width="90"></td>
                                <td><?php echo $row['category_name']; ?></td>
                                <td><?php echo $row['post_date']; ?></td>
                                <td><?php echo $row['username']; ?></td>
                                <td class='edit'>
                                    <a href='update_post.php?id=<?php echo $row['post_id'] ?>'><i class='fa fa-edit'></i></a>
                                    <a onclick="return confirm('Are you sure to delete?')" 
                                        href='delete_post.php?id=<?php echo $row['post_id'] ?>&cat_id=<?php echo $row['category'] ?>'>
                                        <i class='fa fa-trash-o'></i>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        <?php } ?>
                    </table>
                    <?php
                        include "config.php";
                        $query1 = "SELECT * FROM posts";
                        $result1 = mysqli_query($connection, $query1) or die('Query Failed');
                        if(mysqli_num_rows($result1)){
                            $total_post = mysqli_num_rows($result1);
                            $total_page = ceil($total_post/$limit);

                            echo "<ul class='pagination admin-pagination'>";
                                if($page_number > 1){
                                    echo '<li><a href="post_index.php?page='.($page_number - 1).'">prev</a></li>';
                                }
                                for($i=1; $i<=$total_page; $i++){
                                    if($i == $page_number){
                                        $active = "active";
                                    }
                                    else{
                                        $active = "";
                                    }
                                    echo '<li class='.$active.'><a href="post_index.php?page='.$i.'">'.$i.'</a></li>';
                                }
                                if($total_page > $page_number){
                                    echo '<li><a href="post_index.php?page='.($page_number + 1).'">next</a></li>';
                                }
                            echo "</ul>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php include "footer.php"; ?>
