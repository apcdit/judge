<?php
include('header.php'); 

include('navigation.php');


session_start();


if(!isset($_SESSION['userID'])){
    header("Location: login.php");
}
include('inc/connect.php');
if(!isset($_SESSION['userID'])){
    header("Location: login.php");
}
$titleID = $_SESSION['titleID'];
$title = $_SESSION['title'];
$userID = $_SESSION['userID'];
$competition_id1 = $_SESSION['titleID'];

try {
    
    $stmt = $conn->prepare("SELECT bestParticipant1,bestParticipant2,bestParticipant3 FROM `competition` WHERE competition_id='$competition_id1' and side=0");
    // use exec() because no results are returned
    
    $products = array();
                $count = 0;
                if($stmt->execute()){
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $participant[] = $row;
                    // echo $participant[$count]['bestParticipant1']." ".$participant[$count]['bestParticipant2']."  ".$participant[$count]['bestParticipant3']."</br>";
                    array_push($products, $participant[$count]['bestParticipant1'],$participant[$count]['bestParticipant2'],$participant[$count]['bestParticipant3']);
                    $count++;
                }
                }
                //var_dump($products);
                
                $vals = array_count_values($products);// calculate the number of occurerance               
                $keys = array_keys($vals); // get the key
                // var_dump($vals);
                
                $bestParticipant='';
                echo "<div style='text-align:center;width:300px;margin:50px auto;'>";
                echo "<h3>投票票数</h3>";
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
            $negative1=$score1[0]['lilun']+$score1[0]['zhixun_1']+$score1[0]['yuyan_1']+$score1[0]['ziyou_1'];
            $negative2=$score1[0]['bolun']+$score1[0]['gongbian']+$score1[0]['yuyan_2']+$score1[0]['ziyou_2'];
            $negative3=$score1[0]['zhixun_3']+$score1[0]['xiaojie']+$score1[0]['yuyan_3']+$score1[0]['ziyou_3'];
            $negetive4=$score1[0]['chenci']+$score1[0]['yuyan_4']+$score1[0]['ziyou_4'];
            echo "<div class='row' style='text-align:center;width:300px;margin:auto auto;'><div class='col-sm-6'>";
            echo "总分";
            echo "<br>反方一辩".($negative1);
            echo "<br>反方二辩".($negative2);
            echo "<br>反方三辩".($negative3);
            echo "<br>反方四辩".($negetive4);
            echo "</div>";
        }
        $stmt1 = $conn->prepare("SELECT * FROM `competition` WHERE judge_id='$userID' and competition_id='$competition_id1' and side=1");
        // use exec() because no results are returned
        
        if($stmt1->execute()){
            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
            $score[] = $row1;
            echo "<div class='col-sm-6'>";
            echo "总分";
            $affirmative1=$score[0]['lilun']+$score[0]['zhixun_1']+$score[0]['yuyan_1']+$score[0]['ziyou_1'];
            $affirmative2=$score[0]['bolun']+$score[0]['gongbian']+$score[0]['yuyan_2']+$score[0]['ziyou_2'];
            $affirmative3=$score[0]['zhixun_3']+$score[0]['xiaojie']+$score[0]['yuyan_3']+$score[0]['ziyou_3'];
            $affirmative4=$score[0]['chenci']+$score[0]['yuyan_4']+$score[0]['ziyou_4'];
            echo "<br>正方一辩".($affirmative1);
            echo "<br>正方二辩".($affirmative2);
            echo "<br>正方三辩".($affirmative3);
            echo "<br>正方四辩".($affirmative4);
            echo "</div></div>";
        }
        $participant_score=[];   // use to store key=>value  ...... value = TotalVotingTicketbyParticipant*100+his competition result
        $ranking=[]; // use to score user value of array :participant_score  for ranking
        for($j=0;$j<sizeof($vals);$j++)
        {
            // echo $keys[$j].$vals[$keys[$j]];
            if($keys[$j]=="正方一辩")
            {
                array_push($participant_score,(array($keys[$j] => $vals[$keys[$j]]*100+$affirmative1)));
                array_push($ranking,$vals[$keys[$j]]*100+$affirmative1);
            
            }
            if($keys[$j]=="正方二辩")
            {array_push($participant_score,(array($keys[$j] => $vals[$keys[$j]]*100+$affirmative2)));
                array_push($ranking,$vals[$keys[$j]]*100+$affirmative2);
            }
            if($keys[$j]=="正方三辩")
            {
                array_push($participant_score,(array($keys[$j] => $vals[$keys[$j]]*100+$affirmative3)));
                array_push($ranking,$vals[$keys[$j]]*100+$affirmative3);
                
            }
            if($keys[$j]=="正方四辩")
            {
                array_push($participant_score,(array($keys[$j] => $vals[$keys[$j]]*100+$affirmative4)));
                array_push($ranking,$vals[$keys[$j]]*100+$affirmative4);
            }
            if($keys[$j]=="反方一辩")
            {
                array_push($participant_score,(array($keys[$j] => $vals[$keys[$j]]*100+$negative1)));
                array_push($ranking,$vals[$keys[$j]]*100+$negative1);
            }
            if($keys[$j]=="反方二辩")
            {
                array_push($participant_score,(array($keys[$j] => $vals[$keys[$j]]*100+$negative2)));
                array_push($ranking,$vals[$keys[$j]]*100+$negative2);
            }
            if($keys[$j]=="反方三辩")
            {
                array_push($participant_score,(array($keys[$j] => $vals[$keys[$j]]*100+$negative3)));
                array_push($ranking,$vals[$keys[$j]]*100+$negative3);
            }
            if($keys[$j]=="反方四辩")
            {
                array_push($participant_score,(array($keys[$j] => $vals[$keys[$j]]*100+$negative4)));
                array_push($ranking,$vals[$keys[$j]]*100+$negative4);
            }
        }
        rsort($ranking);
        // var_dump($ranking);
        // var_dumP($participant_score);
        // echo $participant_score[0][$keys[0]];
        $bestParticipant=[];
        
        for($i=0;$i<3 && $i<$j;$i++)
        {
            for($j=0;$j<sizeof($participant_score);$j++)
            {
                if($participant_score[$j][$keys[$j]]==$ranking[$i]){array_push($bestParticipant,key($participant_score[$j])); }
            }
        }
        echo "<div style='width:300px;margin:30px auto;text-align:center;'><h3>最佳三位辩手</h3>";
        echo $bestParticipant[0]."<br>";
        echo $bestParticipant[1]."<br>";
        if(sizeof($bestParticipant)>2){
        echo $bestParticipant[2]."<br>";}
        echo "</div>";
        echo "<div style='width:300px;margin:30px auto;text-align:center;'><h3>最佳辩手</h3>";
        echo $bestParticipant[0]."<br>";        
        echo "</div>";

        
        // var_dump($participant_score);
            
            
            // 
}
catch(PDOException $e)
{
    echo $stmt . "<br>" . $e->getMessage();
    echo $stmt1 . "<br>" . $e->getMessage();
    
}

?>

