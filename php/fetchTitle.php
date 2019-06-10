<?php
    include('../inc/connect.php');
    
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM titles WHERE (judge_id_1=? OR judge_id_2=? OR judge_id_3=? OR judge_id_4=? 
    OR judge_id_5=? OR judge_id_6=? OR judge_id_7=? OR judge_id_8=? OR judge_id_9=?) AND available = 1");
    $result = array();
    $stmt->execute([$id,$id,$id,$id,$id,$id,$id,$id,$id]);
    $result[0] = $stmt->fetchAll();
    $result[1] = array();
    foreach($result[0] as $r){
        $id = $r['competition_id'];
        $sql = $conn->prepare("SELECT uni_pos, uni_neg FROM rounds WHERE competition_id=?");
        $sql->execute([$id]);
        $result[1][$id] = $sql->fetch();
    }
    if(1){
        echo json_encode($result);
    }else{
        echo json_encode(['']);
    }
    
?>