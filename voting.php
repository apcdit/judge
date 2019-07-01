<?php
include('header.php'); 

session_start([
    'cookie_lifetime' => 7200,
]);
include('inc/connect.php');
if(!isset($_SESSION['userID'])){
    header("Location: login.php");
}
$competition_id1 = $_SESSION['titleID'];
$userID= $_SESSION['userID'] ;
try {

    //----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    $stmt123 = $conn->prepare("SELECT impression_ticket FROM competition WHERE competition_id=? AND judge_id=? and side=0"); 
    $stmt123->execute([$_SESSION['titleID'], $_SESSION['userID']]);
          
    
    // // set the resulting array to associative
    $result = $stmt123->setFetchMode(PDO::FETCH_ASSOC);
    // //  var_dump($stmt->fetchAll());
    $data=$stmt123->fetchAll();
    if(sizeof($data)<1){
        header('Location:index.php');
    }
    //-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    $result=[];
    $check_status = $conn->prepare("SELECT  total_mark FROM `competition` WHERE judge_id='$userID' and competition_id='$competition_id1'");
    if($check_status->execute()){
        while($result_row = $check_status->fetch(PDO::FETCH_ASSOC)){
            
            // var_dump($result_row);
            array_push($result,$result_row['total_mark']);
            if(($result[0]==0)&&($result[1]==0))
            {
                header("Location:mark2.php");
            }
        }
        // var_dump($result);

    }
    // var_dump($result);

    //-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
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
<?php include('navigation.php');?>
<div class="container">
<form method="POST" action="php/bestparticipantHandler.php" onsubmit="return validateForm()"> 
        <h3>侯选人1<span style="color:red;">*</span></h3>
        <select name="participant1" id="participant1" class="form-control group"  onchange="myFunction1()" required 
        <?php
            if($participant[0]['bestParticipant1']!='0' && $participant[0]['bestParticipant2']!='0' && $participant[0]['bestParticipant3']!='0')
                echo "disabled" ; 
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
                
                    // $sql = $conn->prepare("SELECT name_cn,uni FROM participants WHERE round1='".$_SESSION['titleID']."'  or round1_2='".$_SESSION['titleID']."'");

                    // $products = array();
                    // $count = 0;
                    //     if($sql->execute())
                    //     {
                    //         while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                    //             $participant[] = $row;
                    //             print_r($participant);
                    //             echo "<option value='".$participant[$count]['name_cn']."' >".$participant[$count]['name_cn']."  ".$participant[$count]['uni']."</option>";
                    //             $count++;
                    //             }
                    //     }
                     echo "<option value='正方一辩'>正方一辩</option>";
                     echo "<option value='正方二辩'>正方二辩</option>";
                     echo "<option value='正方三辩'>正方三辩</option>";
                     echo "<option value='正方四辩'>正方四辩</option>";
                     echo "<option value='反方一辩'>反方一辩</option>";
                     echo "<option value='反方二辩'>反方二辩</option>";
                     echo "<option value='反方三辩'>反方三辩</option>";
                     echo "<option value='反方四辩'>反方四辩</option>";

                    }
                    
                ?>
        </select>
        <br>
<h3>侯选人2<span style="color:red;">*</span></h3>
<select name="participant2" id="participant2" class="form-control group" required onchange="myFunction2()"
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
                
                    // $sql = $conn->prepare("SELECT name_cn,uni FROM participants WHERE round1='".$_SESSION['titleID']."'  or round1_2='".$_SESSION['titleID']."'");

                    // $products = array();
                    // $count = 0;
                    //     if($sql->execute())
                    //     {
                    //         while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                    //             $participant[] = $row;
                    //             echo "<option value='".$participant[$count]['name_cn']."' >".$participant[$count]['name_cn']."  ".$participant[$count]['uni']."</option>";
                    //             $count++;
                    //             }
                    //     }
                    echo "<option value='正方一辩'>正方一辩</option>";
                     echo "<option value='正方二辩'>正方二辩</option>";
                     echo "<option value='正方三辩'>正方三辩</option>";
                     echo "<option value='正方四辩'>正方四辩</option>";
                     echo "<option value='反方一辩'>反方一辩</option>";
                     echo "<option value='反方二辩'>反方二辩</option>";
                     echo "<option value='反方三辩'>反方三辩</option>";
                     echo "<option value='反方四辩'>反方四辩</option>";
                    }
                    
                ?>
</select>
<br>
<h3>侯选人3<span style="color:red;">*</span></h3>
<select name="participant3" id="participant3" class="form-control group" required onchange="myFunction3()"
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
                
                    // $sql = $conn->prepare("SELECT name_cn,uni FROM participants WHERE round1='".$_SESSION['titleID']."'  or round1_2='".$_SESSION['titleID']."'");

                    // $products = array();
                    // $count = 0;
                    //     if($sql->execute())
                    //     {
                    //         while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                    //             $participant[] = $row;
                    //             echo "<option value='".$participant[$count]['name_cn']."' >".$participant[$count]['name_cn']."  ".$participant[$count]['uni']."</option>";
                    //             $count++;
                    //             }
                    //     }
                    echo "<option value='正方一辩'>正方一辩</option>";
                     echo "<option value='正方二辩'>正方二辩</option>";
                     echo "<option value='正方三辩'>正方三辩</option>";
                     echo "<option value='正方四辩'>正方四辩</option>";
                     echo "<option value='反方一辩'>反方一辩</option>";
                     echo "<option value='反方二辩'>反方二辩</option>";
                     echo "<option value='反方三辩'>反方三辩</option>";
                     echo "<option value='反方四辩'>反方四辩</option>";
                    }
                    
                ?>
</select>
<br/>
<input class="btn btn-primary btn-block btn-login" type="submit" value="提交"
<?php
                if(
                        $participant[0]['bestParticipant1']!='0' &&
                        $participant[0]['bestParticipant2']!='0' &&
                        $participant[0]['bestParticipant3']!='0')
                        {
                            echo "style='display:none'" ;
                        }
                        
                ?>
>
</form>
<div>
    <p style="font-size:0.8rem;color:darkred;">*选出三位心目中最佳的三位辩手!</p>
</div>
</div>

</body>



<script>
function myFunction1(){
    var x =document.getElementById("participant1").value;
    // alert(x);
}
function myFunction2(){
    var y =document.getElementById("participant2").value;
    // alert(y);
}
function myFunction3(){
    var z =document.getElementById("participant3").value;
    // alert(z);
}
function validateForm(){
    var x =document.getElementById("participant1").value;
    var y =document.getElementById("participant2").value;
    var z =document.getElementById("participant3").value;
    if((x==y) || (x==z)|| (y==z)){
        alert("请选出不同的辩手！");
        return false;
    }
}
</script>

