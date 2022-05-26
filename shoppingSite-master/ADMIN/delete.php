<?php
    include "db.php";
    if(isset($_GET['id'])){
        $user_id=$_GET['id'];
        $sql="DELETE FROM user_list WHERE 'id'='$user_id'";
        $result=$conn->query($sql);
        if($result==TRUE){
            echo "Record deleted successfully";
            header("location:login.php");
        }
        else{
            echo "Error:".$sql."<br>".$conn->error;
        }
        header("Refresh:0");
    }
?>
