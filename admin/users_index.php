<?php include 'header.php'; 

    if($_SESSION['user_role'] == '0'){
        header('location: post_index.php');
    }

?>
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <h1 class="admin-heading">All Users</h1>
                </div>
                <div class="col-md-2">
                    <a class="add-new" href="add_user.php">add user</a>
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

                        $query = "SELECT * FROM users ORDER BY user_id DESC LIMIT {$offset}, {$limit}";
                        $result = mysqli_query($connection, $query) or die("Query Failed");
                        $count = mysqli_num_rows($result);
                    ?>
                    <table class="content-table">
                        <thead>
                            <th>S.No.</th>
                            <th>Full Name</th>
                            <th>User Name</th>
                            <th>Role</th>
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
                                    <td><?php echo $row['first_name']." ".$row['last_name']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    <td>
                                        <?php 
                                            if($row['role'] == 0){
                                                echo "Moderator";
                                            }
                                            else{
                                                echo "Admin";
                                            }
                                        ?>
                                    </td>
                                    <td class='edit'>
                                        <a href="update_user.php?id=<?php echo $row['user_id']?>"><i class='fa fa-edit'></i></a>
                                        <a href="delete_user.php?id=<?php echo $row['user_id']?>" onclick="return confirm('Are you sure to delete?')"><i class='fa fa-trash-o'></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    <?php } ?>
                    </table>
                    <?php
                        include "config.php";
                        $query1 = "SELECT * FROM users";
                        $result1 = mysqli_query($connection, $query1) or die('Query Failed');
                        if(mysqli_num_rows($result1)){
                            $total_users = mysqli_num_rows($result1);
                            $total_page = ceil($total_users/$limit);

                            echo "<ul class='pagination admin-pagination'>";
                            if($page_number > 1){
                                echo '<li><a href="users_index.php?page='.($page_number - 1).'">prev</a></li>';
                            }
                            for($i=1; $i<=$total_page; $i++){
                                if($i == $page_number){
                                    $active = "active";
                                }
                                else{
                                    $active = "";
                                }
                                echo '<li class='.$active.'><a href="users_index.php?page='.$i.'">'.$i.'</a></li>';
                            }
                            if($total_page > $page_number){
                                echo '<li><a href="users_index.php?page='.($page_number + 1).'">next</a></li>';
                            }
                            echo "</ul>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>

