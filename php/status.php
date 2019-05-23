<?php   
    include('../inc/connect.php');

    $competition_id = $_GET['competition_id'];
    $sql = $conn->prepare("SELECT judge_id_1, judge_id_2, judge_id_3, judge_id_4, judge_id_5, judge_id_6, judge_id_7, judge_id_8, judge_id_9  FROM titles WHERE competition_id=?");
    $sql->execute([$competition_id]);
    $judgeIDs = $sql->fetch(PDO::FETCH_ASSOC);

    $sql = $conn->prepare("SELECT title FROM titles WHERE competition_id=?");
    $sql->execute([$competition_id]);
    $title = $sql->fetch(PDO::FETCH_ASSOC);

    $judgeName = array();
    $problematicJudge = array();
    $numJudges = 0;
    foreach($judgeIDs as $judge){
        if($judge > 0){
            $sql = $conn->prepare("SELECT name FROM judges WHERE id=?");
            $sql->execute([$judge]);
            $name = $sql->fetch(PDO::FETCH_ASSOC);
            $judgeName[$judge] = $name;
            $sql = $conn->prepare("SELECT side FROM competition WHERE competition_id =? and judge_id=?");
            $sql->execute([$competition_id, $judge]);
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            if(count($result) == 2) $numJudges++;
            else array_push($problematicJudge, $judge);
        }
    }
    
    /*
        $problematicJudge => stores the IDs of judges that may not have submitted correctly.
        $numJudges => stores the count of good judges
        $judgeName => stores the name of the judges
    */
    echo json_encode(array('title' => $title,'names' => $judgeName, 'problematic' => $problematicJudge));

    // echo json_encode($judgeName);
?>