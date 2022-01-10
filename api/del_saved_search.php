<?php
include 'dbCon.php';

function DelSearched() {
    if(empty($_POST['token']) || empty($_POST['search_id'])){
        Respone(1002, []); 
    } else {
        $token = $_POST['token'];
        $isA = isAuth($token);
        
        if($isA == 1){
            $db = DecodeToken($token);
            $curr_id = $db['id'];
            
            $conn = connectt();
            $bv_id = $_POST['search_id'];
            $all = 0;
            if(!empty($_POST['all'])){
                $all = $_POST['all'];
            }
            
            if($all < 0 || $all > 1){
                 Respone(1004, []);
                 die();
            }
            
            if($all == 0){
                $queryy = "Select * from searched where user_id = '$curr_id' and stt = '$bv_id'";
            } else{
                $queryy = "Select * from searched where user_id = '$curr_id' ";
            }
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
        if ($soR > 0){
            if($all == 0){
                $sql4 = "Delete from searched where stt = '$bv_id' and user_id = '$curr_id'";
                $result4 = mysqli_query($conn, $sql4);
            } else{
                $sql4 = "Delete from searched where user_id = '$curr_id'";
                $result4 = mysqli_query($conn, $sql4);
            }
            
            if($result4){
                Respone(1000, []);
            } else{
                Respone(1001, []);
            }
        } else{
            Respone(9994, []);
        }
        } else{
            // toke is invalid
            Respone(9998, []);
        }
    }
}
DelSearched();
?>


