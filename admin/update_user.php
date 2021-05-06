<?php include "header.php"; 
        if($_SESSION['user_role'] == '0'){
            header('location: post_index.php');
        }

        if(isset($_POST['submit'])){
            include 'config.php';

            $user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
            $first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
            $last_name  = mysqli_real_escape_string($connection, $_POST['last_name']);
            $username   = mysqli_real_escape_string($connection, $_POST['username']);
            $role       = mysqli_real_escape_string($connection, $_POST['role']);

            $query1 = "UPDATE users SET
                        first_name = '{$first_name}',
                        last_name  = '{$last_name}',
                        username   = '{$username}',
                        role       = '{$role}'
                        WHERE user_id = '{$user_id}'";
            $result1 = mysqli_query($connection, $query1) or die("Query Failed");
            if($result1){
                header('location: users_index.php');
            }
            else{
                echo "User update failed";
            }
            
        }
?>
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="admin-heading">Update User</h1>
                </div>
                <div class="col-md-offset-4 col-md-4">
                    <?php
                        if(isset($_GET['id'])){
                            include "config.php";
                            $user_id = $_GET['id'];
                            $query = "SELECT * FROM users WHERE user_id = '$user_id'";
                            $result = mysqli_query($connection, $query) or die("Query Failed");
                            $count = mysqli_num_rows($result);

                            if($count > 0){
                                while($row = mysqli_fetch_assoc($result)){
                    ?>    
                    <form  action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST">
                        <div class="form-group">
                            <input type="hidden" name="user_id"  class="form-control" value="<?php $row['user_id'];?>" placeholder="" >
                        </div>
                            <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="first_name" class="form-control" value="<?php echo $row['first_name'];?>" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="<?php echo $row['last_name'];?>" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label>User Name</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $row['username'];?>" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label>User Role</label>
                            <select class="form-control" name="role">
                                <option value="0"<?php echo $row['role'] == 0 ? 'selected' : ''; ?>>Moderator</option>
                                <option value="1"<?php echo $row['role'] == 1 ? 'selected' : ''; ?>>Admin</option>
                            </select>
                        </div>
                        <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                    </form>
                    <?php 
                        } 
                      }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php include "footer.php"; ?>
