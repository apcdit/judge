<?php
    include('../inc/connect.php');

    session_start([
    'cookie_lifetime' => 7200,
]);
    
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
    
    $sql = $conn->prepare("SELECT * FROM titles WHERE competition_id =?");

    if($sql->execute([$_SESSION['titleID']])){
        $title = $sql->fetch();
        $_SESSION['title'] = $title['title']; //fetch the title using competition id
    }

    if(isset($_SESSION['userID'])){
        header("Location: ../index.php");
    }else{
        header("Location: ../login.php");
    }
?>