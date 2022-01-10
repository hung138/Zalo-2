<?php
include 'dbCon.php';

function checkCode() {
    if(empty($_POST['phonenumber']) || empty($_POST['code'])){
        Respone(1002, []); 
    } else {
        $sdt = $_POST['phonenumber'];
        $code = $_POST['code'];
        
        if(strlen(trim($sdt)) != 10 || $sdt[0] != '0' || !is_numeric(trim($sdt)) || strlen(trim($code)) != 4){
            Respone(1004, ['he']); 
            die();
        }
        
        $conn = connectt();
    
        $queryy = "Select * from user where sdt = '$sdt' and song = 0";
        $result = mysqli_query($conn, $queryy);
        
        if (mysqli_num_rows($result) == 0){
            // neu loi
            Respone(9995, []);
        } else{
            $sql = "Select * from sms where sdt = '$sdt' order by stt desc limit 1 ";
            $result = mysqli_query($conn, $sql);
            $sor = mysqli_num_rows($result);
            if($sor > 0){
                $row = mysqli_fetch_array($result);
                $code2 = $row[2];
                
                if($code == $code2){
                    Respone(1000, []);
                } else{
                    Respone(1004, []);
                }
            } else{
                Respone(1004, []);
            }   
        }
    }
}

checkCode();
?>


