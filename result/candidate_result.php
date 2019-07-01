<?php 
include('../header.php');
require('../inc/connect.php');

if(!isset($_GET['competition_id']) || empty($_GET['competition_id'])){
    header("Location: ../result.php");
}
$competition_id = $_GET['competition_id']; 

//use competition id to fetch both school, positive and negative 

$sql = $conn->prepare("SELECT * FROM rounds WHERE competition_id=?");
$sql->execute([$competition_id]);
$round = $sql->fetch(PDO::FETCH_ASSOC);
$image_pos = $round['image_path_pos'];
$image_neg = $round['image_path_neg'];
$uni_pos = $round['uni_pos'];
$uni_neg = $round['uni_neg'];
$title_pos = $round['title_pos'];
$title_neg = $round['title_neg'];



try{
    $stmt = $conn->prepare("SELECT * FROM `competition` WHERE competition_id='$competition_id' and side=0");
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
        
    // asd---------------
  


// Score of negative side----------------------------------------------------------------------------------------------------------
    $stmt1 = $conn->prepare("SELECT * FROM `competition` WHERE competition_id='$competition_id' and side=0 ");
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
    $stmt2 = $conn->prepare("SELECT * FROM `competition` WHERE competition_id='$competition_id' and side=1 ");
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
    // print_r($bestParticipantResult);
    // header('Location:../votingResult.php');
?>

<html>
    <head>
        <title>最佳三位候选人结果</title>
    </head>

    <body>
    <div class="">
        <img id="logo_pos" src="<?php echo $image_pos; ?>" style="height:35%; width:auto;" alt="">
        <img id="logo_neg" src="<?php echo $image_neg; ?>" style="height:35%; width:auto;" alt="">
        <h3 id="ticket" style="font-weight:900;">最佳辩手候选人</h3>
        <table border="0" id="tab">
            <tbody>
                <tr>
                    <th><h4>正方<br><strong><?php echo $uni_pos; ?></strong><h4></th>
                    <th></th>
                    <th><h4>反方<br><strong><?php echo $uni_neg; ?></strong><h4></th>
                </tr>
                <tr>
                    <th><h4><i><?php echo $title_pos; ?></i><h4></th>
                    <th></th>
                    <th><h4><i><?php echo $title_neg; ?></i><h4></th>
                </tr>
                <?php
                    // print_r($bestParticipantResult);
                    // echo "<tr>";
                    // foreach($bestParticipantResult as $key => $value){
                    //     if($key%3 == 0){
                    //         echo "</tr><tr>";
                    //     }
                    //     echo "<td class='marks_bg'>".$value."</td>";
                    // }
                    $outputFront = "";
                    $outputMid = "";
                    $outputEnd = "";
                    $output = "";
                    $final = "";
                    // print_r($bestParticipantResult);
                    // echo count($bestParticipantResult);
                    // 
                    foreach($bestParticipantResult as $key => $value){
                        if($key%3 == 0){
                            $outputMid = "<td class='marks_bg'>".$value."</td>";
                            if(($key+1 == count($bestParticipantResult))){
                                $outputMid = "<td></td>".$outputMid."<td></td>";
                            }
                            $output = $output.$outputMid;
                        }else if($key%3 == 1){
                            $outputFront = "<td class='marks_bg'>".$value."</td>";
                            $output = $output.$outputFront;
                        }else{
                            $outputEnd = "<td class='marks_bg'>".$value."</td>";
                            $output = $output.$outputEnd;
                        }

                        if(($key+1)%3 == 0 || ($key+1) == count($bestParticipantResult)){
                            $output = "<tr>".$output."</tr>";
                            $final = $final.$output;
                            $output = "";
                        }
                    }
                    // echo htmlspecialchars($output);
                    echo $final;
                ?>
            </tbody>
        </table>

    </div>
        
    </body>

</html>

<style>
    body{
        background: url("../images/voting_background.jpg"); no-repeat center center fixed; 
        background-size: cover;
        font-family: Georgia, "Times New Roman", 
             "Microsoft YaHei", "微软雅黑", 
             STXihei, "华文细黑", 
             serif;
    }

    #logo_pos{
        position: fixed;
        left: 25.7%;
        top: 31%;
        width: 17%;
        height: auto;
    }
    #logo_neg{
        position: fixed;
        left: 63.8%;
        top: 31%;
        width: 17%;
        height: auto;
    }

    #tab{
        position: fixed;
        top: 58%;
        left: 36%;
        table-layout: fixed
    }

    
    /* @media screen and (min-width: 1900px) and (max-width: 2000px){ */
        @media screen and (width: 1920px) and (height:1080px){
        /* body{
            background: red;
        } */
        #logo_pos{
            position: fixed;
            left: 21.7%;
            top: 31%;
            width: 17%;
            height: auto;
        }
        #logo_neg{
            position: fixed;
            left: 60.3%;
            top: 31%;
            width: 17%;
            height: auto;
        }
        #tab{
            position: fixed;
            top: 58%;
            left: 30%;
            table-layout: fixed
        }
    }

    @media screen and (width: 1440px) and (height:900px){
        /* body{
            background: red;
        } */
        #logo_pos{
            position: fixed;
            left: 27.3%;
            top: 31%;
            width: 17%;
            height: auto;
        }
        #logo_neg{
            position: fixed;
            left: 65.8%;
            top: 31%;
            width: 17%;
            height: auto;
        }
        #tab{
            position: fixed;
            top: 58%;
            left: 37%;
            table-layout: fixed
        }
    }

    @media screen and (width: 1280px) and (height:720px){
        /* body{
            background: red;
        } */
        #logo_pos{
            position: fixed;
            left: 22.3%;
            top: 31%;
            width: 17%;
            height: auto;
        }
        #logo_neg{
            position: fixed;
            left: 60.3%;
            top: 31%;
            width: 17%;
            height: auto;
        }
        #tab{
            position: fixed;
            top: 58%;
            left: 30%;
            table-layout: fixed
        }
    }

    @media screen and (width: 1280px) and (height: 800px){
        /* body{
            background: yellow;
        } */
        #logo_pos{
            position: fixed;
            left: 25.7%;
            top: 31%;
            width: 17%;
            height: auto;
        }
        #logo_neg{
            position: fixed;
            left: 63.8%;
            top: 31%;
            width: 17%;
            height: auto;
        }

        #tab{
            position: fixed;
            top: 58%;
            left: 36%;
            table-layout: fixed
        }
    }

    
    
    #tab tr th{
        width: 19vw;
    }
    h4{
        font-size: 2vw;
        /* padding-left: 1.2vw; */
        text-align: center;
    }
    
   #ticket{
       color: white;
       width: 0.5vw;
       position: fixed;
       top: 62%;
       left: 2%;
       font-size: 3vw;
   } 
    
   .marks_bg{
       font-size: 3vw;
       background-color: darkred;
       color: white;
       opacity: 0.8;
       text-align: center;
   }
</style>