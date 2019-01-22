<?php
    session_start();
    include('header.php');
    include('inc/connect.php');
?>

<body>
    <div class="container">
    <br>
    <div class="row justify-content-center">
            <div class="col-md-8">
                    <div class="container">
                        <!-- title -->
                        <div class="text-center">
                            <h1>评审</h1>                        
                        </div>
                        <hr>
                        <!-- login form -->
                        <br>
                        <div>
                            <form id="my-form" name="my-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <div class="form-group row">
                                    <h3 for="judge">评审姓名</h3>
                                    <select name="judge" id="judge" class="form-control group">
                                    <option value="">- 选择姓名 -</option>
                                    <?php 
                                    // Fetch Judge
                                    $sql_judges = "SELECT * FROM judges";
                                    $judges_data = mysqli_query($con,$sql_department);
                                    while($row = mysqli_fetch_assoc($department_data) ){
                                        $departid = $row['id'];
                                        $depart_name = $row['depart_name'];
                                        
                                        // Option
                                        echo "<option value='".$departid."' >".$depart_name."</option>";
                                    }
                                    ?>
                                    </select>
                                </div>
                                
                                <div class="form-group row">
                                    <h3 for="title">题目</h3>
                                    <select name="title" id="title" class="form-control group">
                                    </select>
                                </div>
                                
                                <br>

                                    <div>
                                        <button class="btn btn-primary btn-block btn-login">登录</button>
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
                }
            },
            messages:{
                judge: "请勿留空！",
                title: "请勿留空！"
            }
        })
    });

    $(document).ready(function(){
        $('#judge').change(fetchTitle);
    })

    function fetchTitle(){
        $.ajax({
            type     : 'GET',
            url      : 'php/fetchTitle.php',
            dataType : 'JSON',
            success  : function(data) {            
                var output = '<option value="">- 选择辩题 -</option>';
                
                $.each(data, function(i,s){
                    var newOption = s;
                    output += '<option value="' + newOption + '">' + newOption + '</option>';
                });

                $('#judge').empty().append(output);
            },
            error: function(){
                console.log("Ajax failed");
            }
        }); 
    }
</script>