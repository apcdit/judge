<?php
include('../header.php'); 
session_start([
    'cookie_lifetime' => 7200,
]);
include('../inc/connect.php');
$userID= $_SESSION['userID'] ;
$competition_id1 = $_SESSION['titleID'];



try {
    
    $sql = "DELETE FROM competition 
     WHERE judge_id='$userID'  AND competition_id='$competition_id1'";
    // use exec() because no results are returned
    $conn->exec($sql);
    header('Location:../votingResult.php');
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

?>