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



/*
    BEST PARTICIPANT
*/
$sql = $conn->prepare("SELECT bestParticipant1, bestParticipant2, bestParticipant3 FROM competition WHERE competition_id=? and side=0");
$sql->execute([$competition_id]);
$result = $sql->fetchAll(PDO::FETCH_ASSOC);

$occurence = array();
foreach($result as $r){
    foreach($r as $participant){
        if(!empty($participant))
            array_push($occurence, $participant);
    }
}

$count = array_count_values($occurence); //get the ticket count of each voted participant
arsort($count); //sort according to the value

function calResult($num,$count, &$minVote){
    $bestParticipant = array();
    $counter = 0;
    foreach($count as $key => $value){
        if($counter == $num-1){
            $minVote = $value;
        }
        if($value < $minVote){
            break;
        } 
        $bestParticipant[$key] = $value;
        $counter++;
    }
    return $bestParticipant;
}

$minVote = -9999;
$numBest = 3;
$bestParticipant = calResult($numBest, $count, $minVote);

// print_r($bestParticipant);
if(count($bestParticipant) > $numBest){
    $min_keys = array_keys($bestParticipant, min($bestParticipant));
    //正方
    $stmt = $conn->prepare("SELECT * FROM competition WHERE competition_id=? and side=1");
    $stmt->execute([$competition_id]);
    $pointsPos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    //反方
    $stmt = $conn->prepare("SELECT * FROM competition WHERE competition_id=? and side=0");
    $stmt->execute([$competition_id]);
    $pointsNeg = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $positive1 = $positive2 = $positive3 = $positive4 = 0;
    $negative1 = $negative2 = $negative3 = $negative4 = 0;

    foreach($min_keys as $key){
        switch($key){
            case "正方一辩":
                foreach($pointsPos as $point){
                    $positive1 = $positive1 + $point['lilun']+$point['zhixun_1']+$point['yuyan_1'];
                }
                break;
            case "正方二辩":
                foreach($pointsPos as $point){
                    $positive2 = $positive2 + $point['bolun'] + $point['gongbian'] + $point['yuyan_2'];
                }
                break;
            case "正方三辩":
                foreach($pointsPos as $point){
                    $positive3 = $positive3 + $point['zhixun_3'] + $point['xiaojie'] + $point['yuyan_3'];
                }
                break;
            case "正方四辩":
                foreach($pointsPos as $point){
                    $positive4 = $positive4 + $point['chenci']+ $point['yuyan_4'];
                }
                break;
            case "反方一辩":
                foreach($pointsNeg as $point){
                    $negative1 = $negative1 + $point['lilun']+$point['zhixun_1']+$point['yuyan_1'];
                }
                break;
            case "反方二辩":
                foreach($pointsNeg as $point){
                    $negative2 = $negative2 + $point['bolun'] + $point['gongbian'] + $point['yuyan_2'];
                }
                break;
            case "反方三辩":
                foreach($pointsNeg as $point){
                    $negative3 = $negative3 + $point['zhixun_3'] + $point['xiaojie'] + $point['yuyan_3'];
                }
                break;
            case "反方四辩":
                foreach($pointsNeg as $point){
                    $negative4 = $negative4 + $point['chenci']+ $point['yuyan_4'];
                }
                break;
        }
    }

    $total_marks = array("正方一辩" => $positive1, "正方二辩" => $positive2, "正方三辩" => $positive3, 
    "正方四辩" => $positive4, "反方一辩" => $negative1, "反方二辩" => $negative2, "反方三辩" => $negative3, "反方四辩" => $negative4);

    foreach($total_marks as $key => $ma){
        if($ma == 0) unset($total_marks[$key]);
    }
    arsort($total_marks);

    $k = 0;
    $current = count($bestParticipant) - count($min_keys);
    $diff = $numBest - $current;
    $best = array();

    foreach($bestParticipant as $key => $p){
        if($p == $minVote){
            unset($bestParticipant[$key]);
        }
    }

    //get the top how many and insert
    foreach($total_marks as $key => $mark){
        if($k < $diff){
            $best[$key] = $mark;
            $k++;
        }else
            break;
    }

    foreach($best as $key => $q){
        $bestParticipant[$key] = $q;
    }
}
?>

<html>
    <head>
        <title>最佳辩手结果</title>
    </head>

    <body>
    <div class="">
        <img id="logo_pos" src="<?php echo $image_pos; ?>" style="height:35%; width:auto;" alt="">
        <img id="logo_neg" src="<?php echo $image_neg; ?>" style="height:35%; width:auto;" alt="">
        <h3 id="ticket" style="font-weight:900;">最佳辩手</h3>
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
                    foreach($bestParticipant as $key=>$bestP){
                        echo '<tr id="marks">';
                        echo '<th></th>';
                        echo '<th><h4>'.$key.'</h4></th>';
                        echo '<th></th>';
                        echo '</tr>';
                    }
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
        /* margin-top: 20%;
        margin-left: 34%; */
        position: fixed;
        left: 22.3%;
        top: 31%;
        width: 17%;
        height: auto;
    }
    #logo_neg{
        /* margin-top: 20%;
        margin-left: 18%; */
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
    
   #marks h4{
       font-size: 3vw;
       background-color: darkred;
       color: white;
       opacity: 0.8;
   }
</style>