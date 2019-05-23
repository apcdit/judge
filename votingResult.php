<?php
include('header.php'); 

include('navigation.php');


session_start();


if(!isset($_SESSION['userID'])){
    header("Location: login.php");
}
include('/inc/connect.php');
if(!isset($_SESSION['userID'])){
    header("Location: login.php");
}
$titleID = $_SESSION['titleID'];
$title = $_SESSION['title'];
$userID = $_SESSION['userID'];
$competition_id1 = $_SESSION['titleID'];

try {
    
    $sql = $conn->prepare("SELECT bestParticipant1,bestParticipant2,bestParticipant3 FROM `competition` WHERE competition_id='$competition_id1' and side=0");
    // use exec() because no results are returned
    
    $products = array();
                $count = 0;
                if($sql->execute()){
                while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $participant[] = $row;
                    // echo $participant[$count]['bestParticipant1']." ".$participant[$count]['bestParticipant2']."  ".$participant[$count]['bestParticipant3']."</br>";
                    array_push($products, $participant[$count]['bestParticipant1'],$participant[$count]['bestParticipant2'],$participant[$count]['bestParticipant3']);
                    $count++;
                }
                }
                //var_dump($products);
                
                $vals = array_count_values($products);// calculate the number of occurerance 
                
                //var_dump($vals);
                $keys = array_keys($vals); // get the key
                 var_dump($vals);
                
            
                echo "<div style='text-align:center;width:300px;margin:50px auto;'>";
                 for($i=0;$i<count($vals);$i++)
                 {
                    
                    echo $keys[$i]." ".$vals[$keys[$i]]."<br>";
                 }
                 echo "</div>";
                 

    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
   
    }
try{
    $stmt = $conn->prepare("SELECT * FROM `competition` WHERE judge_id='$userID' and competition_id='$competition_id1' and side=0");
        // use exec() because no results are returned
        
        if($stmt->execute()){
            $row1 = $stmt->fetch(PDO::FETCH_ASSOC);
            $score1[] = $row1;
            echo "<div class='row' style='text-align:center;width:300px;margin:auto auto;'><div class='col-sm-6'>";
            echo "总分";
            echo "<br>反方一辩".($score1[0]['lilun']+$score1[0]['zhixun_1']+$score1[0]['yuyan_1']+$score1[0]['ziyou_1']);
            echo "<br>反方二辩".($score1[0]['bolun']+$score1[0]['gongbian']+$score1[0]['yuyan_2']+$score1[0]['ziyou_2']);
            echo "<br>反方三辩".($score1[0]['zhixun_3']+$score1[0]['xiaojie']+$score1[0]['yuyan_3']+$score1[0]['ziyou_3']);
            echo "<br>反方四辩".($score1[0]['chenci']+$score1[0]['yuyan_4']+$score1[0]['ziyou_4']);
            echo "</div>";
        }
        $stmt1 = $conn->prepare("SELECT * FROM `competition` WHERE judge_id='$userID' and competition_id='$competition_id1' and side=1");
        // use exec() because no results are returned
        
        if($stmt1->execute()){
            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
            $score[] = $row1;
            echo "<div class='col-sm-6'>";
            echo "总分";
            echo "<br>正方一辩".($score[0]['lilun']+$score[0]['zhixun_1']+$score[0]['yuyan_1']+$score[0]['ziyou_1']);
            echo "<br>正方二辩".($score[0]['bolun']+$score[0]['gongbian']+$score[0]['yuyan_2']+$score[0]['ziyou_2']);
            echo "<br>正方三辩".($score[0]['zhixun_3']+$score[0]['xiaojie']+$score[0]['yuyan_3']+$score[0]['ziyou_3']);
            echo "<br>正方四辩".($score[0]['chenci']+$score[0]['yuyan_4']+$score[0]['ziyou_4']);
            echo "</div></div>";
        }
            
            
            // 
}
catch(PDOException $e)
{
    echo $stmt . "<br>" . $e->getMessage();
    echo $stmt1 . "<br>" . $e->getMessage();
    
}

?>

