<?php include('header.php');?>

<html>
    <head>
        <title>Dashboard Page</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    </head>
    
    <script>
        function deleteAllCookies() {
            var cookies = document.cookie.split(";");

            for (var i = 0; i < cookies.length; i++) {
                var cookie = cookies[i];
                var eqPos = cookie.indexOf("=");
                var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
                document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
            }
        }
        const checkUser = () => {
            var allcookies = document.cookie.split(";");
            
            if(allcookies[0] == undefined || allcookies[1] == undefined){
                var name = prompt("Enter your username: ");
                var password = prompt("Enter your password: ");
            }else{
                var name = allcookies[0].split("=")[1];
                var password = allcookies[1].split("=")[1];
            }
            

            if(name == "tjl" && password == "123"){
                document.cookie = "name=tjl";
                document.cookie = "password=123";
                return true;
            }

            alert("Wrong Credentials!!");
            window.location.href = "http://www.apchinesedebate.com/";
            deleteAllCookies();
            return false;
        }

        //load ongoing debate
        const loadOngoing = () => {
            var date = new Date();
            var output = `<I>Last Refresh: ${date}</I><hr><ul>`;
            $.ajax({
                url: "php/fetchOngoing.php",
                type: "GET",
                dataType: "JSON", 
                success: function(result){
 
                    if(result.length !== 0){
                        $.each(result, (index,element) => {
                        let competition_id = element['competition_id'];
                        let title = element['title'];
                            output += `<li>${competition_id}: ${title}</li>`
                        });
                        output += '</ul>'
                    }else{
                        output = "<hr>No ongoing debates.";
                    }
                    $("#ongoing").empty().append(output);                    
                }
            })
        }
        checkUser();
        loadOngoing();
    </script>

    <body>
        <!-- Side navigation -->
        <div class="sidenav">
            <p>亚太大专辩论赛</p>
            <hr/>
            <a href="dashboard.php"><i class="fas fa-tachometer-alt" style="padding-right:10px;"></i>Dashboard</a>
            <a href="result.php"><i class="fas fa-poll" style="padding-right:10px;"></i>Result</a>
            <a href="teams.php"><i class="fas fa-users" style="padding-right:10px;"></i>Teams</a>
            <a href="#"><i class="fas fa-gavel" style="padding-right:10px;"></i>Judges</a>
        </div>

        <!-- Page content -->
        <div class="main">
            <div class="box" style="width:100%"><h4>Dashboard</h4></div>
            <div class="row">
            <div class="box" id="ongoingDebate">
                <div class="container">
                <h4>Currently Ongoing Debate</h4>
                <button class="fas fa-sync-alt btn-ongoing" style="color:lightgrey"></button>
                </div>
                <div id="ongoing">
                </div>
            </div>
            <div class="box" id="activateDebate">
                <h4>Activate Debate</h4>
                <hr>
                <form method="POST" action="php/updateOngoing.php">
                    <?php
                        require('inc/connect.php');
                        $sql = $conn->prepare("SELECT competition_id, title, available FROM titles WHERE available=0");
                        $sql->execute();
                        $titles = $sql->fetchAll();
                        if($titles != []){
                            foreach($titles as $title){
                                echo '<input type="checkbox" name="competitionID[]" value='.'"'.$title['competition_id'].'"'.'> '.$title['competition_id'].'. '.$title['title'].'</input><br>';
                            }
                            echo '<br><input type="submit" class="btn btn-success" name="submit" value="Activate">';
                        }else{
                            echo 'No more debate entries in database.';
                        }
                    ?>
                </form>
            </div>
            <div class="box" id="deactivateDebate">
                <h4>Deactivate Debate</h4>
                <hr>
                <form method="POST" action="php/updateOngoing.php">
                    <?php
                        require('inc/connect.php');
                        $sql = $conn->prepare("SELECT competition_id, title, available FROM titles WHERE available=1");
                        $sql->execute();
                        $titles = $sql->fetchAll();
                        if($titles == []){
                            echo 'No ongoing debates.';
                        }else{
                            foreach($titles as $title){
                                echo '<input type="checkbox" name="competitionID[]" value='.'"'.$title['competition_id'].'"'.'> '.$title['competition_id'].'. '.$title['title'].'</input><br>';
                            }
                            echo '<br><input type="submit" class="btn btn-danger" name="submit" value="Deactivate">';
                        }     
                    ?>
                </form>
            </div>
            <div class="box" id="addDebate">
                <h4>Add Debate Titles</h4>
                <hr>
                <form action="php/updateTitles.php" method="POST">
                    <table>
                        <tbody>
                            <tr>
                                <th>Competition ID: </th>
                                <td><input type="text" name="competitionID"></td>
                            </tr>
                            <tr>
                                <th>辩题:</th>
                                <td><input type="text" name="title"></td>
                            </tr> 
                            <tr>
                                <th>正方辩题:</th>
                                <td><input type="text" name="posTitle"></td>
                            </tr>
                            <tr>
                                <th>反方辩题:</th>
                                <td><input type="text" name="negTitle"></td>
                            </tr>
                            <tr>
                                <th>正方学校:</th>
                                <th>
                                    <select name="posUni">
                                        <option value="新加坡国立大学">新加坡国立大学</option>
                                        <option value="山东大学">山东大学</option>
                                        <option value="UCSI大学">UCSI大学</option>
                                        <option value="昆士兰大学">昆士兰大学</option>
                                        <option value="南京大学">南京大学</option>
                                        <option value="多伦多大学">多伦多大学</option>
                                        <option value="澳大利亚国立大学">澳大利亚国立大学</option>
                                        <option value="上海交通大学">上海交通大学</option>
                                        <option value="马来西亚北方大学">马来西亚北方大学</option>
                                        <option value="东吴大学">东吴大学</option>
                                        <option value="深圳大学">深圳大学</option>
                                        <option value="马来西亚国立大学">马来西亚国立大学</option>
                                        <option value="中国政法大学">中国政法大学</option>
                                        <option value="马来西亚理科大学总院校">马来西亚理科大学总院校</option>
                                        <option value="香港浸会大学">香港浸会大学</option>
                                        <option value="香港科技大学">香港科技大学</option>
                                        <option value="上海交通大学医学院">上海交通大学医学院</option>
                                        <option value="新加坡南洋理工大学">新加坡南洋理工大学</option>
                                        <option value="中国人民大学">中国人民大学</option>
                                        <option value="新南威尔士大学">新南威尔士大学</option>
                                        <option value="香港中文大学">香港中文大学</option>
                                        <option value="世新大学">世新大学</option>
                                        <option value="西南财经大学">西南财经大学</option>
                                        <option value="澳门科技大学">澳门科技大学</option>
                                        <option value="Test">Test</option>
                                    </select>
                                </th>
                                <!-- <td><input type="text" name="posUni"></td> -->
                            </tr>
                            <tr>
                                <th>反方学校:</th>
                                <th>
                                    <select name="negUni">
                                        <option value="新加坡国立大学">新加坡国立大学</option>
                                        <option value="山东大学">山东大学</option>
                                        <option value="UCSI大学">UCSI大学</option>
                                        <option value="昆士兰大学">昆士兰大学</option>
                                        <option value="南京大学">南京大学</option>
                                        <option value="多伦多大学">多伦多大学</option>
                                        <option value="澳大利亚国立大学">澳大利亚国立大学</option>
                                        <option value="上海交通大学">上海交通大学</option>
                                        <option value="马来西亚北方大学">马来西亚北方大学</option>
                                        <option value="东吴大学">东吴大学</option>
                                        <option value="深圳大学">深圳大学</option>
                                        <option value="马来西亚国立大学">马来西亚国立大学</option>
                                        <option value="中国政法大学">中国政法大学</option>
                                        <option value="马来西亚理科大学总院校">马来西亚理科大学总院校</option>
                                        <option value="香港浸会大学">香港浸会大学</option>
                                        <option value="香港科技大学">香港科技大学</option>
                                        <option value="上海交通大学医学院">上海交通大学医学院</option>
                                        <option value="新加坡南洋理工大学">新加坡南洋理工大学</option>
                                        <option value="中国人民大学">中国人民大学</option>
                                        <option value="新南威尔士大学">新南威尔士大学</option>
                                        <option value="香港中文大学">香港中文大学</option>
                                        <option value="世新大学">世新大学</option>
                                        <option value="西南财经大学">西南财经大学</option>
                                        <option value="澳门科技大学">澳门科技大学</option>
                                        <option value="Test">Test</option>
                                    </select>
                                </th>
                                <!-- <td><input type="text" name="negUni"></td> -->
                            </tr>
                        </tbody>
                    </table>
                    <h6><strong>Judges:</strong></h6>
                    <div>
                        <?php 
                            $stmt = $conn->prepare("SELECT * FROM judges");
                            $stmt->execute();
                            $judges = $stmt->fetchAll();

                            foreach($judges as $judge){
                                echo '<input type="checkbox" style="margin:10px;" name="judgesID[]" value='.'"'.$judge['id'].'"'.'> '.$judge['name'].'  </input>';
                            }

                        ?>
                    </div>
                    <br>
                    <input type="submit" value="Add" name="Submit" class="btn btn-success">
                </form>
            </div>
            <div class="box" id="removeDebate">
                <h4>Remove Debate Titles</h4>
                <hr>
                <form action="php/updateTitles.php" method="POST">
                    <?php
                        $sql = $conn->prepare("SELECT competition_id, title FROM titles");
                        $sql->execute();
                        $titles = $sql->fetchAll();
                        if($titles != []){
                            foreach($titles as $title){
                                echo '<input type="checkbox" name="competitionID[]" value='.'"'.$title['competition_id'].'"'.'> '.$title['competition_id'].'. '.$title['title'].'</input><br>';
                            }
                        }else{
                            echo 'No more debate entries in database.';
                        }
                    ?>
                    <br>
                    <input type="submit" value="Remove" name="Submit" class="btn btn-danger">
                </form>
            
            </div>
            </div>
        </div>
    </body>
</html>

<style>
    #removeDebate{
        width:50%;
        margin-left:20px;
    }
    #addDebate{
        width:45%; 
        margin-left: 20px;
    }
    #deactivateDebate{
        width:26.75%; 
        margin-top: -15px;
    }
    #activateDebate{
        width:26.75%; margin-top: -15px;
    }
    #ongoingDebate{
        width:43.5%; margin-top: -15px; margin-left:15px;
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

    /* On smaller screens, where height is less than 450px, change the style of the sidebar (less padding and a smaller font size) */
    @media screen and (max-height: 450px) {
    .sidenav {padding-top: 15px;}
    .sidenav a {font-size: 18px;}
    }

    @media (max-width: 768px) {
    .sidenav {
        display: none;
    }
    .main{
        margin-left: 0px;
    }
    #removeDebate{
        width:95%;
        margin: 0 auto;
    }
    #addDebate{
        width:95%; 
        margin: 0 auto;
    }
    #deactivateDebate{
        margin: 0 auto;
        width:95%; 
    }
    #activateDebate{
        margin: 0 auto;
        width:95%; 
    }
    #ongoingDebate{
        margin: 0 auto;
        width:95%; 
    }
}

    i:hover{
        color:red;
    }

    
</style>

<script>
    $(document).ready(function(){
        $('.btn-ongoing').click(loadOngoing)
    })
</script>
