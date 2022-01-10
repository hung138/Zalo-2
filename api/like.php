<?php
include 'dbCon.php';

function SetCom() {
    if(empty($_POST['token']) || empty($_POST['id'])){
        Respone(1002, []); 
    } else {
        $token = $_POST['token'];
        $isA = isAuth($token);
        
        if($isA == 1){
            $db = DecodeToken($token);
            $curr_id = $db['id'];
            
            $conn = connectt();
            $bv_id = $_POST['id'];
            
            $queryy = "Select * from baiviet where id = '$bv_id' and locked = 0";
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
        if ($soR > 0){
            $queryy2 = "Select * from thich where id_baiviet = '$bv_id' and id_user = '$curr_id'";
            $result2 = mysqli_query($conn, $queryy2);
            $soR = mysqli_num_rows($result2);
            
            if($soR > 0){ // da like, phai dislike
                $queryy2 = "Delete from thich where id_baiviet = '$bv_id' and id_user = '$curr_id'";
                mysqli_query($conn, $queryy2);
            } else{
                date_default_timezone_set("Asia/Bangkok");
                $ngay = date('Y-m-d H:i:s', time());
            
                $queryy2 = "INSERT INTO thich (id_baiviet, id_user, ngay) VALUES "
                . "('$bv_id', '$curr_id', '$ngay')";
                mysqli_query($conn, $queryy2);
            }
            
            $queryy2 = "Select * from thich where id_baiviet = '$bv_id'";
            $result2 = mysqli_query($conn, $queryy2);
            $soR = mysqli_num_rows($result2);
  
            $d['like'] = $soR;
            Respone(1000, $d);
        } else{
            Respone(9992, []);
        }
        } else{
            // toke is invalid
            Respone(9998, []);
        }
    }
}
SetCom();
?>
