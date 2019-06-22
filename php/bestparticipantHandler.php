<?php
include('../header.php'); 
session_start();
include('../inc/connect.php');
$userID= $_SESSION['userID'] ;
$participant1= $_POST['participant1'];
$participant2=  $_POST['participant2'];
$participant3=  $_POST['participant3'];
$competition_id1 = $_SESSION['titleID'];
try{
 //-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 $stmt = $conn->prepare("SELECT bestParticipant1,bestParticipant2,bestParticipant3 FROM `competition` WHERE judge_id='$userID' and competition_id='$competition_id1' and side=0");
 // use exec() because no results are returned
 $products = array();
 if($stmt->execute()){
     $row = $stmt->fetch(PDO::FETCH_ASSOC);
     $participant[] = $row;
     }
     var_dump($participant);
     if($participant[0]['bestParticipant1']!="0" ||$participant[0]['bestParticipant1']!="0" || $participant[0]['bestParticipant1']!="0")
     { header('Location:../mark3.php');}
    
 }
catch(PDOException $e)
 {
 echo $stmt . "<br>" . $e->getMessage();
 }

try {
    
    $sql = "UPDATE  competition  SET bestParticipant1='$participant1',bestParticipant2='$participant2',bestParticipant3='$participant3'
     WHERE judge_id='$userID'  AND competition_id='$competition_id1'";
    // use exec() because no results are returned
    $conn->exec($sql);
     header('Location:../mark3.php');
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

?>