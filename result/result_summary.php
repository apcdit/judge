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

$sql = $conn->prepare("SELECT side,impression_ticket,mark_ticket,zongjie_ticket FROM competition WHERE competition_id=?");
$sql->execute([$competition_id]);
$result = $sql->fetchAll(PDO::FETCH_ASSOC);

$sql = $conn->prepare("SELECT title FROM titles WHERE competition_id=?");
$sql->execute([$competition_id]);
$title = $sql->fetch();

$impression_pos = $impression_neg = $mark_pos = $mark_neg = $zongjie_pos = $zongjie_neg = 0;

function impression_decide($result,&$impression_pos,&$impression_neg){
    foreach($result as $r){
        //negative or positive side and if impression ticket asserted, then +1
        if($r['side'] == 0 && $r['impression_ticket'] == 1){
            $impression_neg++;
        }
        else if($r['side'] == 1 && $r['impression_ticket'] == 1){
            $impression_pos++; 
        }
    }
}

function mark_decide($result, &$mark_pos, &$mark_neg){
    foreach($result as $r){
        if($r['side'] == 0 && $r['mark_ticket'] == 1){
            $mark_neg++;
        }
        else if($r['side'] == 1 && $r['mark_ticket'] == 1){
            $mark_pos++;
        }
    }
}

function zongjie_decide($result, &$zongjie_pos, &$zongjie_neg){
    foreach($result as $r){
        if($r['side'] == 0 && $r['zongjie_ticket'] == 1){
            $zongjie_neg++;
        }
        else if($r['side'] == 1 && $r['zongjie_ticket'] == 1){
            $zongjie_pos++;
        }
    }
}

impression_decide($result, $impression_pos, $impression_neg);
mark_decide($result, $mark_pos, $mark_neg);
zongjie_decide($result, $zongjie_pos, $zongjie_neg);

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
$numBest = 1;
$bestParticipant = calResult($numBest, $count, $minVote);

// if(count($bestParticipant) > $numBest){
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
    
?>

<html>
    <head>
        <title>票数总结</title>
    </head>

    <body>
    <div class="">
        <div id="title">
            <h1><?php echo $competition_id.". ".$title[0]; ?></h1>
        </div>
        <img id="logo_pos" src="<?php echo $image_pos; ?>" height= 12% width=auto alt="">
        <img id="logo_neg" src="<?php echo $image_neg; ?>" height= 12% width=auto alt="">
        <!-- <h3 id="ticket" style="font-weight:900;"><?php echo $competition_id ?></h3> -->
        <table border="0" id="tab" align="center">
            <tbody>
                <tr>
                    <th><h4><br><?php echo "马来西亚理科大学总院校"; ?><h4></th>
                    <th></th>
                    <th><h4><br><?php echo $uni_neg; ?><h4></th>
                </tr>
                <tr style="height:1vw"><th></th></tr>
                <tr style="height:1vw"><th></th></tr>
                <tr><th></th></tr>
                <tr><th></th></tr> 
                <tr id="marks">
                    <th><h4><?php echo $impression_pos; ?></h4></th>
                    <th><h5 class="ticket_name">印象票</h5></th>
                    <th><h4><?php echo $impression_neg; ?></h4></th>
                </tr>
                <tr id="marks">
                    <th><h4><?php echo $mark_pos; ?></h4></th>
                    <th><h5 class="ticket_name">分数票</h5></th>
                    <th><h4><?php echo $mark_neg; ?></h4></th>
                </tr>
                <tr id="marks">
                    <th><h4><?php echo $zongjie_pos; ?></h4></th>
                    <th><h5 class="ticket_name">总结票</h5></th>
                    <th><h4><?php echo $zongjie_neg; ?></h4></th>
                </tr>
                <tr style="height:1.7vh;"><th></th></tr>
                <tr id="marks">
                    <th><h4 style="color:#982b24;"><strong><i><?php echo $impression_pos+$mark_pos+$zongjie_pos; ?></i></strong></h4></th>
                    <th><h5 class="ticket_name">总票数</h5></th>
                    <th><h4 style="color:#982b24;"><strong><i><?php echo $impression_neg + $mark_neg + $zongjie_neg; ?></i></strong></h4></th>
                </tr>
            </tbody>
        </table>
        <div style="">
        <h1 id="best"><strong>
            <?php  reset($bestParticipant);
                                $first_key = key($bestParticipant);
                                if($first_key[0] == "正")
                                    echo ($uni_pos." ".$first_key); 
                                else
                                    echo ($uni_neg." ".$first_key);
                                    ?></strong>
        </h1>
        </div>
    </div>
       <div id="foo">
            <h1 style="font-size:4.2vw;color:#982b24;"><?php 
                if($competition_id[0] == "A" || $competition_id[0] == "B" || $competition_id[0] == "C" || $competition_id[0] == "D" || $competition_id[0] == "E" || $competition_id[0] == "F"|| $competition_id[0] == "G"|| $competition_id[0] == "H"){
                    echo "循环赛";
                }else if($competition_id[0] == "I")
                    echo "复赛";
                else if($competition_id[0] == "J")
                    echo "半决赛";
                else if($competition_id[0] == "K")
                    echo "季殿赛";
                else if($competition_id[0] == "L")
                    echo "总决赛";
            ?></h1>
       </div> 
    </body>

</html>

<style>
    body{
        background: url("../images/summary_background.jpg"); no-repeat center center fixed; 
        background-size: cover;
        font-family: "Times New Roman", 
             "Microsoft YaHei", "微软雅黑", 
             STXihei, "华文细黑", 
             serif;
    }
    #title{
        text-align: center;
        margin-top: 4.75%;
    }

    #title h1{
        font-size: 2.5vw;
    }

    #foo{
        position: fixed;
        bottom: 2.2%;
        right: 2%;
    }

    #best{
        bottom: 14.5%;
        left: 36%;
        position:fixed;
        font-size: 2.5vw;
    }

    #logo_pos{
        /* margin-top: 20%;
        margin-left: 34%; */
        position: fixed;
        left: 15%;
        top: 20%;
        width: 17%;
        height: auto;
    }
    #logo_neg{
        /* margin-top: 20%;
        margin-left: 18%; */
        position: fixed;
        left: 70%;
        top: 20%;
        width: 17%;
        height: auto;
    }

    #tab{
        position: fixed;
        top: 30%;
        left: 15%;
        table-layout: fixed
    }

    #tab tr th{
        width: 23vw;
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
   }

   .ticket_name{
       font-size: 2.2vw;
       text-align: center;
       width: 23.8vw;
       /* font-weight: 800; */
   }
</style>