<?php
  include('../inc/connect.php');


  if(!empty($_POST['title']) && !empty($_POST['competitionID'])  && !empty($_POST['judgesID']) && $_POST['Submit'] == "Add"){
    $judgesID = array(0,0,0,0,0,0,0,0,0);
    $competitionID = $_POST['competitionID'];
    $title = $_POST['title'];
    $i = 0;
    foreach($_POST['judgesID'] as $judgeID){
        $judgesID[$i] = $judgeID;
        $i++;
    }
    // print_r($competitionID);
    $stmt = $conn->prepare("INSERT INTO titles (competition_id, title, available, judge_id_1, judge_id_2, judge_id_3, judge_id_4, judge_id_5, judge_id_6, judge_id_7, judge_id_8, judge_id_9) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$competitionID, $title, 0, $judgesID[0], $judgesID[1], $judgesID[2], $judgesID[3], $judgesID[4], $judgesID[5], $judgesID[6], $judgesID[7], $judgesID[8]]);
    header("Location: ../dashboard.php"); 
    
  }else if(!empty($_POST['competitionID']) && $_POST['Submit'] == "Remove"){
    $competitionID = $_POST['competitionID'];
    foreach($competitionID as $competition){
      $sql = $conn->prepare("DELETE FROM titles WHERE competition_id =?");
      $sql->execute([$competition]);
    }

    header("Location: ../dashboard.php");
  }else{
    echo 'There are some issues with the server, please try again or contact admin.';
    header("Location: ../dashboard.php");

  }

?>
