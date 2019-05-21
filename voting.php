<?php
include('header.php'); 

session_start();
include('/inc/connect.php');
if(!isset($_SESSION['userID'])){
    header("Location: login.php");
}?>
<body>
<div class="container">
<form method="POST" action="php/bestparticipantHandler.php">
        <h3>最佳辩手1</h3>
        <select name="participant1" id="participant1" class="form-control group">
            <option value="">- 选择姓名 -</option>
                <?php
                $sql = $conn->prepare("SELECT name_cn,uni FROM participants WHERE round1='".$_SESSION['titleID']."'  or round1_2='".$_SESSION['titleID']."'");

                $products = array();
                $count = 0;
                if($sql->execute()){
                while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $participant[] = $row;
                    echo "<option value='".$participant[$count]['name_cn']."' >".$participant[$count]['name_cn']."  ".$participant[$count]['uni']."</option>";
                    $count++;
                }
                }
                ?>
        </select>
<h3>最佳辩手2</h3>
<select name="participant2" id="participant2" class="form-control group">
<option value="">- 选择姓名 -</option>
<?php
$sql = $conn->prepare("SELECT name_cn,uni FROM participants WHERE round1='".$_SESSION['titleID']."'  or round1_2='".$_SESSION['titleID']."'");

$products = array();
$count = 0;
if($sql->execute()){
while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
    $participant[] = $row;
    echo "<option value='".$participant[$count]['name_cn']."' >".$participant[$count]['name_cn']."  ".$participant[$count]['uni']."</option>";
    $count++;
}
}
?>
</select>
<h3>最佳辩手3</h3>
<select name="participant3" id="participant3" class="form-control group">
<option value="">- 选择姓名 -</option>
<?php
$sql = $conn->prepare("SELECT name_cn,uni FROM participants WHERE round1='".$_SESSION['titleID']."'  or round1_2='".$_SESSION['titleID']."'");

$products = array();
$count = 0;
if($sql->execute()){
while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
    $participant[] = $row;
    echo "<option value='".$participant[$count]['name_cn']."' >".$participant[$count]['name_cn']."  ".$participant[$count]['uni']."</option>";
    $count++;
}
}
?>
</select>
<button class="btn btn-primary btn-block btn-login" type="submit">提交</button>
</form>
</div>

</body>