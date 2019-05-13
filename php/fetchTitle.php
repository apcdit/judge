<?php
    include('../inc/connect.php');
    
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM titles WHERE (judge_id_1=? OR judge_id_2=? OR judge_id_3=? OR judge_id_4=? 
    OR judge_id_5=? OR judge_id_6=? OR judge_id_7=? OR judge_id_8=? OR judge_id_9=?) AND available = 1");

    if($stmt->execute([$id,$id,$id,$id,$id,$id,$id,$id,$id])){
        echo json_encode($stmt->fetchAll());
    }else{
        echo json_encode(['']);
    }
    
?>