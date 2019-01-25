<?php
    include('../inc/connect.php');

    session_start();

    $_SESSION['userID'] = $_POST['judge']; //store the user id
    $_SESSION['titleID'] = $_POST['title']; //store the title id aka competition id in db

    $sql = $conn->prepare("SELECT * FROM titles WHERE competition_id =?");
    
    if($sql->execute([$_SESSION['titleID']])){
        $title = $sql->fetch();
        $_SESSION['title'] = $title['title']; //fetch the title using competition id
    }

    if(isset($_SESSION['userID'])){
        header("Location: ../index.php");
    }else{
        header("Location: login.php");
    }
?>