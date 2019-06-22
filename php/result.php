<?php
    
    include('../inc/connect.php');

    $competition_id = $_GET['competition_id'];
    $sql = $conn->prepare("SELECT * FROM competition WHERE competition_id=?");
    $sql->execute([$competition_id]);
    
    $competitions = $sql->fetchAll();

    $judges = array();

    foreach($competitions as $c){
        if(!array_key_exists($c['judge_id'],$judges)){
            $judge_id = $c['judge_id'];
            $s2 = $conn->prepare("SELECT name FROM judges WHERE id=?");
            $s2->execute([$judge_id]);
            $judge_name = $s2->fetch();
            $judges[$judge_id] = $judge_name['name'];
        }
    }

    $impression_mark_total_pos = $impression_mark_total_neg = array();
    foreach($competitions as $c){
        $j_id = $c['judge_id'];
        $side = $c['side'];

        if($side == 0){
            $impression_mark_total_neg[$judges[$j_id]] = $c['total_mark'];
        }else if($side == 1){
            $impression_mark_total_pos[$judges[$j_id]] = $c['total_mark'];
        }
    }
    
       /*
    BEST PARTICIPANT
*/
$sql = $conn->prepare("SELECT bestParticipant1, bestParticipant2, bestParticipant3 FROM competition WHERE competition_id=? and side=0");
$sql->execute([$competition_id]);
$result = $sql->fetchAll(PDO::FETCH_ASSOC);

$occurence = array();
foreach($result as $r){
    foreach($r as $participant){
        if(!empty($participant))
            array_push($occurence, $participant);
    }
}

$count = array_count_values($occurence); //get the ticket count of each voted participant
arsort($count); //sort according to the value

function calResult($num,$count, &$minVote){
    $bestParticipant = array();
    $counter = 0;
    foreach($count as $key => $value){
        if($counter == $num-1){
            $minVote = $value;
        }
        if($value < $minVote){
            break;
        } 
        $bestParticipant[$key] = $value;
        $counter++;
    }
    return $bestParticipant;
}

$minVote = -9999;
$numBest = 3;
$bestParticipant = calResult($numBest, $count, $minVote);

if(count($bestParticipant) > $numBest){
    $min_keys = array_keys($bestParticipant, min($bestParticipant));
    //正方
    $stmt = $conn->prepare("SELECT * FROM competition WHERE competition_id=? and side=1");
    $stmt->execute([$competition_id]);
    $pointsPos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    //反方
    $stmt = $conn->prepare("SELECT * FROM competition WHERE competition_id=? and side=0");
    $stmt->execute([$competition_id]);
    $pointsNeg = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $positive1 = $positive2 = $positive3 = $positive4 = 0;
    $negative1 = $negative2 = $negative3 = $negative4 = 0;

    foreach($min_keys as $key){
        switch($key){
            case "正方一辩":
                foreach($pointsPos as $point){
                    $positive1 = $positive1 + $point['lilun']+$point['zhixun_1']+$point['yuyan_1'];
                }
                break;
            case "正方二辩":
                foreach($pointsPos as $point){
                    $positive2 = $positive2 + $point['bolun'] + $point['gongbian'] + $point['yuyan_2'];
                }
                break;
            case "正方三辩":
                foreach($pointsPos as $point){
                    $positive3 = $positive3 + $point['zhixun_3'] + $point['xiaojie'] + $point['yuyan_3'];
                }
                break;
            case "正方四辩":
                foreach($pointsPos as $point){
                    $positive4 = $positive4 + $point['chenci']+ $point['yuyan_4'];
                }
                break;
            case "反方一辩":
                foreach($pointsNeg as $point){
                    $negative1 = $negative1 + $point['lilun']+$point['zhixun_1']+$point['yuyan_1'];
                }
                break;
            case "反方二辩":
                foreach($pointsNeg as $point){
                    $negative2 = $negative2 + $point['bolun'] + $point['gongbian'] + $point['yuyan_2'];
                }
                break;
            case "反方三辩":
                foreach($pointsNeg as $point){
                    $negative3 = $negative3 + $point['zhixun_3'] + $point['xiaojie'] + $point['yuyan_3'];
                }
                break;
            case "反方四辩":
                foreach($pointsNeg as $point){
                    $negative4 = $negative4 + $point['chenci']+ $point['yuyan_4'];
                }
                break;
        }
    }

    $total_marks = array("正方一辩" => $positive1, "正方二辩" => $positive2, "正方三辩" => $positive3, 
    "正方四辩" => $positive4, "反方一辩" => $negative1, "反方二辩" => $negative2, "反方三辩" => $negative3, "反方四辩" => $negative4);

    foreach($total_marks as $key => $ma){
        if($ma == 0) unset($total_marks[$key]);
    }
    arsort($total_marks);

    $k = 0;
    $current = count($bestParticipant) - count($min_keys);
    $diff = $numBest - $current;
    $best = array();

    foreach($bestParticipant as $key => $p){
        if($p == $minVote){
            unset($bestParticipant[$key]);
        }
    }

    
    //get the top how many and insert
    foreach($total_marks as $key => $mark){
        if($k < $diff){
            $best[$key] = $mark;
            $k++;
        }else
            break;
    }

        foreach($bestParticipant as $key => $q){
            $p = 0;
            switch($key){
                case "正方一辩":
                    foreach($pointsPos as $point){
                        $p = $p + $point['lilun']+$point['zhixun_1']+$point['yuyan_1'];
                    }
                    break;
                case "正方二辩":
                    foreach($pointsPos as $point){
                        $p = $p + $point['bolun'] + $point['gongbian'] + $point['yuyan_2'];
                    }
                    break;
                case "正方三辩":
                    foreach($pointsPos as $point){
                        $p = $p + $point['zhixun_3'] + $point['xiaojie'] + $point['yuyan_3'];
                    }
                    break;
                case "正方四辩":
                    foreach($pointsPos as $point){
                        $p = $p + $point['chenci']+ $point['yuyan_4'];
                    }
                    break;
                case "反方一辩":
                    foreach($pointsNeg as $point){
                        $p = $p + $point['lilun']+$point['zhixun_1']+$point['yuyan_1'];
                    }
                    break;
                case "反方二辩":
                    foreach($pointsNeg as $point){
                        $p = $p + $point['bolun'] + $point['gongbian'] + $point['yuyan_2'];
                    }
                    break;
                case "反方三辩":
                    foreach($pointsNeg as $point){
                        $p = $p + $point['zhixun_3'] + $point['xiaojie'] + $point['yuyan_3'];
                    }
                    break;
                case "反方四辩":
                    foreach($pointsNeg as $point){
                        $p = $p + $point['chenci']+ $point['yuyan_4'];
                    }
                    break;
            }
            $bestParticipant[$key] = array($p, $count[$key]);
        }

        foreach($best as $key => $q){
            $bestParticipant[$key] = array($q,$count[$key]);
        }
}else{
    $stmt = $conn->prepare("SELECT * FROM competition WHERE competition_id=? and side=1");
    $stmt->execute([$competition_id]);
    $pointsPos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    //反方
    $stmt = $conn->prepare("SELECT * FROM competition WHERE competition_id=? and side=0");
    $stmt->execute([$competition_id]);
    $pointsNeg = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach($bestParticipant as $key => $q){
        $p = 0;
        switch($key){
            case "正方一辩":
                foreach($pointsPos as $point){
                    $p = $p + $point['lilun']+$point['zhixun_1']+$point['yuyan_1'];
                }
                break;
            case "正方二辩":
                foreach($pointsPos as $point){
                    $p = $p + $point['bolun'] + $point['gongbian'] + $point['yuyan_2'];
                }
                break;
            case "正方三辩":
                foreach($pointsPos as $point){
                    $p = $p + $point['zhixun_3'] + $point['xiaojie'] + $point['yuyan_3'];
                }
                break;
            case "正方四辩":
                foreach($pointsPos as $point){
                    $p = $p + $point['chenci']+ $point['yuyan_4'];
                }
                break;
            case "反方一辩":
                foreach($pointsNeg as $point){
                    $p = $p + $point['lilun']+$point['zhixun_1']+$point['yuyan_1'];
                }
                break;
            case "反方二辩":
                foreach($pointsNeg as $point){
                    $p = $p + $point['bolun'] + $point['gongbian'] + $point['yuyan_2'];
                }
                break;
            case "反方三辩":
                foreach($pointsNeg as $point){
                    $p = $p + $point['zhixun_3'] + $point['xiaojie'] + $point['yuyan_3'];
                }
                break;
            case "反方四辩":
                foreach($pointsNeg as $point){
                    $p = $p + $point['chenci']+ $point['yuyan_4'];
                }
                break;
        }
        $bestParticipant[$key] = array($p, $count[$key]);
    }
}
        $top3 = $bestParticipant;
        
//                /*
//     BEST PARTICIPANT
// */
// $sql = $conn->prepare("SELECT bestParticipant1, bestParticipant2, bestParticipant3 FROM competition WHERE competition_id=? and side=0");
// $sql->execute([$competition_id]);
// $result = $sql->fetchAll(PDO::FETCH_ASSOC);

// $occurence = array();
// foreach($result as $r){
//     foreach($r as $participant){
//         if(!empty($participant))
//             array_push($occurence, $participant);
//     }
// }

// $count = array_count_values($occurence); //get the ticket count of each voted participant
// arsort($count); //sort according to the value

// $minVote = -9999;
// $numBest = 1;
// $bestParticipant = calResult($numBest, $count, $minVote);

// // if(count($bestParticipant) > $numBest){
//     $min_keys = array_keys($bestParticipant, min($bestParticipant));
//     //正方
//     $stmt = $conn->prepare("SELECT * FROM competition WHERE competition_id=? and side=1");
//     $stmt->execute([$competition_id]);
//     $pointsPos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
//     //反方
//     $stmt = $conn->prepare("SELECT * FROM competition WHERE competition_id=? and side=0");
//     $stmt->execute([$competition_id]);
//     $pointsNeg = $stmt->fetchAll(PDO::FETCH_ASSOC);

//     $positive1 = $positive2 = $positive3 = $positive4 = 0;
//     $negative1 = $negative2 = $negative3 = $negative4 = 0;

//     foreach($min_keys as $key){
//         switch($key){
//             case "正方一辩":
//                 foreach($pointsPos as $point){
//                     $positive1 = $positive1 + $point['lilun']+$point['zhixun_1']+$point['yuyan_1'];
//                 }
//                 break;
//             case "正方二辩":
//                 foreach($pointsPos as $point){
//                     $positive2 = $positive2 + $point['bolun'] + $point['gongbian'] + $point['yuyan_2'];
//                 }
//                 break;
//             case "正方三辩":
//                 foreach($pointsPos as $point){
//                     $positive3 = $positive3 + $point['zhixun_3'] + $point['xiaojie'] + $point['yuyan_3'];
//                 }
//                 break;
//             case "正方四辩":
//                 foreach($pointsPos as $point){
//                     $positive4 = $positive4 + $point['chenci']+ $point['yuyan_4'];
//                 }
//                 break;
//             case "反方一辩":
//                 foreach($pointsNeg as $point){
//                     $negative1 = $negative1 + $point['lilun']+$point['zhixun_1']+$point['yuyan_1'];
//                 }
//                 break;
//             case "反方二辩":
//                 foreach($pointsNeg as $point){
//                     $negative2 = $negative2 + $point['bolun'] + $point['gongbian'] + $point['yuyan_2'];
//                 }
//                 break;
//             case "反方三辩":
//                 foreach($pointsNeg as $point){
//                     $negative3 = $negative3 + $point['zhixun_3'] + $point['xiaojie'] + $point['yuyan_3'];
//                 }
//                 break;
//             case "反方四辩":
//                 foreach($pointsNeg as $point){
//                     $negative4 = $negative4 + $point['chenci']+ $point['yuyan_4'];
//                 }
//                 break;
//         }
//     }

//     $total_marks = array("正方一辩" => $positive1, "正方二辩" => $positive2, "正方三辩" => $positive3, 
//     "正方四辩" => $positive4, "反方一辩" => $negative1, "反方二辩" => $negative2, "反方三辩" => $negative3, "反方四辩" => $negative4);

//     foreach($total_marks as $key => $ma){
//         if($ma == 0) unset($total_marks[$key]);
//     }
//     arsort($total_marks);

//     $k = 0;
//     $current = count($bestParticipant) - count($min_keys);
//     $diff = $numBest - $current;
//     $best = array();

//     foreach($bestParticipant as $key => $p){
//         if($p == $minVote){
//             unset($bestParticipant[$key]);
//         }
//     }

    
//     //get the top how many and insert
//     foreach($total_marks as $key => $mark){
//         if($k < $diff){
//             $best[$key] = $mark;
//             $k++;
//         }else
//             break;
//     }

//         foreach($bestParticipant as $key => $q){
//             $p = 0;
//             switch($key){
//                 case "正方一辩":
//                     foreach($pointsPos as $point){
//                         $p = $p + $point['lilun']+$point['zhixun_1']+$point['yuyan_1'];
//                     }
//                     break;
//                 case "正方二辩":
//                     foreach($pointsPos as $point){
//                         $p = $p + $point['bolun'] + $point['gongbian'] + $point['yuyan_2'];
//                     }
//                     break;
//                 case "正方三辩":
//                     foreach($pointsPos as $point){
//                         $p = $p + $point['zhixun_3'] + $point['xiaojie'] + $point['yuyan_3'];
//                     }
//                     break;
//                 case "正方四辩":
//                     foreach($pointsPos as $point){
//                         $p = $p + $point['chenci']+ $point['yuyan_4'];
//                     }
//                     break;
//                 case "反方一辩":
//                     foreach($pointsNeg as $point){
//                         $p = $p + $point['lilun']+$point['zhixun_1']+$point['yuyan_1'];
//                     }
//                     break;
//                 case "反方二辩":
//                     foreach($pointsNeg as $point){
//                         $p = $p + $point['bolun'] + $point['gongbian'] + $point['yuyan_2'];
//                     }
//                     break;
//                 case "反方三辩":
//                     foreach($pointsNeg as $point){
//                         $p = $p + $point['zhixun_3'] + $point['xiaojie'] + $point['yuyan_3'];
//                     }
//                     break;
//                 case "反方四辩":
//                     foreach($pointsNeg as $point){
//                         $p = $p + $point['chenci']+ $point['yuyan_4'];
//                     }
//                     break;
//             }
//             $bestParticipant[$key] = array($p, $count[$key]);
//         }

//         foreach($best as $key => $q){
//             $bestParticipant[$key] = array($q,$count[$key]);
//         };
    $sql = $conn->prepare("SELECT bestParticipant FROM competition WHERE competition_id=? and side=0");
    $sql->execute([$competition_id]);
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(array($competitions,$top3,$judges,$result,$impression_mark_total_pos,$impression_mark_total_neg));
?>