<?php include('header.php'); 

    session_start();

    if(!isset($_SESSION['userID'])){
        header("Location: login.php");
    }
?>


<html>
<head><title>印象分</title>
<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>

<div class="container" >
    <div class="wrapper" >
        <div class="content " style="height:100%">
        <div class="header" style="display:block;height:10%">
            <h1>印象票</h1>
        </div>
        <div class="row justify-content-center" style="align-items: center;height:90%">
            <div class="col-md-4 box" data-toggle="modal" data-target="#exampleModal">正方</div>
            <div class="col-md-4 box" data-toggle="modal" data-target="#exampleModal2">反方</div>
            
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">印象票</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <span>正方 </span><br>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
            <button type="button" class="btn btn-primary">提交</button>
        </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">印象票</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <span>反方 </span><br>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
            <button type="button" class="btn btn-primary">提交</button>
        </div>
        </div>
    </div>
    </div>

</body>

</html>
<script>
function submit(){
    alert("Confirm");
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

<?php 
function updateImpressionMark($side, $competition_id){
    
    try {
               
        $sql = "UPDATE Competition SET impression_ticket=1 
                WHERE 
                    competion_id=$competition_id 
                    and
                    side=$side";
    
        // Prepare statement
        $stmt = $conn->prepare($sql);
    
        // execute the query
        $stmt->execute();
    
        // echo a message to say the UPDATE succeeded
        echo $stmt->rowCount() . " records UPDATED successfully";
        }
    catch(PDOException $e)
        {
        echo $sql . "<br>" . $e->getMessage();
        }

}
?>