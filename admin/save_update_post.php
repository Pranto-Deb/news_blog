<?php
    include 'config.php';
    if(isset($_POST['submit'])){

        if(empty($_FILES['new_image']['name'])){
            $new_name = $_POST['old_image'];
        }else{
            $errors = array();

            $file_name = $_FILES['new_image']['name'];
            $file_size = $_FILES['new_image']['size'];
            $file_tmp  = $_FILES['new_image']['tmp_name'];
            $file_type = $_FILES['new_image']['type'];
            $file_ext  = explode('.', $file_name);
            $file_ext  = end($file_ext);

            $extensions = array("jpeg","jpg","png");

            if(in_array($file_ext, $extensions) === False){
                echo $errors[] = "This extension file not allowed.Please choose a JPEG, JPG or PNG file.";
            }
            if($file_size > 2097152){
                echo $errors[] = "File size must be 2mb or lower.";
            }

            $new_name = time()."-".basename($file_name);
            $location = "upload/".$new_name;

            if(empty($errors) == true){
                move_uploaded_file($file_tmp, $location);
            }
            else{
                print_r($errors);
                die();
            }
        }

        $query = "UPDATE posts SET
                title = '{$_POST['title']}',
                description = '{$_POST['description']}',
                category    = '{$_POST['category']}',
                post_img    = '{$new_name}' WHERE 
                post_id     = '{$_POST['post_id']}';";

            if($_POST['old_category'] != $_POST['category']){
                $query .= "UPDATE categories SET post = post - 1 WHERE category_id = '{$_POST['old_category']}';";
                $query .= "UPDATE categories SET post = post + 1 WHERE category_id = '{$_POST['category']}';";                
            }

            $result = mysqli_multi_query($connection, $query) or die("Query Failed");
            if($result){
                header('location: post_index.php');
            }
            else{
                echo "User update failed";
            }
    
    }
?>