<?php
    session_start();
    include('header.php');
    include('inc/connect.php');

?>

<html>
<head>
    <title>成绩查询</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
    <div class="container">
        <h1>查询成绩</h1>
        <div class="form-group row">
            <h3 for="title">题目</h3>
            <select name="title" id="title" class="form-control group">
            <?php 
                // Fetch Judge
                    $sql = $conn->prepare("SELECT * FROM titles");
                    $products = array();
                    $count = 0;
                    if($sql->execute()){
                    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                        print_r($row);
                        $titles[] = $row;
                        echo "<option value='".$titles[$count]['competition_id']."' >".$titles[$count]['competition_id'].". ".$titles[$count]['title']."</option>";
                        $count++;
                    }
                    }
                    $titles = null;                                    
                ?>
            </select>
           
        </div>
        
        <button id="submit" class="btn btn-primary">查询成绩</button>
    </div>
</body>

</html>

<script>
    $(document).ready(function(){
        $("#submit").click(fetchResult);
    })
    
    function fetchResult(){
        $competition_id = $("")
    }

   
</script>