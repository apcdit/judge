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
$sql = $conn->prepare("SELECT bestParticipant FROM competition WHERE competition_id=? and side=0");
$sql->execute([$competition_id]);
$result = $sql->fetchAll(PDO::FETCH_ASSOC);

// print_r($result[0]['bestParticipant']);

// }
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
                        echo '<tr id="marks">';
                        echo '<th></th>';
                        echo '<th><h4>'.$result[0]['bestParticipant'].'</h4></th>';
                        echo '<th></th>';
                        echo '</tr>';
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
   }
</style>