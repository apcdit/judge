<?php include('header.php'); 

    session_start();
    include('inc/connect.php');
    if(!isset($_SESSION['userID'])){
        header("Location: login.php");
    }
    $competition_id1 = $_SESSION['titleID'];
    $userID= $_SESSION['userID'] ;
 
    
    try {

        $result_impressionTicket=[];
        $check_status = $conn->prepare("SELECT  impression_ticket,bestParticipant1,bestParticipant2,bestParticipant3 FROM `competition` WHERE judge_id='$userID' and competition_id='$competition_id1'");
        if($check_status->execute()){
            while($result_row = $check_status->fetch(PDO::FETCH_ASSOC)){
                
                // var_dump($result_row);
                array_push($result_impressionTicket,$result_row['impression_ticket']);
                if(($result_row["bestParticipant1"]=="0")&&($result_row["bestParticipant2"]=="0")&&($result_row["bestParticipant3"]=="0"))
                {
                    header("Location:voting.php");
                    
                }
                
            }
            if(($result_impressionTicket[0]==0)&&($result_impressionTicket[1]==0))
                {
                    header("Location:mark2.php");
                }
               
            // var_dump($result);
    
        }

        $stmt = $conn->prepare("SELECT zongjie_ticket FROM competition WHERE competition_id=? AND judge_id=? and side=0"); 
        $stmt->execute([$_SESSION['titleID'],$_SESSION['userID']]);

       $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        // //  var_dump($stmt->fetchAll());
        $data=$stmt->fetchAll();
        $negative=$data[0]['zongjie_ticket'];
        if(sizeof($data)<1){
            header('Location:index.php');
        }
        
        $stmt1 = $conn->prepare("SELECT zongjie_ticket FROM competition WHERE competition_id=? AND judge_id=? and side=1"); 
        $stmt1->execute([$_SESSION['titleID'], $_SESSION['userID']]);
        
              
        
        // // set the resulting array to associative
        $result = $stmt1->setFetchMode(PDO::FETCH_ASSOC);
        // //  var_dump($stmt->fetchAll());
        $data1=$stmt1->fetchAll();
        $affirmative=$data1[0]['zongjie_ticket'];
        }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>


<html>
<head><title>总结票</title>
<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
<?php 
        include('navigation.php');
?>
<div class="container" >
    <div class="wrapper" >
        <div class="content " style="height:100%">
        <div class="header" style="display:block;height:10%">
            <h1>总结票</h1>
            <h3 id="winner"></h3>
        </div>
        <div class="row justify-content-center" style="align-items: center;height:90%;width:80%;margin:auto auto;">
            <button class="col-md-4 box" data-toggle="modal" data-target="#exampleModal" id="affirmative">正方</button>
            <button class="col-md-4 box" data-toggle="modal" data-target="#exampleModal2" id="negative">反方</button>
            
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">总结票</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="php/zongjieMarkHandler.php" method="POST">
        <div class="modal-body">
            <span>正方 </span><br>
            <input name='side' value='1' style="display:none;">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
            <button type="submit" class="btn btn-primary">提交</button>
        </div>
        </form>
        </div>
    </div>
    </div>
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
        
            <h5 class="modal-title" id="exampleModalLabel">总结票</h5>
            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        
        </div>
        <form action="php/zongjieMarkHandler.php" method="POST">
            <div class="modal-body">
                <span>反方 </span><br>
                <input name='side' value='0' style="display:none;">
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary">提交</button>
            </div>
        </form>
        </div>
    </div>
    </div>

</body>

</html>
<script>
    var affirmative=<?php echo $affirmative;?>;
    var negative=<?php echo $negative;?>;
    if(affirmative==1)
    {
        document.getElementById("affirmative").style.backgroundColor = "darkred";
        document.getElementById("affirmative").style.color = "white";
        document.getElementById("affirmative").style.pointerEvents = "none";
        document.getElementById("negative").style.pointerEvents = "none";
        document.getElementById("winner").innerHTML = "正方胜";
        
    }
    if(negative==1)
    {
        document.getElementById("negative").style.background = "darkred";
        document.getElementById("negative").style.color = "white";
        document.getElementById("affirmative").style.pointerEvents = "none";
        document.getElementById("negative").style.pointerEvents = "none";
        document.getElementById("winner").innerHTML = "反方胜";
    }
    
    
</script>

<style>
body{
    margin:0px;font-size:36px;
    text-align: center;
}
.header{
    padding-top:30px;
}

.box{
    border:2px solid darkred;
    margin-left:50px;
}
.box:hover{
    background-color:white;
    color:darkred;
    box-shadow: 0 19px 38px rgba(0, 0, 0, 0.30), 0 15px 12px rgba(0, 0, 0, 0.22);
   
}
</style>

