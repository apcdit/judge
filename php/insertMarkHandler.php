<?php

 session_start();
 
 
include('../header.php'); 

include('../inc/connect.php');



$competition_id = $_COOKIE['titleID'];
// if(isset($competition_id)){echo "hey";}
$side_pos =1;
$judge_id = $_COOKIE['userID'] ;
$lilun_pos = $_REQUEST["lilun_pos"];
$zhixun_pos_1 = $_REQUEST["zhixun_pos_1"];
$yuyan_pos_1 = $_REQUEST["yuyan_pos_1"];
$ziyou_pos_1 = $_REQUEST["ziyou_pos_1"];
$bolun_pos = $_REQUEST["bolun_pos"];
$gongbian_pos = $_REQUEST["gongbian_pos"];
$yuyan_pos_2 = $_REQUEST["yuyan_pos_2"];
$ziyou_pos_2 = $_REQUEST["ziyou_pos_2"];
$zhixun_pos_2 = $_REQUEST["zhixun_pos_2"];
$xiaojie_pos = $_REQUEST["xiaojie_pos"];
$yuyan_pos_3 = $_REQUEST["yuyan_pos_3"];
$ziyou_pos_3 = $_REQUEST["ziyou_pos_3"];
$chenci_pos = $_REQUEST["chenci_pos"];
$yuyan_pos_4 = $_REQUEST["yuyan_pos_4"];
$ziyou_pos_4 = $_REQUEST["ziyou_pos_4"];
$tuanti_pos = $_REQUEST["tuanti_pos"];
$total_ziyou_pos=$ziyou_pos_1+$ziyou_pos_2+$ziyou_pos_3+$ziyou_pos_4;
$marks_pos_1 =$lilun_pos+ $zhixun_pos_1+$yuyan_pos_1+$ziyou_pos_1+$bolun_pos+$gongbian_pos
+$yuyan_pos_2+$ziyou_pos_2+$zhixun_pos_2+$xiaojie_pos+$yuyan_pos_3+$ziyou_pos_3+$chenci_pos+$yuyan_pos_4
+$ziyou_pos_4+$tuanti_pos;

$side_neg =0;
$lilun_neg = $_REQUEST["lilun_neg"];
$zhixun_neg_1 = $_REQUEST["zhixun_neg_1"];
$yuyan_neg_1 = $_REQUEST["yuyan_neg_1"];
$ziyou_neg_1 = $_REQUEST["ziyou_neg_1"];
$bolun_neg = $_REQUEST["bolun_neg"];
$gongbian_neg = $_REQUEST["gongbian_neg"];
$yuyan_neg_2 = $_REQUEST["yuyan_neg_2"];
$ziyou_neg_2 = $_REQUEST["ziyou_neg_2"];
$zhixun_neg_2 = $_REQUEST["zhixun_neg_2"];
$xiaojie_neg = $_REQUEST["xiaojie_neg"];
$yuyan_neg_3 = $_REQUEST["yuyan_neg_3"];
$ziyou_neg_3 = $_REQUEST["ziyou_neg_3"];
$chenci_neg = $_REQUEST["chenci_neg"];
$yuyan_neg_4 = $_REQUEST["yuyan_neg_4"];
$ziyou_neg_4 = $_REQUEST["ziyou_neg_4"];
$tuanti_neg = $_REQUEST["tuanti_neg"];
$total_ziyou_neg=$ziyou_neg_1+$ziyou_neg_2+$ziyou_neg_3+$ziyou_neg_4;
$marks_neg_1 = $lilun_neg+ $zhixun_neg_1+$yuyan_neg_1+$ziyou_neg_1+$bolun_neg+$gongbian_neg
+$yuyan_neg_2+$ziyou_neg_2+$zhixun_neg_2+$xiaojie_neg+$yuyan_neg_3+$ziyou_neg_3+$chenci_neg
+$yuyan_neg_4+$ziyou_neg_4+$tuanti_neg;

if($marks_pos_1==0 or $marks_neg_1==0){
    header('Location:../index.php');
    exit;
}
else{

$fen_shu_ticket_pos=0;
$fen_shu_ticket_neg=0;
//rules of fenshu system-------------------------------------------------------------------
if($marks_pos_1>$marks_neg_1)
{
    $fen_shu_ticket_pos=$fen_shu_ticket_pos+1;
}
else if($marks_pos_1<$marks_neg_1)
{
    $fen_shu_ticket_neg=$fen_shu_ticket_neg+1;
}
else if($marks_pos_1==$marks_neg_1)
{
            if(($tuanti_pos+$total_ziyou_pos)>($tuanti_neg+$total_ziyou_neg)){
                $fen_shu_ticket_pos=$fen_shu_ticket_pos+1;
            }
            else if(($tuanti_pos+$total_ziyou_pos)<($tuanti_neg+$total_ziyou_neg)){
                $fen_shu_ticket_neg=$fen_shu_ticket_neg+1;
            }
            else if(($tuanti_pos+$total_ziyou_pos)==($tuanti_neg+$total_ziyou_neg)){

                    if($tuanti_pos>$tuanti_neg){
                        $fen_shu_ticket_pos=$fen_shu_ticket_pos+1;
                    }
                    else if($tuanti_pos<$tuanti_neg){
                        $fen_shu_ticket_neg=$fen_shu_ticket_neg+1;
                    }

            }
}

try {
    $stmt = $conn->prepare("SELECT * FROM competition WHERE competition_id=? AND judge_id=? "); 
    $stmt->execute([$_COOKIE['titleID'], $_COOKIE['userID']]);
          
    
    // // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    // //  var_dump($stmt->fetchAll());
    $data=$stmt->fetchAll();
    if(sizeof($data)>1){
        header('Location:../mark2.php');
    // exit;
        exit();
    }
    else{
        try {
            echo "positive";
    
            $sql = $conn->prepare("INSERT INTO competition (competition_id,side, judge_id,lilun,zhixun_1,
            yuyan_1,ziyou_1,bolun,gongbian,yuyan_2,ziyou_2,zhixun_3,xiaojie,yuyan_3,
            ziyou_3,chenci,yuyan_4,ziyou_4,tuanti ,total_mark,mark_ticket)
            VALUES (?,?,?,?, ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $sql->execute([$competition_id, $side_pos,$judge_id,$lilun_pos,
            $zhixun_pos_1,$yuyan_pos_1,$ziyou_pos_1,$bolun_pos,
            $gongbian_pos,$yuyan_pos_2,$ziyou_pos_2,$zhixun_pos_2,
            $xiaojie_pos,$yuyan_pos_3,$ziyou_pos_3,$chenci_pos,
            $yuyan_pos_4,$ziyou_pos_4 ,$tuanti_pos,$marks_pos_1,$fen_shu_ticket_pos]);
            // use exec() because no results are returned
           
            // echo "New record created successfully";
            // header("Location: ../mark2.php");
            }
        catch(PDOException $e)
            {
            echo $sql . "<br>" . $e->getMessage();
            }
        
        try {
            echo "negative";
        
            $sql =$conn->prepare( "INSERT INTO competition (competition_id,side, judge_id,lilun,zhixun_1,
            yuyan_1,ziyou_1,bolun,gongbian,yuyan_2,ziyou_2,zhixun_3,xiaojie,yuyan_3
            ,	ziyou_3,chenci,yuyan_4,ziyou_4,	tuanti,total_mark,mark_ticket)
            VALUES (?,?,?,?, ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            // use exec() because no results are returned
            $sql->execute([$competition_id,$side_neg , $judge_id  ,$lilun_neg,$zhixun_neg_1,$yuyan_neg_1,$ziyou_neg_1,
            $bolun_neg,$gongbian_neg,$yuyan_neg_2,$ziyou_neg_2,$zhixun_neg_2,$xiaojie_neg,$yuyan_neg_3,$ziyou_neg_3,
            $chenci_neg,$yuyan_neg_4,$ziyou_neg_4 ,$tuanti_neg,$marks_neg_1,$fen_shu_ticket_neg]);
            echo "New record created successfully";
            header('Location:../mark2.php');
            exit;
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
           
           
}
 

    


?>
