<?php
include 'dbCon.php';

function LogIn() {
    if(empty($_POST['soDT']) || empty($_POST['passDN'])){
        Respone(1002, []); 
    } else {
        $sdt = $_POST['soDT'];
        $password = $_POST['passDN'];
        if(strlen(trim($sdt)) != 10 || $sdt[0] != '0' || !is_numeric(trim($sdt)) || strlen(trim($password)) < 8){
            Respone(1004, []); 
            die();
        }
    
        $conn = connectt();
    
        $queryy = "Select * from user where sdt = '$sdt' and matkhau = '$password' and song = 0";
        $result = mysqli_query($conn, $queryy);
        
        if (mysqli_num_rows($result) == 0){
            // neu loi
            Respone(9995, []);
        } else{
            $row = mysqli_fetch_array($result);
            
            $db = [];
            $db['id'] = $row['id'];
            $db['ten'] = $row['tenDN'];
            /*$db['mat khau'] = $row['matkhau'];
            $db['so dien thoai'] = $row['sdt'];*/
            $tok = GetToken($row['sdt'], $row['id']);
            $db['token'] = $tok;
            $db['avatar'] = $row['linkAvatar'];
            $db['active'] = $row['song'];
            
            date_default_timezone_set("Asia/Bangkok");
            $ngay = date('Y-m-d H:i:s', time());
    
            $idd = $row['id'];
            $queryy = "Update user set last_login = '$ngay' where id = '$idd' ";
            $result = mysqli_query($conn, $queryy);
            
            //$db['last_login'] = $ngay;
            Respone(1000, $db);
        }
    }
}

LogIn();
?>