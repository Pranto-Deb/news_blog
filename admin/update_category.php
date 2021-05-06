<?php include "header.php"; 
    if($_SESSION['user_role'] == '0'){
        header('location: post_index.php');
    }

    if(isset($_POST['submit'])){
        include 'config.php';

        $category_id = mysqli_real_escape_string($connection, $_POST['category_id']);
        $category_name = mysqli_real_escape_string($connection, $_POST['category_name']);

        $query1 = "UPDATE categories SET
                    category_name = '{$category_name}' WHERE category_id = '{$category_id}'";
        $result1 = mysqli_query($connection, $query1) or die("Query Failed");
        if($result1){
            header('location: category_index.php');
        }
        else{
            echo "Category update failed";
        }
        
    }
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="adin-heading">Update Category</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <?php
                    if(isset($_GET['id'])){
                        include "config.php";

                        $category_id = $_REQUEST['id'];
                        $query = "SELECT * FROM categories WHERE category_id = '$category_id'";
                        $result = mysqli_query($connection, $query) or die("Query Failed");
                        $count = mysqli_num_rows($result);

                        if($count > 0){
                            while($row = mysqli_fetch_assoc($result)){
                ?>    
                <form action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST">
                    <div class="form-group">
                        <input type="hidden" name="category_id"  class="form-control" value="<?php echo $row['category_id'];?>" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" name="category_name" class="form-control" value="<?php echo $row['category_name'];?>"  placeholder="" required>
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
