<?php include('header.php'); ?>

<html>
    <head>
        <title>Dashboard Page</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    </head>
    
    <script>
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
            return false;
        }
        checkUser();
       
    </script>

    <body>
        <!-- Side navigation -->
        <div class="sidenav">
            <p>亚太大专辩论赛</p>
            <hr/>
            <a href="dashboard.php"><i class="fas fa-tachometer-alt" style="padding-right:10px;"></i>Dashboard</a>
            <a href="#"><i class="fas fa-poll" style="padding-right:10px;"></i>Result</a>
            <a href="#">Competition</a>
            <a href="teams.php"><i class="fas fa-users" style="padding-right:10px;"></i>Teams</a>
            <a href="#"><i class="fas fa-gavel" style="padding-right:10px;"></i>Judges</a>
        </div>

        <!-- Page content -->
        <div class="main">
            <div class="box" style="width:100%"><h4>Teams</h4></div>
            <div class="box" style="width:100%; margin-top: -15px;">
                
            </div>
        </div>
    </body>
</html>

<style>

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

    i:hover{
        color:red;
    }

    body{
        background-color: #f7f7f7;
    }
</style>

<script>
    $(document).ready(function(){
        $('.btn-ongoing').click(loadOngoing)
    })
</script>
