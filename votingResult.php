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

$stmt123 = $conn->prepare("SELECT zongjie_ticket FROM competition WHERE competition_id=? AND judge_id=? and side=0"); 
$stmt123->execute([$_SESSION['titleID'],$_SESSION['userID']]);

$result = $stmt123->setFetchMode(PDO::FETCH_ASSOC);
// //  var_dump($stmt->fetchAll());
$data=$stmt123->fetchAll();
$negative=$data[0]['zongjie_ticket'];
if(sizeof($data)<1){
    header('Location:mark3.php');
}

try {
    
    $stmt = $conn->prepare("SELECT bestParticipant1,bestParticipant2,bestParticipant3,bestParticipant FROM `competition` WHERE competition_id='$competition_id1' and side=0");
    // use exec() because no results are returned
    $bestParticipantResult="";
    $products = array();
                $count = 0;
                if($stmt->execute()){
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $participant[] = $row;
                    // echo $participant[$count]['bestParticipant1']." ".$participant[$count]['bestParticipant2']."  ".$participant[$count]['bestParticipant3']."</br>";
                    array_push($products, $participant[$count]['bestParticipant1'],$participant[$count]['bestParticipant2'],$participant[$count]['bestParticipant3']);
                    $bestParticipantResult=$participant[$count]['bestParticipant'];
                    $count++;
                    
                }
                }
                // var_dump($products);
                
                
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
    $result_impressionTicket=[];
    $stmt_result = $conn->prepare("SELECT zongjie_ticket,bestParticipant1,bestParticipant2,bestParticipant3 FROM `competition` WHERE judge_id='$userID' and competition_id='$competition_id1' ");
    if($stmt_result->execute()){

        while($row_participant= $stmt_result->fetch(PDO::FETCH_ASSOC))
        {
                // var_dump($row_participant);
                // echo(($row_participant["bestParticipant1"])=="0");
                if(($row_participant["bestParticipant1"]=="0")&&($row_participant["bestParticipant2"]=="0")&&($row_participant["bestParticipant3"]=="0")){
                    header("Location:voting.php");
                }
                array_push($result_impressionTicket,$row_participant["zongjie_ticket"]);

        }
        if($result_impressionTicket[0]==$result_impressionTicket[1]){
            header("Location:mark3.php");

        }


    }
        // use exec() because no results are returned
        

        $stmt = $conn->prepare("SELECT * FROM `competition` WHERE competition_id='$competition_id1' and side=0");
        if($stmt->execute()){
            $score1=[];
            $i=0;
            $negative1=0;
            $negative2=0;
            $negative3=0;
            $negative4=0;
            while($row1 = $stmt->fetch(PDO::FETCH_ASSOC))
            {
            array_push($score1,$row1);
            $negative1=$negative1+$score1[$i]['lilun']+$score1[$i]['zhixun_1']+$score1[$i]['yuyan_1'];
            $negative2=$negative2+$score1[$i]['bolun']+$score1[$i]['gongbian']+$score1[$i]['yuyan_2'];
            $negative3=$negative3+$score1[$i]['zhixun_3']+$score1[$i]['xiaojie']+$score1[$i]['yuyan_3'];
            $negative4=$negative4+$score1[$i]['chenci']+$score1[$i]['yuyan_4'];
            $i++;
           
        }
        echo "<div class='row' style='text-align:center;width:300px;margin:auto auto;'><div class='col-sm-6'>";
        echo "总分";
        echo "<br>反方一辩".($negative1);
        echo "<br>反方二辩".($negative2);
        echo "<br>反方三辩".($negative3);
        echo "<br>反方四辩".($negative4);
        echo "</div>";
        }
        $stmt1 = $conn->prepare("SELECT * FROM `competition` WHERE competition_id='$competition_id1' and side=1");
        // use exec() because no results are returned
        
        if($stmt1->execute()){
            $score=[];
            $affirmative1=0;
            $affirmative2=0;
            $affirmative3=0;
            $affirmative4=0;
            $j=0;
            while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC))
            {
                array_push($score,$row1);
                
                $affirmative1=$affirmative1+$score[$j]['lilun']+$score[$j]['zhixun_1']+$score[$j]['yuyan_1'];
                $affirmative2=$affirmative2+$score[$j]['bolun']+$score[$j]['gongbian']+$score[$j]['yuyan_2'];
                $affirmative3=$affirmative3+$score[$j]['zhixun_3']+$score[$j]['xiaojie']+$score[$j]['yuyan_3'];
                $affirmative4=$affirmative4+$score[$j]['chenci']+$score[$j]['yuyan_4'];
                $j++;
            }
            echo "<div class='col-sm-6'>";
            echo "总分";
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
                array_push($participant_score,(array($keys[$j] => $vals[$keys[$j]]*10000+$affirmative1)));
                array_push($ranking,$vals[$keys[$j]]*10000+$affirmative1);
            
            }
            if($keys[$j]=="正方二辩")
            {array_push($participant_score,(array($keys[$j] => $vals[$keys[$j]]*10000+$affirmative2)));
                array_push($ranking,$vals[$keys[$j]]*10000+$affirmative2);
            }
            if($keys[$j]=="正方三辩")
            {
                array_push($participant_score,(array($keys[$j] => $vals[$keys[$j]]*10000+$affirmative3)));
                array_push($ranking,$vals[$keys[$j]]*10000+$affirmative3);
                
            }
            if($keys[$j]=="正方四辩")
            {
                array_push($participant_score,(array($keys[$j] => $vals[$keys[$j]]*10000+$affirmative4)));
                array_push($ranking,$vals[$keys[$j]]*10000+$affirmative4);
            }
            if($keys[$j]=="反方一辩")
            {
                array_push($participant_score,(array($keys[$j] => $vals[$keys[$j]]*10000+$negative1)));
                array_push($ranking,$vals[$keys[$j]]*10000+$negative1);
            }
            if($keys[$j]=="反方二辩")
            {
                array_push($participant_score,(array($keys[$j] => $vals[$keys[$j]]*10000+$negative2)));
                array_push($ranking,$vals[$keys[$j]]*10000+$negative2);
            }
            if($keys[$j]=="反方三辩")
            {
                array_push($participant_score,(array($keys[$j] => $vals[$keys[$j]]*10000+$negative3)));
                array_push($ranking,$vals[$keys[$j]]*10000+$negative3);
            }
            if($keys[$j]=="反方四辩")
            {
                array_push($participant_score,(array($keys[$j] => $vals[$keys[$j]]*10000+$negative4)));
                array_push($ranking,$vals[$keys[$j]]*10000+$negative4);
            }
        }
        rsort($ranking);
        // var_dump($ranking);
        // var_dumP($participant_score);
        // echo $participant_score[0][$keys[0]];
        $bestParticipant=[];
        
        
        for($i=0;$i<3 && $i<$j;$i++)
        {
            // echo sizeof($participant_score);
            
            for($j=0;$j<sizeof($participant_score)&&sizeof($ranking)>0;$j++)
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
        // echo "<div style='width:300px;margin:30px auto;text-align:center;'><h3>最佳辩手</h3>";
        // echo $bestParticipant[0]."<br>";        
        // echo "</div>";
        
        

        
        // var_dump($participant_score);
            
            
            // 
}
catch(PDOException $e)
{
    echo $stmt . "<br>" . $e->getMessage();
    echo $stmt1 . "<br>" . $e->getMessage();
    
}

?>
<div class="container">
    <form method="POST" action="/php/bestParticipant.php" style="width:300px;margin:auto auto;text-align:center;">
    <h1>最佳辩手</h1>
        <select name="bestParticipant" id="participant1" class="form-control group" required
        <?php
                if($bestParticipantResult!="0"){
                    echo "disabled" ; }
            ?>
        >
        <?php
            for($i=0;$i<3;$i++){
                echo "<option value='$bestParticipant[$i]'>$bestParticipant[$i]</option>";
            }
        ?>
        </select>
        <button type="submit" 
        <?php
                if($bestParticipantResult!="0"){
                    echo "disabled" ; }
            ?>
        >提交</button>
    </form>
</div>

