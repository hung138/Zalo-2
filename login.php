<?php
session_start();

include_once ('api\login.php');
if(isset($_POST['do_login'])){
    LogIn();
    exit();
}
?>
<html>
    <head>
    <title>Login to Online chat</title>
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
    font-family: 'Segoe UI', sans-serif;
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
    background-color: #006666;
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
.form-footer{
    text-align: center;
}
    </style>
    </head>
    <body>
        <div style="top:0; width: 100%; height: 50px;">
                <h1>Online chat</h1>
            </div>
        <div class="wrap" id="DoiTT">
     <!--     <form class="login-form" action="login.php" method="POST">
            <div class="form-header">
                <h3>Dang nhap</h3>
            </div>
           
            <div class="form-group">
                <input type="text" name="soDT" class="form-input" placeholder="so dt dang nhap...">
            </div>
           
            <div class="form-group">
                <input type="password" name="passDN" class="form-input" placeholder="mat khau...">
            </div>
            
            <div class="form-group">
                <input class="form-button" name="do-login" type="submit" value="Dang nhap">
            </div>
            <div class="form-footer">
            Neu chua co tai khoan hay <a href="signup.php">dang ki</a>
            </div>
        </form>  -->
        </div>
       
        <script src="PluginJS/jquery.js"></script>
        <script src="PluginJS/socket.io.js"></script>
        <script src="login.js"></script>
    </body>
</html>



