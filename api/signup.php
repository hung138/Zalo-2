<?php
include 'dbCon.php';
//include 'upload.php';

function SignUp() {
    if(empty($_POST['tenDK']) || empty($_POST['soDtDK']) || empty($_POST['passDK'])){
        Respone(1002, []); 
    } else {
        $username = $_POST['tenDK'];
        $sdt = $_POST['soDtDK'];
        $password = $_POST['passDK'];
        $avat = '';
        
        if(strlen(trim($sdt)) != 10 || $sdt[0] != '0' || !is_numeric(trim($sdt)) || strlen(trim($password)) < 8){
            $da = [];
            $da[] = strlen(trim($sdt));
            $da[] = strlen(trim($sdt));
            Respone(1004, []); 
        } else{
            $dchi = 'http://localhost/Zaloo/api/';
            $avat = $dchi.uploadImage('avatar');
            
            if($avat == $dchi){
                Respone(1002, []);
                die();
            }
            $conn = connectt();
    
        $queryy = "Select * from user where sdt = '$sdt'";
        $result = mysqli_query($conn, $queryy);
        
        if (mysqli_num_rows($result) > 0){
            // neu loi
            Respone(9996, []); 
        } else{
            $sql = "INSERT INTO user (id, tenDN, matkhau, sdt, linkAvatar, quyen) VALUES "
                . "('null', '$username', '$password', '$sdt', '$avat', '0')";
            
            if (mysqli_query($conn, $sql)){
                Respone(1000,[]);
            } else {
                Respone(1001,[]);
            }
        }}
    }
}

SignUp();
?>