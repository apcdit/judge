<?php include('header.php'); ?>

<html>

    <body>
        <br>
        <div class="container">
            <strong><h1>打分表格</h1></strong>
            <h3>题目</h3>

            <form action="">
            <table class="table">
                <thead>
                    <tr>
                        <th>正方</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tr>
                    <td>一辩</td>
                    <td>立论<input id="lilun_pos"  type="number" value = 0 class="form-control group" style="width:50px;" max=30 min=0></td>
                    <td>质询<input id="zhixun_pos_1" type="number" value = 0 class="form-control group" style="width:50px;"max=20 min=0></td>
                    <td>语言风度<input id="yuyan_pos_1" type="number" value = 0 class="form-control group" style="width:50px;" max=10 min=0></td>
                    <td>自由辩论<input id="ziyou_pos_1" type="number" value = 0 class="form-control group"  style="width:50px;" max=25 min=0></td>                
                </tr>
               
                <tr>
                    <td>二辩</td>
                    <td>驳论<br><input id="bolun_pos" type="number" value = 0 class="form-control group"  style="width:50px;" max=30 min=0></td>
                    <td>攻辩<br><input id="gongbian_pos" type="number" value = 0 class="form-control group"  style="width:50px;" max=30 min=0></td>
                    <td>语言风度<br><input id="yuyan_pos_2" type="number" value = 0 class="form-control group"  style="width:50px;" max=10 min=0></td>
                    <td>自由辩论<br><input id="ziyou_pos_2" type="number" value = 0 class="form-control group"  style="width:50px;" max=25 min=0></td>                
                </tr>
                <tr>
                    <td>三辩</td>
                    <td>质询<br><input id="zhixun_pos_2" type="number" value = 0  class="form-control group"  style="width:50px;" max=30 min=0></td>
                    <td>小结<br><input id="xiaojie_pos" type="number" value = 0  class="form-control group" style="width:50px;" max=30 min=0></td>
                    <td>语言风度<br><input id="yuyan_pos_3" type="number" value = 0  class="form-control group" style="width:50px;" max=10 min=0></td>
                    <td>自由辩论<br><input  id="ziyou_pos_3" type="number" value = 0 class="form-control group"  style="width:50px;" max=25 min=0></td>                
                </tr>
                <tr>
                    <td>四辩</td>
                    <td>陈词<br><input id="chenci_pos" type="number" value = 0 class="form-control group"  style="width:50px;" max=30 min=0></td>
                    <td></td>
                    <td>语言风度<br><input id="yuyan_pos_4" type="number" value = 0  class="form-control group" style="width:50px;" max=10 min=0></td>
                    <td>自由辩论<br><input id="ziyou_pos_4"  type="number" value = 0  class="form-control group" style="width:50px;" max=25 min=0></td>                
                </tr>
                <tr><td colspan="5">团体配合和合作精神 <input id="tuanti_pos" type="number" value = 0  class="form-control group" max=30 min=0></td></tr>
                

            </table>


            <table class="table"   >
                <thead>
                    <tr>
                        <th>反方</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tr>
                    <td>一辩</td>
                    <td>立论<br><input id="lilun_neg" type="number" value = 0 class="form-control group" style="width:50px;" max=30 min=0></td>
                    <td>质询<br><input id="zhixun_neg_1" type="number" value = 0  class="form-control group" style="width:50px;" max=20 min=0></td>
                    <td>语言风度<br><input id="yuyan_neg_1" type="number" value = 0  class="form-control group" style="width:50px;" max=10 min=0></td>
                    <td>自由辩论<br><input id="ziyou_neg_1" type="number" value = 0 class="form-control group"  style="width:50px;" max=25 min=0></td>                
                </tr>
                <tr>
                    <td>二辩</td>
                    <td>驳论<br><input id="bolun_neg" type="number" value = 0 class="form-control group"  style="width:50px;" max=30 min=0></td>
                    <td>攻辩<br><input id="gongbian_neg" type="number" value = 0 class="form-control group"  style="width:50px;" max=30 min=0></td>
                    <td>语言风度<br><input id="yuyan_neg_2" type="number" value = 0  class="form-control group" style="width:50px;" max=10 min=0></td>
                    <td>自由辩论<br><input id="ziyou_neg_2" type="number" value = 0  class="form-control group" style="width:50px;" max=25 min=0></td>                
                </tr>
                <tr>
                    <td>三辩</td>
                    <td>质询<br><input id="zhixun_neg_3" type="number" value = 0 class="form-control group"  style="width:50px;" max=30 min=0></td>
                    <td>小结<br><input id="xiaojie_neg" type="number" value = 0  class="form-control group" style="width:50px;" max=30 min=0></td>
                    <td>语言风度<br><input id="yuyan_neg_3" type="number" value = 0  class="form-control group" style="width:50px;" max=10 min=0></td>
                    <td>自由辩论<br><input id="ziyou_neg_3" type="number" value = 0  class="form-control group" style="width:50px;" max=25 min=0></td>                
                </tr>
                <tr>
                    <td>四辩</td>
                    <td>陈词<br><input id="chenci_neg" type="number" value = 0  class="form-control group" style="width:50px;" max=30 min=0></td>
                    <td></td>
                    <td>语言风度<br><input id="yuyan_neg_4" type="number" value = 0  class="form-control group" style="width:50px;" max=10 min=0></td>
                    <td>自由辩论<br><input id="ziyou_neg_4" type="number" value = 0  class="form-control group" style="width:50px;" max=25 min=0></td>                
                </tr>
                <tr><td colspan="5">团体配合和合作精神 <span></span><input type="number" id="tuanti_neg" value = 0 class="form-control group"  max=30 min=0></td></tr>
                

            </table>
            <button id="submit" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">提交</button>
            </form>

            <!-- Modal -->
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
                    <span>正方: </span><span id="marks_pos"></span><br>
                    <span>反方: </span><span id="marks_neg"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary">提交</button>
                </div>
                </div>
            </div>
            </div>

        </div>
    </body>

</html>

<script>
    $(document).ready(function(){
        $('#submit').click(function(e){
            e.preventDefault();
            var total_neg = parseInt($('#lilun_neg').val())+parseInt($('#zhixun_neg_1').val())+parseInt($('#yuyan_neg_1').val())+parseInt($('#ziyou_neg_1').val())+
            parseInt($('#bolun_neg').val())+parseInt($('#gongbian_neg').val())+parseInt($('#yuyan_neg_2').val())+parseInt($('#ziyou_neg_2').val())+
            parseInt($('#zhixun_neg_3').val())+parseInt($('#xiaojie_neg').val())+parseInt($('#yuyan_neg_3').val())+parseInt($('#ziyou_neg_3').val())+
            parseInt($('#chenci_neg').val())+parseInt($('#yuyan_neg_4').val())+parseInt($('#ziyou_neg_4').val())+parseInt($('#tuanti_neg').val());
            $("#marks_neg").html("");
            $('#marks_neg').html(total_neg);

            var total_pos = parseInt($('#lilun_pos').val())+parseInt($('#zhixun_pos_1').val())+parseInt($('#yuyan_pos_1').val())+parseInt($('#ziyou_pos_1').val())+
            parseInt($('#bolun_pos').val())+parseInt($('#gongbian_pos').val())+parseInt($('#yuyan_pos_2').val())+parseInt($('#ziyou_pos_2').val())+
            parseInt($('#zhixun_pos_2').val())+parseInt($('#xiaojie_pos').val())+parseInt($('#yuyan_pos_3').val())+parseInt($('#ziyou_pos_3').val())+
            parseInt($('#chenci_pos').val())+parseInt($('#yuyan_pos_4').val())+parseInt($('#ziyou_pos_4').val())+parseInt($('#tuanti_pos').val());
            $("#marks_pos").html("");
            $('#marks_pos').html(total_pos);
        });
    })
    
</script>