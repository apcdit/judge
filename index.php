<?php include('header.php'); 

session_start();

if(!isset($_SESSION['userID'])){
    header("Location: login.php");
}

$titleID = $_SESSION['titleID'];
$title = $_SESSION['title'];
$userID = $_SESSION['userID'];

function generateMarks($max){
    for($i = 0; $i <= $max; $i++){
        echo '<option value="'.$i.'">'.$i.'</option>';
    }
}

?>

<html>
    <?php 
        include('navigation.php');
    ?>
    <body>
        <br>
        <div class="container">
            <strong><h1 class="text-center">打分表格</h1></strong>
            <hr>
            <strong><h2 class="text-center">题目: <?php echo $title ?></h2></strong>
            <a href="php/logout_process.php">LOGOUT</a>
            
            <form  id="my_form" action="php/insertMarkHandler.php" method="POST">
            <div class="card">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th style="text-align:left;font-size:2rem;">正方</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="participant-id">一辩</td>
                    <td class="mark-title">立论
                    <br>
                        <select name="lilun_pos" id="lilun_pos">
                            <?php generateMarks(30) ?>
                        </select>
                    </td>
                    <td class="mark-title">质询
                    <br>
                        <select name="zhixun_pos_1" id="zhixun_pos_1">
                            <?php generateMarks(20) ?>
                        </select>
                    </td>
                    
                    <td class="mark-title">语言风度
                    <br>
                        <select name="yuyan_pos_1" id="yuyan_pos_1">
                            <?php generateMarks(10) ?>
                        </select>
                    </td>
                    
                    <td>自由辩论<br><span>
                    
                        <select name="ziyou_pos_1" id="ziyou_pos_1">
                            <?php generateMarks(25) ?>
                        </select>
                        </span>
                    </td>                
                </tr>
               
                <tr>
                    <td class="participant-id">二辩</td>
                    <td class="mark-title">驳论
                        <br>
                        <select name="bolun_pos" id="bolun_pos">
                            <?php generateMarks(30) ?>
                        </select>
                    </td>
                    <td class="mark-title">攻辩
                    <br>
                        <select name="gongbian_pos" id="gongbian_pos">
                            <?php generateMarks(30) ?>
                        </select>
                    </td>
                    <td class="mark-title">语言风度<br>
                        <select name="yuyan_pos_2" id="yuyan_pos_2">
                            <?php generateMarks(10) ?>
                        </select>
                    </td>
                    <td class="mark-title">自由辩论<br>
                        <select name="ziyou_pos_2" id="ziyou_pos_2">
                            <?php generateMarks(25) ?>
                        </select>
                    </td>                
                </tr>
                <tr>
                    <td class="participant-id">三辩</td>
                    <td class="mark-title">质询<br>
                        <select name="zhixun_pos_2" id="zhixun_pos_2">
                            <?php generateMarks(30) ?>
                        </select>
                    </td>
                    <td class="mark-title">小结<br>
                        <select name="xiaojie_pos" id="xiaojie_pos">
                            <?php generateMarks(30) ?>
                        </select>
                    </td>
                    <td class="mark-title">语言风度<br>
                        <select name="yuyan_pos_3" id="yuyan_pos_3">
                            <?php generateMarks(10) ?>
                        </select>
                    </td>
                    <td class="mark-title">自由辩论<br>
                        <select name="ziyou_pos_3" id="ziyou_pos_3">
                            <?php generateMarks(25) ?>
                        </select>
                    </td>                
                </tr>
                <tr>
                    <td class="participant-id">四辩</td>
                    <td class="mark-title">陈词<br>
                        <select name="chenci_pos" id="chenci_pos">
                            <?php generateMarks(30) ?>
                        </select>
                    </td>
                    <td></td>
                    <td class="mark-title">语言风度<br>
                        <select name="yuyan_pos_4" id="yuyan_pos_4">
                            <?php generateMarks(10) ?>
                        </select>
                    </td>
                    <td class="mark-title">自由辩论<br>
                        <select name="ziyou_pos_4" id="ziyou_pos_4">
                            <?php generateMarks(25) ?>
                        </select>
                    </td>                
                </tr>
                <tr><td colspan="5">团体配合和合作精神 
                        <select name="tuanti_pos" id="tuanti_pos">
                            <?php generateMarks(30) ?>
                        </select>
                </td></tr>
                </tbody>
                
                <!-- <tr><td colspan="5"><span>正方: </span><span id="marks_pos" >0</span><br></td></tr> -->

            </table>
            </div>
            <br>
            <div class="card">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th style="text-align:left;font-size:2rem;">反方</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                <td class="participant-id">一辩</td>
                    <td class="mark-title">立论
                    <br>
                        <select name="lilun_neg" id="lilun_neg">
                            <?php generateMarks(30) ?>
                        </select>
                    </td>
                    <td class="mark-title">质询
                    <br>
                        <select name="zhixun_neg_1" id="zhixun_neg_1">
                            <?php generateMarks(20) ?>
                        </select>
                    </td>
                    
                    <td class="mark-title">语言风度
                    <br>
                        <select name="yuyan_neg_1" id="yuyan_neg_1">
                            <?php generateMarks(10) ?>
                        </select>
                    </td>
                    
                    <td class="mark-title">自由辩论
                    <br>
                        <select name="ziyou_neg_1" id="ziyou_neg_1">
                            <?php generateMarks(25) ?>
                        </select>
                    </td>  
                </tr>
                <tr>
                <td class="participant-id">二辩</td>
                    <td class="mark-title">驳论
                        <br>
                        <select name="bolun_neg" id="bolun_neg">
                            <?php generateMarks(30) ?>
                        </select>
                    </td>
                    <td class="mark-title">攻辩
                    <br>
                        <select name="gongbian_neg" id="gongbian_neg">
                            <?php generateMarks(30) ?>
                        </select>
                    </td>
                    <td class="mark-title">语言风度<br>
                        <select name="yuyan_neg_2" id="yuyan_neg_2">
                            <?php generateMarks(10) ?>
                        </select>
                    </td>
                    <td class="mark-title">自由辩论<br>
                        <select name="ziyou_neg_2" id="ziyou_neg_2">
                            <?php generateMarks(25) ?>
                        </select>
                    </td>
                </tr>
                <tr>
                <td class="participant-id">三辩</td>
                    <td class="mark-title">质询<br>
                        <select name="zhixun_neg_2" id="zhixun_neg_3">
                            <?php generateMarks(30) ?>
                        </select>
                    </td>
                    <td class="mark-title">小结<br>
                        <select name="xiaojie_neg" id="xiaojie_neg">
                            <?php generateMarks(30) ?>
                        </select>
                    </td>
                    <td class="mark-title">语言风度<br>
                        <select name="yuyan_neg_3" id="yuyan_neg_3">
                            <?php generateMarks(10) ?>
                        </select>
                    </td>
                    <td class="mark-title">自由辩论<br>
                        <select name="ziyou_neg_3" id="ziyou_neg_3">
                            <?php generateMarks(25) ?>
                        </select>
                    </td>  
                </tr>
                <tr>
                <td class="participant-id">四辩</td>
                    <td class="mark-title">陈词<br>
                        <select name="chenci_neg" id="chenci_neg">
                            <?php generateMarks(30) ?>
                        </select>
                    </td>
                    <td></td>
                    <td class="mark-title">语言风度<br>
                        <select name="yuyan_neg_4" id="yuyan_neg_4">
                            <?php generateMarks(10) ?>
                        </select>
                    </td>
                    <td class="mark-title">自由辩论<br>
                        <select name="ziyou_neg_4" id="ziyou_neg_4">
                            <?php generateMarks(25) ?>
                        </select>
                    </td>   
                </tr>
                <tr><td colspan="5">团体配合和合作精神 
                        <select name="tuanti_neg" id="tuanti_neg">
                            <?php generateMarks(30) ?>
                        </select>
                </td></tr>
                </tbody>
            
                
                <!-- <tr><td colspan="5"><span>反方: </span><span id="marks_neg" >0</span><br></td></tr> -->
            </table>
            <button id="submit" type="button" class="btn btn-submit btn-block" data-toggle="modal" data-target="#exampleModal" style="margin-bottom:50px;">总结分数</button>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">总结</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <span>正方: </span><span id="marks_pos_1"></span><br>
                                <span>反方: </span><span id="marks_neg_1"></span>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                                <button type="submit" class="btn btn-primary" id="submit_final">提交</button>
                            </div>
                        </div>
                </div>
            </div>
            </form>
            </div>

            <!-- Modal -->
            

        </div>
    </body>

</html>

<script>
    $(document).ready(function(){
        // $("input[type='number']").change( function() {
        //     var total_neg = parseInt($('#lilun_neg').val())+parseInt($('#zhixun_neg_1').val())+parseInt($('#yuyan_neg_1').val())+parseInt($('#ziyou_neg_1').val())+
        //     parseInt($('#bolun_neg').val())+parseInt($('#gongbian_neg').val())+parseInt($('#yuyan_neg_2').val())+parseInt($('#ziyou_neg_2').val())+
        //     parseInt($('#zhixun_neg_3').val())+parseInt($('#xiaojie_neg').val())+parseInt($('#yuyan_neg_3').val())+parseInt($('#ziyou_neg_3').val())+
        //     parseInt($('#chenci_neg').val())+parseInt($('#yuyan_neg_4').val())+parseInt($('#ziyou_neg_4').val())+parseInt($('#tuanti_neg').val());
        //     $("#marks_neg").html("");
        //     $('#marks_neg').html(total_neg);

        //     var total_pos = parseInt($('#lilun_pos').val())+parseInt($('#zhixun_pos_1').val())+parseInt($('#yuyan_pos_1').val())+parseInt($('#ziyou_pos_1').val())+
        //     parseInt($('#bolun_pos').val())+parseInt($('#gongbian_pos').val())+parseInt($('#yuyan_pos_2').val())+parseInt($('#ziyou_pos_2').val())+
        //     parseInt($('#zhixun_pos_2').val())+parseInt($('#xiaojie_pos').val())+parseInt($('#yuyan_pos_3').val())+parseInt($('#ziyou_pos_3').val())+
        //     parseInt($('#chenci_pos').val())+parseInt($('#yuyan_pos_4').val())+parseInt($('#ziyou_pos_4').val())+parseInt($('#tuanti_pos').val());
        //     $("#marks_pos").html("");
        //     $('#marks_pos').html(total_pos);
        // });

        $('#submit').click(function(){
        
            var total_neg_1 = parseInt($('#lilun_neg').val())+parseInt($('#zhixun_neg_1').val())+parseInt($('#yuyan_neg_1').val())+parseInt($('#ziyou_neg_1').val())+
            parseInt($('#bolun_neg').val())+parseInt($('#gongbian_neg').val())+parseInt($('#yuyan_neg_2').val())+parseInt($('#ziyou_neg_2').val())+
            parseInt($('#zhixun_neg_3').val())+parseInt($('#xiaojie_neg').val())+parseInt($('#yuyan_neg_3').val())+parseInt($('#ziyou_neg_3').val())+
            parseInt($('#chenci_neg').val())+parseInt($('#yuyan_neg_4').val())+parseInt($('#ziyou_neg_4').val())+parseInt($('#tuanti_neg').val());
            $("#marks_neg_1").html("");
            $('#marks_neg_1').html(total_neg_1);

            var total_pos_1 = parseInt($('#lilun_pos').val())+parseInt($('#zhixun_pos_1').val())+parseInt($('#yuyan_pos_1').val())+parseInt($('#ziyou_pos_1').val())+
            parseInt($('#bolun_pos').val())+parseInt($('#gongbian_pos').val())+parseInt($('#yuyan_pos_2').val())+parseInt($('#ziyou_pos_2').val())+
            parseInt($('#zhixun_pos_2').val())+parseInt($('#xiaojie_pos').val())+parseInt($('#yuyan_pos_3').val())+parseInt($('#ziyou_pos_3').val())+
            parseInt($('#chenci_pos').val())+parseInt($('#yuyan_pos_4').val())+parseInt($('#ziyou_pos_4').val())+parseInt($('#tuanti_pos').val());
            $("#marks_pos_1").html("");
            $('#marks_pos_1').html(total_pos_1);
            
        });
        $('#submit_final').click(function(){
           
            $('#my_form').submit(); 
            console.log("asd");
            
        });
    })
    
</script>

<style>
    table, th, td, tr, thead {
        border: 1px solid transparent;
        font-size: 1.4rem;
        font-family: bold;
    }
    td{
        text-align:center;
    }
    button.btn-submit{
        background: darkred;
        color: white;
        border: solid 1px transparent;
        border-radius: 4px;
        font-size: 1.5rem;
        text-decoration: none;
    }
    .mark-title select{
        margin-top: 13px;
        margin-bottom: 10px;
    }
    .mark-title{
        
    }
    .container{
        max-width: 95vw;
    }
    .card{
        border-radius: 15px;
    }
    .participant-id{
        font-size: 1.5rem;
    }
</style>