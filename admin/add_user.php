<?php include "header.php"; 

    if($_SESSION['user_role'] == '0'){
        header('location: post_index.php');
    }
?>
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="admin-heading">Add User</h1>
                </div>
                <div class="col-md-offset-3 col-md-6">
                
                    <?php
                        if(isset($_POST['submit'])){
                            include 'config.php';

                            $first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
                            $last_name  = mysqli_real_escape_string($connection, $_POST['last_name']);
                            $username   = mysqli_real_escape_string($connection, $_POST['username']);
                            $password   = mysqli_real_escape_string($connection, md5($_POST['password']));
                            $role       = mysqli_real_escape_string($connection, $_POST['role']);

                            $query = "SELECT username FROM users WHERE username = '$username'";
                            $result = mysqli_query($connection, $query) or die("Query Failed");
                            $count = mysqli_num_rows($result);
                            if($count > 0){
                                echo "Users already exists";
                            }
                            else{
                                $query1 = "INSERT INTO users (first_name,last_name,username,password,role)
                                    VALUES ('$first_name','$last_name','$username','$password','$role')";
                                $result = mysqli_query($connection, $query1) or die("Query Failed");
                                if($result){
                                    header('location: users_index.php');
                                }
                                else{
                                    echo "Error! Users not added";
                                }
                            }
                        }
                    ?>

                    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
                        </div>
                            <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
                        </div>
                        <div class="form-group">
                            <label>User Name</label>
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <label>User Role</label>
                            <select class="form-control" name="role" >
                                <option value="0">Moderator</option>
                                <option value="1">Admin</option>
                            </select>
                        </div>
                        <input type="submit"  name="submit" class="btn btn-primary" value="Save" required />
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include "footer.php"; ?>
