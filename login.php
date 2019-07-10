<?php

    // echo phpinfo();

    session_start([
    'cookie_lifetime' => 7200,
]);

// $maxlifetime = ini_get("session.gc_maxlifetime");
// echo $maxlifetime;

    include('header.php');
    include('inc/connect.php');

    if(isset($_SESSION['userID'])){
        header("Location: index.php");
    }
?>
<head>
    <title>亚太大专辩论线上评审系统</title>
</head>
<body>

    <div class="container">
    <br>
    <div class="row justify-content-center">
            <div class="col-md-8">
                    <div class="container">
                        <!-- title -->
                        <div class="text-center">
                            <h1>电子投票系统</h1>                        
                        </div>
                        <hr>
                        <!-- login form -->
                        <br>
                        <div>
                            <form id="my-form" name="my-form" method="POST" action="php/login_process.php">
                                <div class="form-group row">
                                    <h3 for="judge">评审姓名</h3>
                                    <select name="judge" id="judge" class="form-control group">
                                    <option value="">- 选择姓名 -</option>
                                    <?php 
                                    // Fetch Judge
                                     $sql = $conn->prepare("SELECT * FROM judges");
                                     $products = array();
                                     $count = 0;
                                     if($sql->execute()){
                                        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                                            $judges[] = $row;
                                            echo "<option value='".$judges[$count]['id']."' >".$judges[$count]['name']."</option>";
                                            $count++;
                                        }
                                     }
                                     $judges = null;                                    
                                    ?>
                                    </select>
                                </div>
                                
                                <div class="form-group row">
                                    <h3 for="title">题目</h3>
                                    <select name="title" id="title" class="form-control group">
                                    </select>
                                </div>
                                
                                <div class="form-group row">
                                    <h3>密码</h3>
                                    <input type="password" id="password" name="password" class="form-control group" placeholder='请输入密码' required>
                                </div>
                                <br>

                                    <div>
                                        <button class="btn btn-primary btn-block btn-login" type="submit">登录</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>

</body>

<style>
    .btn.btn-login{
        background: darkred;       
    }
    .btn.btn-login:hover{
        background: darkred;
    }
    label.error{
        color: red;
    }
</style>

<script>
    $(function(){
        $("#my-form").validate({
            rules:{
                judge:{
                    required: true,
                },
                title:{
                    required:true,
                },
                password:{
                    required: true,
                }
            },
            messages:{
                judge: "请勿留空！",
                title: "请勿留空！",
                password: "请勿留空！"
            }
        })
    });

    $(document).ready(function(){
        $('#judge').change(fetchTitle);
        // $('.btn-login').click(function(){
        //     var pw = prompt("请输入大会密码");
        //     if(pw == "" || pw == null){
        //         return false;
        //     }else if(pw != "apcdit123"){
        //         alert("密码错误！");
        //         return false;
        //     }
        // })
    })

    function fetchTitle(e){
        e.preventDefault();
        var id = $('#judge').val();
        $.ajax({
            type     : 'GET',
            url      : 'php/fetchTitle.php',
            data     : {
                id : id,
            },
            dataType : 'JSON',
            success  : function(data) {            
                var output = '<option value="">- 选择辩题 -</option>';
                $.each(data[0], function(i,s){
                    var title = s['title'];
                    var competition_id = s['competition_id'];

                    output += `<option value=${competition_id}>${competition_id}. ${title} (${data[1][competition_id]['uni_pos']} vs ${data[1][competition_id]['uni_neg']})</option>`;
                });

                $('#title').empty().append(output);
            },
            error: function(){
                console.log("Ajax failed");
            }
        }); 
    }
</script>