<?php
include('../header.php'); 
session_start();
include('../inc/connect.php');
$userID= $_COOKIE['userID'] ;
$bestParticipant= $_POST['bestParticipant'];
$competition_id1 = $_COOKIE['titleID'];

try{
    //-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    $stmt = $conn->prepare("SELECT bestParticipant FROM `competition` WHERE judge_id='$userID' and competition_id='$competition_id1' and side=0");
    // use exec() because no results are returned
    $products = array();
    if($stmt->execute()){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $participant[] = $row;
        }
        var_dump($participant);
        if($participant[0]['bestParticipant']!="0")
        {header('Location:../bestParticipantAlgo.php');}
        else{
            try {
    
                $sql = "UPDATE  competition  SET bestParticipant='$bestParticipant'
                 WHERE judge_id='$userID'  AND competition_id='$competition_id1'";
                // use exec() because no results are returned
                $conn->exec($sql);
                header('Location:../bestParticipantAlgo.php');
                }
            catch(PDOException $e)
                {
                echo $sql . "<br>" . $e->getMessage();
                }
        }
       
    }
   catch(PDOException $e)
   {echo $stmt . "<br>" . $e->getMessage();
}


?>