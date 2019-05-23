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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
</head>

<body>
    <div class="sidenav">
        <p>亚太大专辩论赛</p>
        <hr/>
        <a href="dashboard.php"><i class="fas fa-tachometer-alt" style="padding-right:10px;"></i>Dashboard</a>
        <a href="result.php"><i class="fas fa-poll" style="padding-right:10px;"></i>Result</a>
        <a href="teams.php"><i class="fas fa-users" style="padding-right:10px;"></i>Teams</a>
        <a href="#"><i class="fas fa-gavel" style="padding-right:10px;"></i>Judges</a>
    </div>
    <div class="main">
        <div class="box" style="width:100%"><h4>Results</h4></div>
        <div class="box" style="width:100%">
            <label for="title">题目：</label>
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
        <div class="container">
        <button id="submit" class="btn btn-primary btn-block" style="background-color:darkred;">查询成绩</button>                    
        </div>

        <div class="column" style="margin-top: 100px;">
            <div id="result" class="card" style="display:none">
            
            </div>
        </div>
    </div>
    
</body>

</html>

<script>
    $(document).ready(function(){
        $("#submit").click(checkStatus);
        
    });
    
    const checkStatus = () => {
        let competition_id = $('#competition_id').val();
        // console.log(competition_id);
        $.ajax({
            url: "php/status.php",
            type: "GET",
            data:{
                competition_id: competition_id
            },
            dataType: "JSON",
            success: function(res){
                $('#result').css('display','block');
                var title = res['title'];
                var names = res['names'];
                var problematic = res['problematic'];
                var error = false;

                render = `<h3>${title['title']}</h3>`;
                
                $.each(names, function(key,value){
                    if(problematic.includes(key)){
                        render += `<h5 style="color:red;">${key}. ${value['name']}</h5>`;
                        error = true;                        
                    }else{
                        render += `<h5 style="color:green;">${key}. ${value['name']}</h5>`;
                    }
                });
                if(!error) render += `<button class="btn btn-primary" id="generate" style="background-color:darkred;">Generate result...</button>`;


                $('#result').html(render);

            }
        });
    };

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
        });

        $.each(arrayNeg, function(index,value){
            impression_neg += parseInt(value['impression_ticket']);
            mark_neg += parseInt(value['mark_ticket']);
            zongjie_neg += parseInt(value['zongjie_ticket']);
        });

        var content = "<div class='container'>abc</div>";

       $("#result").html(content);
    }
   
</script>

<style>

    .column {
    width: 25%;
    padding: 0 10px;
    margin: 0 auto;

    }

    /* Style the counter cards */
    .card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); /* this adds the "card" effect */
        padding: 16px;
        text-align: center;
        background-color: #f1f1f1;
    }

   .box{
        border: 1px;
        padding: 10px;
        margin-left: 8px;
        margin-top: 6px;
        border-radius: 3px;
        background-color: white;
        border-width: 1px;
        box-shadow: 2px 2px 1px #f7f7f7;
        margin-bottom:30px;
        display: inline-block;
    }

    .box:hover{
        box-shadow: 0px 0px 1px lightgrey;
    }
    
    .box h4{
        display: inline-block;
    }
    #sidenav hr{
        position: 0 auto;
        width: 75%;
        background-color: black;
    }
    /* The sidebar menu */
    .sidenav {
        height: 100%; /* Full-height: remove this if you want "auto" height */
        width: 200px; /* Set the width of the sidebar */
        position: fixed; /* Fixed Sidebar (stay in place on scroll) */
        z-index: 1; /* Stay on top */
        top: 0; /* Stay at the top */
        left: 0;
        background-color: #292a2b; /* Black */
        overflow-x: hidden; /* Disable horizontal scroll */
        padding-top: 20px;
        box-shadow: 2px 2px 1px lightgrey;
    }

    /* The navigation menu links */
    .sidenav a {
        padding: 6px 8px 6px 16px;
        text-decoration: none;
        font-size: 15px;
        color: white;
        display: block;
        margin-bottom: 15px;
    }

    .sidenav p{
        font-size: 20px;
        padding: 6px 8px 6px 16px;
        text-decoration: none;
        color: white;
    }

    /* When you mouse over the navigation links, change their color */
    .sidenav a:hover {
        color: #f1f1f1;
        background-color: darkred;
    }

    /* Style page content */
    .main {
        margin-left: 190px; /* Same as the width of the sidebar */
        padding: 0px 10px;
    }

    
</style>