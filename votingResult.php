<?php
include('header.php'); 

session_start();

if(!isset($_SESSION['userID'])){
    header("Location: login.php");
}
include('/inc/connect.php');
if(!isset($_SESSION['userID'])){
    header("Location: login.php");
}

$competition_id1 = $_SESSION['titleID'];
try {
    
    $stmt = $conn->prepare("SELECT bestParticipant1,bestParticipant2,bestParticipant3 FROM `competition` WHERE competition_id='$competition_id1' and side=0");
    // use exec() because no results are returned
    
    $products = array();
                $count = 0;
                if($stmt->execute()){
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $participant[] = $row;
                    echo $participant[$count]['bestParticipant1']." ".$participant[$count]['bestParticipant2']."  ".$participant[$count]['bestParticipant3']."</br>";
                    array_push($products, $participant[$count]['bestParticipant1'],$participant[$count]['bestParticipant2'],$participant[$count]['bestParticipant3']);
                    $count++;
                }
                }
                //var_dump($products);
                
                $vals = array_count_values($products);// calculate the number of occurerance 
                
                //var_dump($vals);
                $keys = array_keys($vals); // get the key
                
                $max=0;
                $bestParticipant='';
                 for($i=0;$i<count($vals);$i++)
                 {
                    if($vals[$keys[$i]]>$max){
                        $max=$vals[$keys[$i]];
                        $bestParticipant=$keys[$i];
                    }
                 }
                 echo $bestParticipant;

    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
   
    }

?>