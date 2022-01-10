<?php

include 'dbCon.php';

function GetPostt($bv_id, $curr_id) {
            $conn = connectt();
            
            $queryy = "Select * from baiviet where id = '$bv_id'";
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
        if ($soR > 0){
            $row = array();
            $row = mysqli_fetch_array($result);
                    
            $db = [];
            $db['id'] = $row['id'];
            $db['described'] = $row['noidung'];
            $db['created'] = $row['tgTao'];
            $db['modified'] = '';
            
            $sql4 = "Select count(id_baiviet) from thich where id_baiviet = '$bv_id'";
            $result4 = mysqli_query($conn, $sql4);
            $row4 = mysqli_fetch_array($result4);
            $db['like'] = $row4[0];
            
            $sql3 = "Select count(id_baiviet) from binhluan where id_baiviet = '$bv_id'";
            $result3 = mysqli_query($conn, $sql3);
            $row3 = mysqli_fetch_array($result3);
            $db['comment'] = $row3[0];
            
            $sql2 = "Select * from thich where id_baiviet = '$bv_id' and id_user = '$curr_id'";
            $result2 = mysqli_query($conn, $sql2);
            $soR2 = mysqli_num_rows($result2);
            if($soR2 > 0){
                $db['is_liked'] = '1';
            } else{
                $db['is_liked'] = '0';
            }
            
            $db['image'] = $row['media'];
            $db['video'] = $row['media2'];
            
            $user_id = $row['id_user'];
            $sql1 = "Select * from user where id = '$user_id'";
            $result1 = mysqli_query($conn, $sql1);
            $row1 = mysqli_fetch_array($result1);
            $db['author']['id'] = $row1['id'];
            $db['author']['name'] = $row1['tenDN'];
            $db['author']['avatar'] = $row1['linkAvatar'];
            
            //$db['state'] = $row1['song'];
            if ($row['locked'] == '0')
            {  
                $db['state'] = 'open';
            } else{
                $db['state'] = 'locked';
            }
            
            $sql5 = "Select * from block where id_user_block = '$user_id' and id_user_bi_block = '$curr_id'";
            $result5 = mysqli_query($conn, $sql5);
            if (mysqli_num_rows($result5) > 0)
            {  
                $db['is_blocked'] = 'Yes';
            } else{
                $db['is_blocked'] = 'No';
            }
           
            if ($row['locked'] != '0' || $user_id != $curr_id)
            {  
                $db['can_edit'] = 'No';
            } else{
                $db['can_edit'] = 'Yes';
            }
            
            if ($row['comment'] == '0')
            {  
                $db['can_comment'] = 'Yes';
            } else{
                $db['can_comment'] = 'No';
            }
            
            return $db;
        } else{
            Respone(9992, []);
        }
}

function GetListPost() {
    if(empty($_POST['token'])){
        Respone(1002, []); 
    } else {
        $token = $_POST['token'];
        $isA = isAuth($token);
        
        if($isA == 1){
            $db = DecodeToken($token);
            $curr_id = $db['id'];
            
            $conn = connectt();
            
            $bv_id  = 0;
            if(!empty($_POST['last_id'])){
                $bv_id = $_POST['last_id'];
            }
            
            $bd_id  = $bv_id - 1;
            if(!empty($_POST['index'])){
                $bd_id = $_POST['index'];
            }
            
            $count = 20;
            if(!empty($_POST['count'])){
                $count = $_POST['count'];
            }
            if($count <= 0/* || $bv_id < 0 || $bd_id >= $bv_id*/){
                Respone(1004, []);
                die();
            }
            if($bv_id > 0){
                $queryy = "Select id from baiviet where id <= ".$bd_id." order by id desc LIMIT ".$count;
            } else{
                $queryy = "Select id from baiviet order by id desc LIMIT ".$count;
            }
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
        if ($soR > 0){
            $row = array();
            $row = mysqli_fetch_all($result);           
            
            $db = [];
            $tenP = 'Post ';
            $dem = 1;
            foreach ($row as $va) {
                $db[$tenP.$dem] = GetPostt($va[0], $curr_id);
                $dem++;
            }
            Respone(1000, $db);
        } else{
            Respone(9994, []);
        }
        } else{
            // toke is invalid
            Respone(9998, []);
        }
    }
}

GetListPost();
?>




