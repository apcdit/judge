<?php 
 include('../header.php'); 
 session_start();
include('../inc/connect.php');



$side= $_REQUEST["side"];
// if(!isset($side)){header("Location:../mark2.php");}
$userID= $_COOKIE['userID'] ;
$competition_id1 = $_COOKIE['titleID'];
//crosscheck data existed in database--------------------------------------------------------
try{
    //-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    $stmt = $conn->prepare("SELECT impression_ticket FROM `competition` WHERE judge_id='$userID' and competition_id='$competition_id1'");
    // use exec() because no results are returned
    $result=[];
    if($stmt->execute()){
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
       array_push($result,$row["impression_ticket"]);
       
        }}
        var_dump($result);
       if(($result[0]=="0" && $result[1]=="1")||($result[0]=="1" && $result[1]=="0"))
       {
        header("Location:../voting.php");
       } 
       else{
           // update impression ticket---------------------------------------------------
            try {
                
                $sql = "UPDATE competition SET impression_ticket=1 WHERE judge_id=$userID AND side=$side AND competition_id='$competition_id1'";
                // use exec() because no results are returned
                $conn->exec($sql);
                header("Location:../voting.php");
                }
            catch(PDOException $e)
                {
                echo $sql . "<br>" . $e->getMessage();
                }

       }
       
    }
catch(PDOException $e)
{
echo $stmt . "<br>" . $e->getMessage();
}



?>
