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
      
      switch($posUni){
        case "新加坡国立大学":
              $img_pos_name = "01 新加坡国立大学.png";
              break;
        case "山东大学":
              $img_pos_name = "02 山东大学.png";
              break;
        case "UCSI大学":
          $img_pos_name = "03 UCSI 大学.png";
              break;
        case "昆士兰大学":
          $img_pos_name = "04 昆士兰大学.png";
              break;
        case "南京大学":
          $img_pos_name = "05 南京大学.png";
              break;
        case "多伦多大学":
          $img_pos_name = "06 多伦多大学.png";
              break;
        case "澳大利亚国立大学":
          $img_pos_name = "07 澳大利亚国立大学.png";
              break;
        case "上海交通大学":
          $img_pos_name = "08 上海交通大学.png";
              break;
        case "马来西亚北方大学":
          $img_pos_name = "09 马来西亚北方大学.png";
              break;
        case "东吴大学":
          $img_pos_name = "10 东吴大学.png";
              break;
        case "深圳大学":
          $img_pos_name = "11 深圳大学.png";
              break;
        case "马来西亚国立大学":
          $img_pos_name = "12 马来西亚国立大学.png";
              break;
        case "中国政法大学":
          $img_pos_name = "13 中国政法大学.png";
              break;
        case "马来西亚理科大学总院校":
          $img_pos_name = "14 马来西亚理科大学（总院校).png";
              break;
        case "香港浸会大学":
          $img_pos_name = "15 香港浸会大学.png";
              break;
        case "香港科技大学":
          $img_pos_name = "16 香港科技大学.png";
              break;
        case "上海交通大学医学院":
          $img_pos_name = "17 上海交通大学医学院.png";
              break;
        case "新加坡南洋理工大学":
          $img_pos_name = "18 新加坡南洋理工大学.png";
              break;
        case "中国人民大学":
          $img_pos_name = "19 中国人民大学.png";
              break;
        case "新南威尔士大学":
          $img_pos_name = "20 新南威尔士大学.png";
              break;
        case "香港中文大学":
          $img_pos_name = "21 香港中文大学.png";
              break;
        case "世新大学":
          $img_pos_name = "22 世新大学.png";
              break;
        case "西南财经大学":
          $img_pos_name = "23 西南财经大学.png";
              break;
        case "澳门科技大学":
          $img_pos_name = "24 澳门科技大学.png";
              break;
        default:
          $img_pos_name = "";
            break;
      }

      switch($negUni){
        case "新加坡国立大学":
              $img_neg_name = "01 新加坡国立大学.png";
              break;
        case "山东大学":
              $img_neg_name = "02 山东大学.png";
              break;
        case "UCSI大学":
          $img_neg_name = "03 UCSI 大学.png";
              break;
        case "昆士兰大学":
          $img_neg_name = "04 昆士兰大学.png";
              break;
        case "南京大学":
          $img_neg_name = "05 南京大学.png";
              break;
        case "多伦多大学":
          $img_neg_name = "06 多伦多大学.png";
              break;
        case "澳大利亚国立大学":
          $img_neg_name = "07 澳大利亚国立大学.png";
              break;
        case "上海交通大学":
          $img_neg_name = "08 上海交通大学.png";
              break;
        case "马来西亚北方大学":
          $img_neg_name = "09 马来西亚北方大学.png";
              break;
        case "东吴大学":
          $img_neg_name = "10 东吴大学.png";
              break;
        case "深圳大学":
          $img_neg_name = "11 深圳大学.png";
              break;
        case "马来西亚国立大学":
          $img_neg_name = "12 马来西亚国立大学.png";
              break;
        case "中国政法大学":
          $img_neg_name = "13 中国政法大学.png";
              break;
        case "马来西亚理科大学总院校":
          $img_neg_name = "14 马来西亚理科大学（总院校).png";
              break;
        case "香港浸会大学":
          $img_neg_name = "15 香港浸会大学.png";
              break;
        case "香港科技大学":
          $img_neg_name = "16 香港科技大学.png";
              break;
        case "上海交通大学医学院":
          $img_neg_name = "17 上海交通大学医学院.png";
              break;
        case "新加坡南洋理工大学":
          $img_neg_name = "18 新加坡南洋理工大学.png";
              break;
        case "中国人民大学":
          $img_neg_name = "19 中国人民大学.png";
              break;
        case "新南威尔士大学":
          $img_neg_name = "20 新南威尔士大学.png";
              break;
        case "香港中文大学":
          $img_neg_name = "21 香港中文大学.png";
              break;
        case "世新大学":
          $img_neg_name = "22 世新大学.png";
              break;
        case "西南财经大学":
          $img_neg_name = "23 西南财经大学.png";
              break;
        case "澳门科技大学":
          $img_neg_name = "24 澳门科技大学.png";
              break;
        default:
          $img_neg_name = "";
            break;
      }

      $ppp = "../images/school logo/02 山东大学.png";

      $img_pos = "../images/school logo/".$img_pos_name;
      $img_neg = "../images/school logo/".$img_neg_name;
      $stmt = $conn->prepare("INSERT INTO rounds (competition_id, image_path_pos, image_path_neg, uni_pos, uni_neg, title_pos, title_neg) VALUES (?,?,?,?,?,?,?)");
      $stmt->execute([$competitionID, $img_pos, $img_neg, $posUni, $negUni, $posTitle, $negTitle]);
      
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
