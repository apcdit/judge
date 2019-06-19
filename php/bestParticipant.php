<?php
include('../header.php'); 
session_start();
include('../inc/connect.php');
$userID= $_SESSION['userID'] ;
$bestParticipant= $_POST['bestParticipant'];

$competition_id1 = $_SESSION['titleID'];

try {
    
    $sql = "UPDATE  competition  SET bestParticipant='$bestParticipant'
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