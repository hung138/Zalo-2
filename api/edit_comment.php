<?php
include 'dbCon.php';

function editCom() {
    if(empty($_POST['token']) || empty($_POST['id']) || empty($_POST['id_com']) || empty($_POST['comment'])){
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
            $comm = $_POST['comment'];
            
            $queryy = "Select * from baiviet as bv, binhluan as bl where bv.id = '$bv_id' and locked = 0"
                    . " and bl.id_baiviet = bv.id and bl.stt = '$bl_id' ";
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
        if ($soR > 0){
            $sql4 = "Update binhluan set noidung = '$comm' "
            . "where stt = '$bl_id'";
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
editCom();
?>


