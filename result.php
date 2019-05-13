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
        <div class="form-group">
            <h1>查询成绩</h1>
            <h3 for="title">题目</h3>
            <select name="title" id="competition_id" class="form-control group">
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
    <div id="result" style="margin-top:100px;"></div>
</body>

</html>

<script>
    $(document).ready(function(){
        $("#submit").click(fetchResult);
    })
    
    function fetchResult(){
        var competition_id = $("#competition_id").val();
        $.ajax({
            url: "php/result.php",
            type: "GET",
            data: {
                competition_id: competition_id
            },
            dataType: "JSON",
            success: function(response){
                processResult(response);
            }
        });
    }

    function processResult(data){
        var arrayResults = data;
        arrayPos = arrayResults.filter(function(value){
            return value['side'] == 1;
        })
        arrayNeg = arrayResults.filter(function(value){
            return value['side'] == 0;
        })
        var impression_pos = 0;
        var mark_pos = 0;
        var zongjie_pos = 0;

        var impression_neg = 0;
        var mark_neg = 0;
        var zongjie_neg = 0;
        
        $.each(arrayPos, function(index,value){
            impression_pos += parseInt(value['impression_ticket']);
            mark_pos += parseInt(value['mark_ticket']);
            zongjie_pos += parseInt(value['zongjie_ticket']);
        })

        $.each(arrayNeg, function(index,value){
            impression_neg += parseInt(value['impression_ticket']);
            mark_neg += parseInt(value['mark_ticket']);
            zongjie_neg += parseInt(value['zongjie_ticket']);
        })

        var content = "<div class='container'>abc</div>";

       $("#result").html(content);
    }
   
</script>