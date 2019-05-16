<?php
    include('../inc/connect.php');
    
    $stmt = $conn->prepare("SELECT * FROM titles WHERE available = 1");

    if($stmt->execute()){
        echo json_encode($stmt->fetchAll());
    }else{
        echo json_encode(['']);
    }
    
?>