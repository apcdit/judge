<?php
    
    include('../inc/connect.php');

    $competition_id = $_GET['competition_id'];
    $sql = $conn->prepare("SELECT side,mark_ticket, impression_ticket, total_ticket, zongjie_ticket, tuanti  FROM Competition WHERE competition_id=?");
    $sql->execute([$competition_id]);
    
    $competitions = $sql->fetchAll();

    echo json_encode($competitions);
?>