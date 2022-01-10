<?php
session_start();
include_once ('zApi\crud.php');

if(!empty($_SESSION['username'])){
    echo '<script language="javascript">alert("Welcome to Online chat"); '
         . 'window.location="home.php";</script>';
    die ();
}

if(isset($_POST['do-register'])){
    SignUp();
}
?>
<html>
    <head>
    <title>Register to Online chat</title>
    <style type="text/css">
        *{
    margin:0;
    padding: 0;
    box-sizing: border-box;
}
html{
    height: 100%;
}
body{
    font-family: 'Segoe UI', sans-serif;;
    font-size: 1rem;
    line-height: 1.6;
    height: 100%;
    overflow: hidden;
}
.wrap {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #fafafa;
    background-color: #009999;
}
.login-form{
    width: 350px;
    margin: 0 auto;
    border: 1px solid #ddd;
    padding: 2rem;
    background: #ffffff;
}
.form-input{
    background: #fafafa;
    border: 1px solid #eeeeee;
    padding: 12px;
    width: 100%;
}
.form-group{
    margin-bottom: 1rem;
}
.form-button{
    background: #69d2e7;
    border: 1px solid #ddd;
    color: #ffffff;
    padding: 10px;
    width: 100%;
    text-transform: uppercase;
}
.form-button:hover{
    background: #69c8e7;
}
.form-header{
    text-align: center;
    margin-bottom : 2rem;
}
    </style>
    </head>
    <body>
        <div style="top:0; width: 100%; height: 50px;">
                <h1>Online chat</h1>
            </div>
        <div class="wrap" id="DoiTT">
        <!--    <form class="login-form" action="signup.php" method="POST">
            <div class="form-header">
                <h3>Dang ki</h3>
            </div>
            <!--Email Input-->
            
        <!--    <div class="form-group">
                <input type="text" name="tenDK" class="form-input" placeholder="nhap ho ten...">
            </div>
            <div class="form-group">
                <input type="text" name="soDtDK" class="form-input" placeholder="so dien thoai...">
            </div>
            <div class="form-group">
                <input type="text" name="linkDK" class="form-input" placeholder="link avatar...">
            </div>
            <!--Password Input-->
         <!--   <div class="form-group">
                <input type="text" name="passDK" class="form-input" placeholder="nhap mat khau...">
            </div>
            <!--Login Button-->
        <!--    <div class="form-group">
                <input class="form-button" name="do-register" type="submit" value="Dang ki">
            </div>
        </form> -->
        </div>
       
       <script src="PluginJS/jquery.js"></script>
        <script src="PluginJS/socket.io.js"></script>
        <script src="signUp.js"></script>
    </body>
</html>



