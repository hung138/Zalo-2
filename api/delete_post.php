<?php
include 'dbCon.php';

function DelPost() {
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
            
            $queryy = "Select * from baiviet where id = '$bv_id'";
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
        if ($soR > 0){
            $sql4 = "Delete bv.*, bl.*, t.* from baiviet as bv, binhluan as bl, thich as t where bv.id = '$bv_id'"
                    . " and bv.id = bl.id_baiviet and t.id_baiviet = bv.id";
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
DelPost();
?>
