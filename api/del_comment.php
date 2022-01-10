<?php
include 'dbCon.php';

function DelCom() {
    if(empty($_POST['token']) || empty($_POST['id']) || empty($_POST['id_com'])){
        Respone(1002, []); 
    } else {
        $token = $_POST['token'];
        $isA = isAuth($token);
        
        if($isA == 1){
            $db = DecodeToken($token);
            $curr_id = $db['id'];
            
            $conn = connectt();
            $bv_id = $_POST['id'];
            $bl_id = $_POST['id_com'];
            
            $queryy = "Select * from baiviet where id = '$bv_id' and locked = 0";
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
        if ($soR > 0){
            $sql4 = "Delete from binhluan where stt = '$bl_id' and id_baiviet = '$bv_id'";
            $result4 = mysqli_query($conn, $sql4);
            
            if($result4){
                Respone(1000, []);
            } else{
                Respone(1001, []);
            }
        } else{
            Respone(9992, []);
        }
        } else{
            // toke is invalid
            Respone(9998, []);
        }
    }
}
DelCom();
?>


