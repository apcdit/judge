<?php
    session_start();
    include('header.php');
    include('inc/connect.php');
    
    $sql = $conn->prepare("SELECT * FROM judges");
    $sql->execute([]);
    $judges = $sql->fetchAll()

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
                    $stmt = $conn->prepare("SELECT uni_pos, uni_neg FROM rounds WHERE competition_id=?");
                    if($sql->execute()){
                    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                        $titles[] = $row;
                        $competition_id = $titles[$count]['competition_id'];
                        $stmt->execute([$competition_id]);
                        $uni = $stmt->fetch();
                        echo "<option value='".$titles[$count]['competition_id']."' >".$titles[$count]['competition_id'].". ".$titles[$count]['title']."(".$uni['uni_pos']." vs ".$uni['uni_neg'].")</option>";
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

        <div class="column" style="margin-top: 100px;width:100%;">
            <div id="result_summary" class="card" style="display:none;">
            
            </div>
        </div>
    </div>
    
</body>

</html>

<script>
    $(document).ready(function(){
        $("#submit").click(checkStatus);
        $("#submit").click(fetchResult);
        $(document).on('click','#generate',function(){
            var competition_id = $('#competition_id').val()
        });
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
                        // error = true;                        
                    }else{
                        render += `<h5 style="color:green;">${key}. ${value['name']}</h5>`;
                    }
                });
                if(true) {
                    render += `<a class="btn btn-primary" href="result/impression_result.php?competition_id=${competition_id}" id="generate" style="background-color:darkred;" target="_blank">印象票</a><br>`;
                    render += `<a class="btn btn-primary" href="result/candidates_result.php?competition_id=${competition_id}" id="generate" style="background-color:darkred;" target="_blank">最佳辩手(1)</a>`;
                    render += `<a class="btn btn-primary" href="result/candidate_result.php?competition_id=${competition_id}" id="generate" style="background-color:darkred;" target="_blank">最佳辩手（3）</a>`;
                    render += `<a class="btn btn-primary" href="result/zongjie_result.php?competition_id=${competition_id}" id="generate" style="background-color:darkred;" target="_blank">总结票</a>`;
                    render += `<a class="btn btn-primary" href="result/mark_result.php?competition_id=${competition_id}" id="generate" style="background-color:darkred;" target="_blank">分数票</a>`;
                    render += `<a class="btn btn-primary" href="result/result_summary.php?competition_id=${competition_id}" id="generate" style="background-color:darkred;" target="_blank">Summary</a>`;
                }


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
                // console.log(response)
                processResult(response);
            }
        });
    }
    
    function processResult(data){
        var arrayResults = data[0];
        var judgeResult = data[2];
        // console.log(arrayResults);
        var mark_judge_pos = JSON.stringify(data[4],null,4);
        var mark_judge_neg = JSON.stringify(data[5],null,4);
        console.log(arrayResults);
        // console.log(mark_judge_pos);
        // console.log(mark_judge_neg);

        var judge_all = data[6];
        console.log(judge_all);
        arrayPos = arrayResults.filter(function(value){
            return value['side'] == 1;
        });
        arrayNeg = arrayResults.filter(function(value){
            return value['side'] == 0;
        });

        var same_mark_judge = {};

        $.each(arrayPos, function(i,v1){
            let judge_id_pos = arrayPos[i]['judge_id'];
            $.each(arrayNeg, function(j,v2){
                let judge_id_neg = arrayNeg[j]['judge_id'];
                if(judge_id_pos == judge_id_neg){
                    if(arrayPos[i]['total_mark'] == arrayNeg[j]['total_mark']){
                        same_mark_judge[judge_id_pos] = {};
                        same_mark_judge[judge_id_pos]['neg'] = {};
                        same_mark_judge[judge_id_pos]['pos'] = {};
                        same_mark_judge[judge_id_pos]['neg']['tuanti_ziyou'] = parseInt(arrayNeg[i]['tuanti']) + parseInt(arrayNeg[i]['ziyou_1']) + parseInt(arrayNeg[i]['ziyou_2']) + parseInt(arrayNeg[i]['ziyou_3']) + parseInt(arrayNeg[i]['ziyou_4']);
                        same_mark_judge[judge_id_pos]['neg']['tuanti'] = parseInt(arrayNeg[i]['tuanti']);
                        same_mark_judge[judge_id_pos]['pos']['tuanti'] = parseInt(arrayPos[j]['tuanti']);
                        same_mark_judge[judge_id_pos]['pos']['tuanti_ziyou'] =  parseInt(arrayPos[j]['tuanti']) + parseInt(arrayPos[j]['ziyou_1']) + parseInt(arrayPos[j]['ziyou_2']) + parseInt(arrayPos[j]['ziyou_3']) + parseInt(arrayPos[j]['ziyou_4']);
                        return false;
                    }
                }
            });
        });



        console.log(same_mark_judge);

        // console.log(arrayPos);
        // console.log(arrayNeg);
        var impression_pos = 0;
        var impression_pos_judges = [];
        var mark_pos = 0;
        var mark_pos_judges = [];
        var zongjie_pos = 0;
        var zongjie_pos_judges = [];

        var impression_neg = 0;
        var impression_neg_judges = [];
        var mark_neg = 0;
        var mark_neg_judges = [];
        var zongjie_neg = 0;
        var zongjie_neg_judges = [];
        
        $.each(arrayPos, function(index,value){
            impression_pos += parseInt(value['impression_ticket']);
            if(parseInt(value['impression_ticket']) == 1)
                impression_pos_judges.push(judgeResult[value['judge_id']]);
            mark_pos += parseInt(value['mark_ticket']);
            if(parseInt(value['mark_ticket']) == 1)
                mark_pos_judges.push(judgeResult[value['judge_id']]);
            zongjie_pos += parseInt(value['zongjie_ticket']);
            if(parseInt(value['zongjie_ticket']) == 1)
                zongjie_pos_judges.push(judgeResult[value['judge_id']]);
        });

        $.each(arrayNeg, function(index,value){
            impression_neg += parseInt(value['impression_ticket']);
            if(parseInt(value['impression_ticket']) == 1)
                impression_neg_judges.push(judgeResult[value['judge_id']]); 
            mark_neg += parseInt(value['mark_ticket']);
            if(parseInt(value['mark_ticket']) == 1)
                mark_neg_judges.push(judgeResult[value['judge_id']]); 
            zongjie_neg += parseInt(value['zongjie_ticket']);
            if(parseInt(value['zongjie_ticket']) == 1)
                zongjie_neg_judges.push(judgeResult[value['judge_id']]);
        });

        var bestParticipant = data[1];
        var first = [];
        first = data[3];
        var output = "";
        
        $.each(bestParticipant, function(key,value){
            output += `<tr style="font-size:40px;"><td style="text-align:center">${key}</td><td style="text-align:center">${value[0]}</td><td style="text-align:center">${value[1]}</td></tr>`;
        });
        // var empty = [];
        // $.each(first,function(key,value){
        //     empty.push([key,value]);
        // });
        var output2 = "<tr><td>评审</td><td>团体+自由</td><td>团体</td><tr>";
        $.each(same_mark_judge, function(key,value){
            output2 += `<td>${judge_all[key]['name']}</td><td>正: ${value['pos']['tuanti_ziyou']}, 反: ${value['neg']['tuanti_ziyou']}</td><td>正: ${value['pos']['tuanti']}, 反: ${value['neg']['tuanti']}</td>`;
        });
            
        var output3 = "";
        console.log(mark_judge_pos);
        console.log(mark_judge_neg);
        var content = `<table style="margin:0 auto;width:80%;" border="1"><tbody>
           <tr style="font-size:40px;font-weight:900;"><td></td><td>正</td><td>反</td></tr>
           <tr style="text-align:center;font-size: 40px;"><td rowspan="2">印象票</td><td>${impression_pos}</td><td>${impression_neg}</td></tr>
           <tr><td>${impression_pos_judges}</td><td>${impression_neg_judges}</td></tr>

           <tr style="text-align:center;font-size: 40px;"><td rowspan="2">分数票</td><td>${mark_pos}</td><td>${mark_neg}</td></tr>
           <tr><td colspan="2">${mark_judge_pos}</td><td>${mark_judge_neg}</td></tr>
            ${output2}</tr>
           <tr><td colspan="3" style="text-align:center"><strong style="color:darkred;font-size:25px;">最佳三位辩手</strong></td></tr>${output}
           
           <tr style="text-align:center;font-size: 40px;"><td rowspan="2">总结票</td><td>${zongjie_pos}</td><td>${zongjie_neg}</td></tr>
           <tr><td>${zongjie_pos_judges}</td><td>${zongjie_neg_judges}</td></tr>
           
           <tr><td colspan="3"><strong style="color:darkred;font-size:25px;">最佳辩手</strong></td></tr>
           <tr><td colspan="3"><strong style="font-size:25px;">${first[0]['bestParticipant']}</strong></td></tr>
        </tbody>
        </table>`;

        $('#result_summary').html(content);
        $('#result_summary').css('display','block');
    }
   
</script>

<style>

    .btn-primary{
        margin: 2%;
    }
    .column {
    width: 25%;
    padding: 0 10px;
    margin: 0 auto;
    }

    #result_summary tr{
        height:75px;
        text-align:center;
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

    #result_summary{
        margin-bottom: 20%;
    }
</style>