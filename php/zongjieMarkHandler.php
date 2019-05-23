<?php 
 include('../header.php'); 
 session_start();
include('../inc/connect.php');


$side= $_REQUEST["side"];
$userID= $_SESSION['userID'] ;
$competition_id1 = $_SESSION['titleID'];

try {
    
    $sql = "UPDATE competition SET zongjie_ticket=1 WHERE judge_id=$userID AND side=$side AND competition_id='$competition_id1'";
    // use exec() because no results are returned
    $conn->exec($sql);
    //  echo "New record created successfully";
    header('Location:../votingResult.php');
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }


?>