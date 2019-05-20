<?php
include('../header.php'); 
session_start();
include('../inc/connect.php');
$userID= $_SESSION['userID'] ;
$participant1= $_POST['participant1'];
$participant2=  $_POST['participant2'];
$participant3=  $_POST['participant3'];
$competition_id1 = $_SESSION['titleID'];

try {
    
    $sql = "UPDATE  Competition  SET bestParticipant1='$participant1',bestParticipant2='$participant2',bestParticipant3='$participant3'
     WHERE judge_id='$userID'  AND competition_id='$competition_id1'";
    // use exec() because no results are returned
    $conn->exec($sql);
     header('Location:/mark3.php');
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

?>