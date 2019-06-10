<?php
  include('../inc/connect.php');


  try{
    if(!empty($_POST['title']) && !empty($_POST['competitionID'])  && !empty($_POST['judgesID']) && $_POST['Submit'] == "Add"){
      $judgesID = array(0,0,0,0,0,0,0,0,0);
      $competitionID = $_POST['competitionID'];
      $title = $_POST['title'];
      $posTitle = $_POST['posTitle'];
      $negTitle = $_POST['negTitle'];
      $posUni = $_POST['posUni'];
      $negUni = $_POST['negUni'];
      
      $i = 0;
      foreach($_POST['judgesID'] as $judgeID){
          $judgesID[$i] = $judgeID;
          $i++;
      }
      // print_r($competitionID);
      $stmt = $conn->prepare("INSERT INTO titles (competition_id, title, available, judge_id_1, judge_id_2, judge_id_3, judge_id_4, judge_id_5, judge_id_6, judge_id_7, judge_id_8, judge_id_9) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->execute([$competitionID, $title, 0, $judgesID[0], $judgesID[1], $judgesID[2], $judgesID[3], $judgesID[4], $judgesID[5], $judgesID[6], $judgesID[7], $judgesID[8]]);
      
      $img = "../images/school logo/";
      $stmt = $conn->prepare("INSERT INTO rounds (competition_id, image_path_pos, image_path_neg, uni_pos, uni_neg, title_pos, title_neg) VALUES (?,?,?,?,?,?,?)");
      $stmt->execute([$competitionID, $img, $img, $posUni, $negUni, $posTitle, $negTitle]);
      
      header("Location: ../dashboard.php"); 
    }else if(!empty($_POST['competitionID']) && $_POST['Submit'] == "Remove"){
      $competitionID = $_POST['competitionID'];
      $a = $conn->prepare("DELETE FROM titles WHERE competition_id =?");
      $b = $conn->prepare("DELETE FROM rounds WHERE competition_id=?");
  
      foreach($competitionID as $competition){
        $a->execute([$competition]);
        $b->execute([$competition]);
      }
  
      header("Location: ../dashboard.php");
    }else{
      echo 'There are some issues with the server, please try again or contact admin.';
      header("Location: ../dashboard.php");
  
    }
  
  }catch(PDOException $e)
  {
    echo $stmt . "<br>" . $e->getMessage();
  }

  
?>
