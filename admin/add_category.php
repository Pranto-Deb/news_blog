<?php include "header.php"; 

    if($_SESSION['user_role'] == '0'){
        header('location: post_index.php');
    }
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Add New Category</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <?php
                    if(isset($_POST['submit'])){
                        include 'config.php';

                        $category_name = mysqli_real_escape_string($connection, $_POST['category_name']);

                        $query = "SELECT category_name FROM categories WHERE category_name = '$category_name'";
                        $result = mysqli_query($connection, $query) or die("Query Failed");
                        $count = mysqli_num_rows($result);
                        if($count > 0){
                            echo "<h5>Category already exists</h5>";
                        }
                        else{
                            $query1 = "INSERT INTO categories (category_name)
                                VALUES ('$category_name')";
                            $result = mysqli_query($connection, $query1) or die("Query Failed");
                            if($result){
                                header('location: category_index.php');
                            }
                            else{
                                echo "Error! Category not added";
                            }
                        }
                    }
                ?>

                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" name="category_name" class="form-control" placeholder="Category Name" required>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="Save" required />
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
