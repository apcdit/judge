<?php
    include('../inc/connect.php');

    session_start();
    
    $stmt = $conn->prepare("SELECT * FROM judges WHERE id=? and password=?");
    $stmt->execute([$_POST['judge'], $_POST['password']]);
    $judge = $stmt->fetchAll();

    if(count($judge) != 1){
        header("Location: ../login.php");
        exit;
    }
    
    $_SESSION['userID'] = $_POST['judge']; //store the user id
    $_SESSION['titleID'] = $_POST['title']; //store the title id aka competition id in db
    $_SESSION['judge_name'] = $judge[0]['name'];
    
    setcookie("userID", $_POST['judge'], time()+14400,'/');
    setcookie("titleID", $_POST['title'], time()+14400, '/');
    setcookie("judge_name", $judge[0]['name'], time()+14400, '/');

    $sql = $conn->prepare("SELECT * FROM titles WHERE competition_id =?");

    if($sql->execute([$_SESSION['titleID']])){
        $title = $sql->fetch();
        $_SESSION['title'] = $title['title']; //fetch the title using competition id
        setcookie("title", $title['title'], time()+14400, '/');

    }

    if(isset($_SESSION['userID']) || isset($_COOKIE['userID'])){
        header("Location: ../index.php");
    }else{
        header("Location: ../login.php");
    }
?>