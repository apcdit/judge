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

$sql = $conn->prepare("SELECT side, impression_ticket FROM competition WHERE competition_id=?");
$sql->execute([$competition_id]);
$result = $sql->fetchAll(PDO::FETCH_ASSOC);

$impression_pos = $impression_neg = 0;

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

$image_pos = $round['image_path_pos'];
$image_neg = $round['image_path_neg'];
$uni_pos = $round['uni_pos'];
$uni_neg = $round['uni_neg'];
$title_pos = $round['title_pos'];
$title_neg = $round['title_neg'];

?>

<html>
    <head>
        <title>印象票结果</title>
    </head>

    <body>
    <div class="">
        <img id="logo_pos" src="<?php echo $image_pos; ?>" height= 12% width=auto alt="">
        <img id="logo_neg" src="<?php echo $image_neg; ?>" height= 12% width=auto alt="">
        <h3 id="ticket" style="font-weight:900;">印象票</h3>
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
                <tr id="marks">
                    <th><h4><?php impression_decide($result, $impression_pos, $impression_neg); echo $impression_pos; ?></h4></th>
                    <th></th>
                    <th><h4><?php echo $impression_neg; ?></h4></th>
                </tr>
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
        left: 32%;
        top: 43%;
        width: 17%;
        height: auto;
    }
    #logo_neg{
        /* margin-top: 20%;
        margin-left: 18%; */
        position: fixed;
        left: 68%;
        top: 43%;
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