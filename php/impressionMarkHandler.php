<?php 
 include('../header.php'); 
 session_start();
include('../inc/connect.php');

if(!isset($side)){header("Location:/mark2.php");}

$side= $_REQUEST["side"];
$userID= $_SESSION['userID'] ;
$competition_id1 = $_SESSION['titleID'];

try {
    
    $sql = "UPDATE competition SET impression_ticket=1 WHERE judge_id=$userID AND side=$side AND competition_id='$competition_id1'";
    // use exec() because no results are returned
    $conn->exec($sql);
     header("Location:/voting.php");
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }


?>