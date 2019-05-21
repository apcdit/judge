<?php
  include('../inc/connect.php');

  $competitionID;

  if(!empty($_POST['competitionID'])){
    $competitionID = $_POST['competitionID'];
    if(strcmp($_POST['submit'], 'Deactivate') == 0){
      foreach($competitionID as $competition){
        $sql = $conn->prepare("UPDATE titles SET available = 0 WHERE competition_id = ?");
        $sql->execute([$competition]);
      }
      echo 'Deactivation successful!';
    }else{
      foreach($competitionID as $competition){
        $sql = $conn->prepare("UPDATE titles SET available = 1 WHERE competition_id = ?");
        $sql->execute([$competition]);
      }
      echo 'Activation successful!';
    }
    header("Location: ../dashboard.php"); 
    
  }else{
    echo 'There are some issues with the server, please try again or contact admin.';
  }

?>
