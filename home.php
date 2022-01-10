<?php
session_start();

require ('api/logout.php');
if(!empty($_POST['get_out'])){
    LogOut();
    exit();
}

require ('api/get_basic_user_info.php');
if(!empty($_POST['get_info'])){
    GetUserInfo();
    exit();
}

require ('api/get_user_list.php');
if(!empty($_POST['get_user_list'])){
    GetListUser();
    exit();
}

require ('api/get_conversation.php');
if(!empty($_POST['moChatId'])){
    GetChat();
    exit();
}

require ('api/send_message.php');
if(!empty($_POST['guiChatId'])){
    GuiTinNhan();
    exit();
}
?>

<html>
     <head>
    <title>Online chat</title>
    <link href="PluginCSS/bootstrap.min.css" rel="stylesheet" />
    <style type="text/css">
   body{
    overflow-x: hidden;
    font-family: 'Roboto', sans-serif;
    font-size: 16px;
}

.wrap {
  padding-left: 250px;
  -webkit-transition: all 0.5s ease;
  -moz-transition: all 0.5s ease;
  -o-transition: all 0.5s ease;
  transition: all 0.5s ease;
  
}

.left{
     z-index: 1000;
     position: fixed;
     left: 250px;    
     width: 25%;
  height: 100%;
  padding-top: 0;
  margin-left: -250px;
  overflow-y: auto;
  background: #37474F;
  -webkit-transition: all 0.5s ease;
  -moz-transition: all 0.5s ease;
  -o-transition: all 0.5s ease;
  transition: all 0.5s ease;
}

.left header{
    background-color: #263238;
  font-size: 20px;
  line-height: 52px;
  text-align: center;
}

.left header a{
    color: #fff;
  display: block;
  text-decoration: none;
}
.left header a:hover {
  color: #fff;
}

.left .nav{
  
}

.left .nav a{
  background: none;
  border-bottom: 1px solid #455A64;
  color: #CFD8DC;
  font-size: 14px;
  padding: 16px 24px;
}

.left .nav a:hover{
  background: none;
  color: #ECEFF1;
}

.left .nav a i{
  margin-right: 16px;
}

.left .nav li{
    cursor: pointer;
}

#key_user{
    margin-top: 10px;
    margin-left: 10px;
    margin-bottom: 10px;
    
    background: #fafafa;
    border: 5px solid #eeeeee;
    width: 60%; 
    height: 25px;
}

#find_user{
    margin-left: 5px;
    
    background: #69d2e7;
    border: 1px solid #ddd;
    color: #ffffff; 

    width: 25%; 
    height: 25px;
}

#dsuser {
    height: 200px;
    background-color: #ECEFF1;
    
    overflow-y: scroll;
}

.right {
  width: 95%;
  position: relative;
  float: right;
}

.right .navbar{
    width: 100%;
    background-color: #ddd;
}

.right li{
    cursor: pointer;
}

#DoiTT {
    margin-top: 20px;
    margin-left: 50px;
    height: 85%;
    width: 40%;
    float: left;
    position: relative;
}

#DoiTT2 {
    margin-top: 20px;
    margin-left: 1px;
    height: 150%;
    width: 47%;
    background-color: #263238;
    float: right;
    position: relative;
    
}
    </style>
    </head>
    <body>
              
        <div class="wrap">
            <div class="left">
                <header>
                    <a>Chat online</a>
                </header>
                <ul class="nav" id="navv" >
                 <!--   <div id="search">
                        <input id="key_user" type="text" placeholder="name or sdt..." >
                        <input id="find_user" type="button" value="Tim">
                    </div> -->
                    
                    <div id="dsuser">
                        
                    </div>
                    <li class="userlist" id="danhsachuser">
                        <a>
                            <i></i> Danh sách user
                        </a>
                    </li>
                    
                 <!--   <li class="friendlist" id="friendlist">
                        <a>
                            <i></i> Danh sach ban be
                        </a>
                    </li> -->
                    
                    <li class="dangxuat" id="dangxuat">
                        <a>
                            <i></i> Đăng xuất
                        </a>
                    </li>
                </ul>    
            </div>
      
            <div class="right" id="right">
                <div class="navbar">
                    <div class="container-fluid">
                        <ul class="nav navbar-nav navbar-right">
                            <li id="showPro">    
                                <p id = "tenUser" style="font-size: 20px; float: right; margin-top: 10px ;margin-right: 10px;">
                                </p>
                                <img id="anhdd" src="source/Face.png" style="border-radius: 50%;width:50px; height:50px; float: right; margin-right: 10px;">
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="DoiTT">
                    
                </div>
                <div id="DoiTT2">
                    
                </div>
            </div>
            
        </div>
      
        <script src="./PluginJS/jquery.js"></script>
        <script src="./PluginJS/socket.io.js"></script>
        <script src="home.js"></script>
    </body>
</html>