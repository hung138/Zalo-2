<?php
include 'dbCon.php';

function LogIn() {
    if(empty($_POST['phonenumber'])){
        Respone(1002, []); 
    } else {
        $sdt = $_POST['phonenumber'];
        
        if(strlen(trim($sdt)) != 10 || $sdt[0] != '0' || !is_numeric(trim($sdt))){
            Respone(1004, []); 
            die();
        }
        
        $conn = connectt();
    
        $queryy = "Select * from user where sdt = '$sdt' and song = 0";
        $result = mysqli_query($conn, $queryy);
        
        if (mysqli_num_rows($result) == 0){
            // neu loi
            Respone(9995, []);
        } else{            
            $code = random_int(1000, 9999);
            
            date_default_timezone_set("Asia/Bangkok");
            $ngay = date('Y-m-d H:i:s', time());
            
            $sql = "INSERT INTO sms (stt, sdt, code, ngay) VALUES "
                . "('null', '$sdt', '$code', '$ngay')";
            $result = mysqli_query($conn, $sql);
          
            Respone(1000, []);
        }
    }
}

LogIn();
?>
