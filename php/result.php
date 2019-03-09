<?php
    
    include('../inc/connect.php');
    include('../inc/config.php');

    $competition_id = $_POST['competition_id'];
    $sql = $conn->prepare("SELECT * FROM Competition WHERE competition_id=?");
    $sql->execute([$competition_id]);
    
    $competitions = $sql->fetchAll();

    return json_encode($competitions);
?>