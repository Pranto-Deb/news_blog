<?php

    session_start();
    if($_SESSION['user_role'] == '0'){
        header('location: post_index.php');
    }
    
    if(isset($_GET['id'])){
        include "config.php";

        $rcv_id = $_GET['id'];
        $query = "DELETE FROM categories WHERE category_id = '$rcv_id'";
        $result = mysqli_query($connection, $query) or die("Query Failed");

        if($result){
            header("location: category_index.php");
        }
        else{
            echo "Category delete failed";
        }

        mysql_close($connection);
    }

?>