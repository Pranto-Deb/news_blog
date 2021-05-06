<?php
    include 'config.php';
    if(isset($_POST['submit'])){

        if(!empty($_FILES['fileToUpload'])){
            $errors = array();

            $file_name = $_FILES['fileToUpload']['name'];
            $file_size = $_FILES['fileToUpload']['size'];
            $file_tmp  = $_FILES['fileToUpload']['tmp_name'];
            $file_type = $_FILES['fileToUpload']['type'];
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

        session_start();
        $title = mysqli_real_escape_string($connection, $_POST['title']);
        $description = mysqli_real_escape_string($connection, $_POST['description']);
        $category = mysqli_real_escape_string($connection, $_POST['category']);
        $date = date("d M, Y");
        $author = $_SESSION['user_id'];

        $query = "INSERT INTO posts (title, description, category, post_date, author, post_img)
            VALUES ('$title','$description','$category','$date','$author','$new_name');";
        
        $query .= "UPDATE categories SET post = post + 1 WHERE category_id = '{$category}';";
        $result = mysqli_multi_query($connection, $query) or die("Query Failed");
        if($result){
            header('location: post_index.php');
        }
        else{
            echo "<h5>Post add failed.</h5>";
        }
    
    }
?>