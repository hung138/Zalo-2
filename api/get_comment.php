<?php
include 'dbCon.php';

function GetCom() {
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
            $index = 0;
            if(!empty($_POST['index'])){
                $index = $_POST['index'];
            }
            
            $count = 10;
            if(!empty($_POST['count'])){
                $count = $_POST['count'];
            }
            
            $queryy = "Select * from baiviet where id = '$bv_id'";
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
        if ($soR > 0){
            $row = array();
            $row = mysqli_fetch_array($result);      
            if($row['locked'] == 1){
                Respone(1010, []);
                die();
            }
            
            $db = [];
            $user_id = $row['id_user'];
            
            if($index <= 0){
                $sql2 = "Select * from binhluan as bl where id_baiviet = '$bv_id' order by stt desc limit ".$count;
            } else{
                $sql2 = "Select * from binhluan as bl where id_baiviet = '$bv_id' and stt < '$index' order by stt desc limit ".$count;
            }
            $result2 = mysqli_query($conn, $sql2);
            $row2 = array();
            $row2 = mysqli_fetch_all($result2); 
            $dem = 1;
            if(mysqli_num_rows($result2) > 0){
                foreach ($row2 as $va) {
                    $db['comment '.$dem]['id'] = $va[0];
                    $db['comment '.$dem]['comment'] = $va[3];
                    $db['comment '.$dem]['created'] = $va[5];
                    $db['comment '.$dem]['poster']['id'] = $va[2];
                    
                    $us_id = $va[2];
                    $sql1 = "Select * from user where id = '$us_id'";
                    $result1 = mysqli_query($conn, $sql1);
                    $row1 = mysqli_fetch_array($result1);
                    $db['comment '.$dem]['poster']['name'] = $row1['tenDN'];
                    $db['comment '.$dem]['poster']['avatar'] = $row1['linkAvatar'];
                    
                    $dem++;
                }
            }
            
            $sql5 = "Select * from block where id_user_block = '$user_id' and id_user_bi_block = '$curr_id'";
            $result5 = mysqli_query($conn, $sql5);
            if (mysqli_num_rows($result5) > 0)
            {  
                $db['is_blocked'] = 'Yes';
            } else{
                $db['is_blocked'] = 'No';
            }
  
            Respone(1000, $db);
        } else{
            Respone(9992, []);
        }
        } else{
            // toke is invalid
            Respone(9998, []);
        }
    }
}
GetCom();
?>


