<?php
include('header.php'); 

session_start();
include('inc/connect.php');
if(!isset($_SESSION['userID'])){
    header("Location: login.php");
}
$competition_id1 = $_SESSION['titleID'];
$userID= $_SESSION['userID'] ;
try {
    
    $stmt = $conn->prepare("SELECT bestParticipant1,bestParticipant2,bestParticipant3 FROM `competition` WHERE judge_id='$userID' and competition_id='$competition_id1' and side=0");
    // use exec() because no results are returned
    $products = array();
    if($stmt->execute()){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $participant[] = $row;
        }
    }
catch(PDOException $e)
    {
    echo $stmt . "<br>" . $e->getMessage();
    }

?>
<body>
<?php 
        include('navigation.php');
?>
<div class="container">
<form method="POST" action="php/bestparticipantHandler.php">
        <h3>最佳辩手1</h3>
        <select name="participant1" id="participant1" class="form-control group"
        <?php
                if(
                        $participant[0]['bestParticipant1']!='0' &&
                        $participant[0]['bestParticipant2']!='0' &&
                        $participant[0]['bestParticipant3']!='0')
                        {
                            echo "disabled" ;
                        }
                        
                ?>
        >
            <option value="">
                <?php
                if(
                        $participant[0]['bestParticipant1']!='0' &&
                        $participant[0]['bestParticipant2']!='0' &&
                        $participant[0]['bestParticipant3']!='0')
                        {
                            echo $participant[0]['bestParticipant1'] ;
                        }
                        else{echo "- 选择姓名 -" ;}
                ?>
            </option>
                <?php
               
                if(
                    $participant[0]['bestParticipant1']=='0' &&
                    $participant[0]['bestParticipant2']=='0' &&
                    $participant[0]['bestParticipant3']=='0')
                    {
                
                    $sql = $conn->prepare("SELECT name_cn,uni FROM participants WHERE round1='".$_SESSION['titleID']."'  or round1_2='".$_SESSION['titleID']."'");

                    $products = array();
                    $count = 0;
                        if($sql->execute())
                        {
                            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                                $participant[] = $row;
                                echo "<option value='".$participant[$count]['name_cn']."' >".$participant[$count]['name_cn']."  ".$participant[$count]['uni']."</option>";
                                $count++;
                                }
                        }
                    }
                    
                ?>
        </select>
        <br>
<h3>最佳辩手2</h3>
<select name="participant2" id="participant2" class="form-control group"
        <?php
            if(
                    $participant[0]['bestParticipant1']!='0' &&
                    $participant[0]['bestParticipant2']!='0' &&
                    $participant[0]['bestParticipant3']!='0')
                    {
                        echo "disabled" ;
                    }
                
        ?>
>

<option value="">
                <?php
                if(
                        $participant[0]['bestParticipant1']!='0' &&
                        $participant[0]['bestParticipant2']!='0' &&
                        $participant[0]['bestParticipant3']!='0')
                        {
                            echo $participant[0]['bestParticipant2'] ;
                        }
                        else{echo "- 选择姓名 -" ;}
                ?>
            </option>
                <?php
               
                if(
                    $participant[0]['bestParticipant1']=='0' &&
                    $participant[0]['bestParticipant2']=='0' &&
                    $participant[0]['bestParticipant3']=='0')
                    {
                
                    $sql = $conn->prepare("SELECT name_cn,uni FROM participants WHERE round1='".$_SESSION['titleID']."'  or round1_2='".$_SESSION['titleID']."'");

                    $products = array();
                    $count = 0;
                        if($sql->execute())
                        {
                            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                                $participant[] = $row;
                                echo "<option value='".$participant[$count]['name_cn']."' >".$participant[$count]['name_cn']."  ".$participant[$count]['uni']."</option>";
                                $count++;
                                }
                        }
                    }
                    
                ?>
</select>
<br>
<h3>最佳辩手3</h3>
<select name="participant3" id="participant3" class="form-control group"
    <?php
                    if(
                            $participant[0]['bestParticipant1']!='0' &&
                            $participant[0]['bestParticipant2']!='0' &&
                            $participant[0]['bestParticipant3']!='0')
                            {
                                echo "disabled" ;
                            }
                            
    ?>
>
<option value="">
                <?php
                if(
                        $participant[0]['bestParticipant1']!='0' &&
                        $participant[0]['bestParticipant2']!='0' &&
                        $participant[0]['bestParticipant3']!='0')
                        {
                            echo $participant[0]['bestParticipant3'] ;
                        }
                        else{echo "- 选择姓名 -" ;}
                ?>
            </option>
                <?php
               
                if(
                    $participant[0]['bestParticipant1']=='0' &&
                    $participant[0]['bestParticipant2']=='0' &&
                    $participant[0]['bestParticipant3']=='0')
                    {
                
                    $sql = $conn->prepare("SELECT name_cn,uni FROM participants WHERE round1='".$_SESSION['titleID']."'  or round1_2='".$_SESSION['titleID']."'");

                    $products = array();
                    $count = 0;
                        if($sql->execute())
                        {
                            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                                $participant[] = $row;
                                echo "<option value='".$participant[$count]['name_cn']."' >".$participant[$count]['name_cn']."  ".$participant[$count]['uni']."</option>";
                                $count++;
                                }
                        }
                    }
                    
                ?>
</select>
<button class="btn btn-primary btn-block btn-login" type="submit"
<?php
                if(
                        $participant[0]['bestParticipant1']!='0' &&
                        $participant[0]['bestParticipant2']!='0' &&
                        $participant[0]['bestParticipant3']!='0')
                        {
                            echo "style='display:none'" ;
                        }
                        
                ?>
>提交</button>
</form>
</div>

</body>