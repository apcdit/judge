<?php
include('header.php'); 
session_start();
include('navigation.php');
if(!isset($_SESSION['userID'])){
    header("Location: login.php");
}
include('inc/connect.php');
$titleID = $_SESSION['titleID'];
$title = $_SESSION['title'];
$userID = $_SESSION['userID'];
$competition_id1 = $_SESSION['titleID'];

$stmt123 = $conn->prepare("SELECT zongjie_ticket,bestParticipant FROM competition WHERE competition_id=? AND judge_id=? and side=0"); 
$stmt123->execute([$_SESSION['titleID'],$_SESSION['userID']]);

$result = $stmt123->setFetchMode(PDO::FETCH_ASSOC);
// //  var_dump($stmt->fetchAll());
$data=$stmt123->fetchAll();
// var_dump($data);
$showData=$data[0]['bestParticipant'];
$negative=$data[0]['zongjie_ticket'];
if(sizeof($data)<1){
    header('Location:mark3.php');
}


try{
    $stmt = $conn->prepare("SELECT * FROM `competition` WHERE competition_id='$competition_id1' and side=0");
    if($stmt->execute())
    {
        $bestParticipantList=[];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            array_push($bestParticipantList,$row['bestParticipant1'],$row['bestParticipant2'],$row['bestParticipant3']);
            
            // var_dump($row);
        }
    }
    // print_r($bestParticipantList);
    $number_of_ticket_each_participant = array_count_values($bestParticipantList);
    $keys = array_keys($number_of_ticket_each_participant); // get the key
    // print_r( $number_of_ticket_each_participant);

    // ad---------------------------------------
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

        }}
    // asd---------------
  


// Score of negative side----------------------------------------------------------------------------------------------------------
    $stmt1 = $conn->prepare("SELECT * FROM `competition` WHERE competition_id='$competition_id1' and side=0 ");
    if($stmt1->execute())
    {
        $score1=[];
        $i=0;
        $negative1=0;
        $negative2=0;
        $negative3=0;
        $negative4=0;
        while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC))
        {                
            array_push($score1,$row1);
            $negative1=$negative1+$score1[$i]['lilun']+$score1[$i]['zhixun_1']+$score1[$i]['yuyan_1'];
            $negative2=$negative2+$score1[$i]['bolun']+$score1[$i]['gongbian']+$score1[$i]['yuyan_2'];
            $negative3=$negative3+$score1[$i]['zhixun_3']+$score1[$i]['xiaojie']+$score1[$i]['yuyan_3'];
            $negative4=$negative4+$score1[$i]['chenci']+$score1[$i]['yuyan_4'];
            $impression_ticket_neg=$score1[$i]['impression_ticket'];
            $zongjie_ticket_neg=$score1[$i]['zongjie_ticket'];
            $fenshu_neg=$score1[$i]['mark_ticket'];
            $ziyou_bianlun_neg=$score1[$i]['ziyou_1']+$score1[$i]['ziyou_2']+$score1[$i]['ziyou_3']+$score1[$i]['ziyou_4'];
            $total_mark_neg=$score1[$i]['total_mark'];
            $tuanti_neg=$score1[$i]['tuanti'];
            $i++;    
        }
    }
    $_SESSION["反方一辩"]=$negative1;
    $_SESSION["反方二辩"]=$negative2;
    $_SESSION["反方三辩"]=$negative3;
    $_SESSION["反方四辩"]=$negative4;
    // echo "<br>negative1:".$_SESSION["反方一辩"];
    // echo "<br>negative2:".$_SESSION["反方二辩"];
    // echo "<br>negative3:".$_SESSION["反方三辩"];
    // echo "<br>negative4:".$_SESSION["反方四辩"];

// -------------------end of negative side--------------------------------------------------------------------------------------------------------------------
// score of positive side----------------------------------------------------------------------------------------------------------
    $stmt2 = $conn->prepare("SELECT * FROM `competition` WHERE competition_id='$competition_id1' and side=1 ");
    if($stmt2->execute())
    {
        $score=[];
        $affirmative1=0;
        $affirmative2=0;
        $affirmative3=0;
        $affirmative4=0;
        $j=0;
        while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC))
        {
            array_push($score,$row2);
            
            $affirmative1=$affirmative1+$score[$j]['lilun']+$score[$j]['zhixun_1']+$score[$j]['yuyan_1'];
            $affirmative2=$affirmative2+$score[$j]['bolun']+$score[$j]['gongbian']+$score[$j]['yuyan_2'];
            $affirmative3=$affirmative3+$score[$j]['zhixun_3']+$score[$j]['xiaojie']+$score[$j]['yuyan_3'];
            $affirmative4=$affirmative4+$score[$j]['chenci']+$score[$j]['yuyan_4'];
            $impression_ticket_pos=$score[$j]['impression_ticket'];
            $zongjie_ticket_pos=$score[$j]['zongjie_ticket'];
            $fenshu_pos=$score[$j]['mark_ticket'];
            $ziyou_bianlun_pos=$score[$j]['ziyou_1']+$score[$j]['ziyou_2']+$score[$j]['ziyou_3']+$score[$j]['ziyou_4'];
            $total_mark_pos=$score[$j]['total_mark'];
            $tuanti_pos=$score[$j]['tuanti'];
            $j++;
            
        }
    }
    $_SESSION["正方一辩"]=$affirmative1;
    $_SESSION["正方二辩"]=$affirmative2;
    $_SESSION["正方三辩"]=$affirmative3;
    $_SESSION["正方四辩"]=$affirmative4;
    // echo "<br>affirmative1:".$_SESSION["正方一辩"];
    // echo "<br>affirmative2:".$_SESSION["正方二辩"];
    // echo "<br>affirmative3:".$_SESSION["正方三辩"];
    // echo "<br>affirmative4:".$_SESSION["正方四辩"];
// -------------------end of positive side--------------------------------------------------------------------------------------------------------------------
    
}
catch(PDOException $e)
    {
    echo $stmt . "<br>" . $e->getMessage();
   
    }
//------------------------------------------------ end of getting data from database----------------------------------------------------------------------------------------------------------------------------------


    $participant_score=[];   // use to store key=>value  ...... value = TotalVotingTicketbyParticipant*100+his competition result
    $ranking=[]; // use to score user value of array :participant_score  for ranking
    for($j=0;$j<sizeof($number_of_ticket_each_participant);$j++)
    {
        // echo $keys[$j].$number_of_ticket_each_participant[$keys[$j]];
        if($keys[$j]=="正方一辩")
        {
            array_push($participant_score,(array($keys[$j] => $number_of_ticket_each_participant[$keys[$j]]*10000+$affirmative1)));
            array_push($ranking,$number_of_ticket_each_participant[$keys[$j]]*10000+$affirmative1);
        
        }
        if($keys[$j]=="正方二辩")
        {array_push($participant_score,(array($keys[$j] => $number_of_ticket_each_participant[$keys[$j]]*10000+$affirmative2)));
            array_push($ranking,$number_of_ticket_each_participant[$keys[$j]]*10000+$affirmative2);
        }
        if($keys[$j]=="正方三辩")
        {
            array_push($participant_score,(array($keys[$j] => $number_of_ticket_each_participant[$keys[$j]]*10000+$affirmative3)));
            array_push($ranking,$number_of_ticket_each_participant[$keys[$j]]*10000+$affirmative3);
            
        }
        if($keys[$j]=="正方四辩")
        {
            array_push($participant_score,(array($keys[$j] => $number_of_ticket_each_participant[$keys[$j]]*10000+$affirmative4)));
            array_push($ranking,$number_of_ticket_each_participant[$keys[$j]]*10000+$affirmative4);
        }
        if($keys[$j]=="反方一辩")
        {
            array_push($participant_score,(array($keys[$j] => $number_of_ticket_each_participant[$keys[$j]]*10000+$negative1)));
            array_push($ranking,$number_of_ticket_each_participant[$keys[$j]]*10000+$negative1);
        }
        if($keys[$j]=="反方二辩")
        {
            array_push($participant_score,(array($keys[$j] => $number_of_ticket_each_participant[$keys[$j]]*10000+$negative2)));
            array_push($ranking,$number_of_ticket_each_participant[$keys[$j]]*10000+$negative2);
        }
        if($keys[$j]=="反方三辩")
        {
            array_push($participant_score,(array($keys[$j] => $number_of_ticket_each_participant[$keys[$j]]*10000+$negative3)));
            array_push($ranking,$number_of_ticket_each_participant[$keys[$j]]*10000+$negative3);
        }
        if($keys[$j]=="反方四辩")
        {
            array_push($participant_score,(array($keys[$j] => $number_of_ticket_each_participant[$keys[$j]]*10000+$negative4)));
            array_push($ranking,$number_of_ticket_each_participant[$keys[$j]]*10000+$negative4);
        }
    }
    rsort($ranking);

    // echo "<br>ranking:";print_r($ranking);
    $topThreeRanking=[];
    $counter=0;
    $topThreeRanking[0]=$ranking[0];
    // echo"<br>topthreeranking".print_r($topThreeRanking);
    for($i=0;$i<count($ranking);$i++)
    {
        if($counter==2){break;}
        if($ranking[$i]==$topThreeRanking[$counter]){continue;}
        else{array_push($topThreeRanking,$ranking[$i]);$counter++;}
        
    }
    // echo "<br>TopThreeRanking:";print_r($topThreeRanking);
    // echo "<br>participant_score:";print_r($participant_score);x

    $counter=0;
    $bestParticipantResult=[];
    
  for($i=0;$i<count($topThreeRanking);$i++)
  {
      for($j=0;$j<sizeof($participant_score);$j++)
      {
        if($participant_score[$j][$keys[$j]]==$topThreeRanking[$i])
        
        {
            // echo "Score: ".$topThreeRanking[$i];
            array_push($bestParticipantResult,key($participant_score[$j]));
         }
        
      }
      if(($i==0||$i==1)&&count($bestParticipantResult)>=3){break;}
     
  }
    // echo "<br>participant_result:";print_r($bestParticipantResult);
    // $_SESSION["最佳辩手候选人"]=$bestParticipantResult;
    //  print_r( $_SESSION["最佳辩手候选人"]);

    // header('Location:../votingResult.php');
?>
<div  class="container" id="showData4" style="display:none;">
      <h3 style="text-align:center;color:darkred;margin-top:30px;">电子投票环节已经结束，感谢评审</h3>
    </div>
<div class="container">
<form method="POST" action="bestParticipant.php" style="width:300px;margin:50px auto;text-align:center;" id="showData5">
    <span><b>最佳辩手</b></span>
        <select name="bestParticipant" id="participant1" class="form-control group" required 
            <?php
                    if($showData!="0"){
                        echo "disabled" ; }
            ?>
        >
        <?php
        if($showData!="0")
            {
                echo "</select><span>: ".$showData."</span>";
            }
            else
            {
                for($i=0;$i<count($bestParticipantResult);$i++){
                    echo "<option value='$bestParticipantResult[$i]'>$bestParticipantResult[$i]</option>";
                }
            }
        ?>
        </select>
        <button type="submit" 
            <?php
                    if($showData!="0"){
                        echo "style='display:none;'" ; }
                ?>
        >提交</button>
    </form>
   
    <form method="POST" action="delete.php">
    <button>删除我的资料</button>
    </form>

</div>

<script>
var x='<?php echo $showData; ?>';
// alert(x);
if(isNaN(x)){
    document.getElementById('participant1').style.display = "none";
    document.getElementById('showData4').style.display = "block";
    document.getElementById('showData5').style.display = "none";
    
    }
if(!isNaN(x)){

document.getElementById('showData2').style.display = "none";
document.getElementById('showData3').style.display = "none";

}



</script>