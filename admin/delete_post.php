<?php

    session_start();
    if($_SESSION['user_role'] == '0'){
        header('location: post_index.php');
    }
    
    if(isset($_GET['id'])){
        include "config.php";

        $rcv_id = $_GET['id'];
        $cat_id = $_GET['cat_id'];

        $query1 = "SELECT * FROM posts WHERE post_id = '{$rcv_id}'";
        $result1 = mysqli_query($connection, $query1) or die("Query Failed");
        $row = mysqli_fetch_assoc($result1);


        $query = "DELETE FROM posts WHERE post_id = '{$rcv_id}';";
        $query .= "UPDATE categories SET post = post - 1 WHERE category_id = '{$cat_id}'";

        $result = mysqli_multi_query($connection, $query) or die("Query Failed");

        if($result){
            unlink("upload/".$row['post_img']);
            header("location: post_index.php");
        }
        else{
            echo "Category delete failed";
        }

        mysql_close($connection);
    }

?>