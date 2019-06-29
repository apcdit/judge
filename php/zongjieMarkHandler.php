<?php 
 include('../header.php'); 
 session_start();
include('../inc/connect.php');


$side= $_REQUEST["side"];
$userID= $_SESSION['userID'] ;
$competition_id1 = $_SESSION['titleID'];

//crosscheck data existed in database--------------------------------------------------------
try{
    //-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    $stmt = $conn->prepare("SELECT zongjie_ticket FROM `competition` WHERE judge_id='$userID' and competition_id='$competition_id1'");
    // use exec() because no results are returned
    $result=[];
    if($stmt->execute()){
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
       array_push($result,$row["zongjie_ticket"]);
       
        }}
        var_dump($result);
       if(($result[0]=="0" && $result[1]=="1")||($result[0]=="1" && $result[1]=="0"))
       {
        header('Location:../bestParticipantAlgo.php');
       } 
       else{
        try {
            //------------------Set  mark ticket = zongjie mark if total mark negative=positve and tuanti neg = tuanti pos
            $compare = $conn->prepare("SELECT mark_ticket FROM competition WHERE judge_id=$userID and side=0 AND competition_id='$competition_id1'");
            if($compare->execute()){
                
                
               $row1 = $compare->fetch(PDO::FETCH_ASSOC);
                $mark_ticket_negative=$row1["mark_ticket"];
                // echo "mark ticket negative". $mark_ticket_negative;
            }
            $compare1 = $conn->prepare("SELECT mark_ticket FROM competition WHERE judge_id=$userID and side=1 AND competition_id='$competition_id1'");
            if($compare1->execute()){
                
                
               $row2 = $compare1->fetch(PDO::FETCH_ASSOC);
                $mark_ticket_positive=$row2["mark_ticket"];
                // echo "mark ticket positive". $mark_ticket_positive;
            }
            if($mark_ticket_positive==$mark_ticket_negative)
            {
                $sql1 = "UPDATE competition SET mark_ticket=1,zongjie_ticket=1 WHERE judge_id=$userID AND side=$side AND competition_id='$competition_id1'";
                $conn->exec($sql1);
                header('Location:../bestParticipantAlgo.php');
            }
               
        
            //update the zongjie mark
            else
                {
                    $sql = "UPDATE competition SET zongjie_ticket=1 WHERE judge_id=$userID AND side=$side AND competition_id='$competition_id1'";
                    // use exec() because no results are returned
                    $conn->exec($sql);
                    //  echo "New record created successfully";
                    header('Location:../bestParticipantAlgo.php');
                }   
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