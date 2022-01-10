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
            //$db['modified'] = '';
            
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
        /*    if ($row['locked'] == '0')
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
            }*/
            
            return $db;
        } else{
            Respone(9992, []);
            die();
        }
}

function GetListPost() {
    if(empty($_POST['token']) || empty($_POST['keyword']) || empty($_POST['count'])){
        Respone(1002, []); 
    } else {
        $token = $_POST['token'];
        $isA = isAuth($token);
        
        if($isA == 1){
            $db = DecodeToken($token);
            $curr_id = $db['id'];
            
            $conn = connectt();
            $keyy = $_POST['keyword'];
            $count = $_POST['count'];
            
         /*   $inde = 0;
            if(!empty($_POST['index'])){
                $inde = $_POST['index'];
            }*/
            
            $key_split = explode(' ', $keyy);
            
            $db = [];
            $tenP = 'Post ';
            $dem = 1;
            
            $daLay = [];
            foreach ($key_split as $k) {

            $queryy = "Select * from baiviet where noidung like '%$k%' order by id desc LIMIT ".$count;
            $result = mysqli_query($conn, $queryy);
        
            $row = array();
            $row = mysqli_fetch_all($result);           
            
            foreach ($row as $va) {
                if(!in_array($va[0], $daLay)){
                    $db[$tenP.$dem] = GetPostt($va[0], $curr_id);
                    $daLay[] = $va[0];
                    $dem++;
                }
            }
            }
            
            date_default_timezone_set("Asia/Bangkok");
            $ngay = date('Y-m-d H:i:s', time());
            
            $queryy = "Select * from searched where noidung = '$keyy' and user_id = '$curr_id'";
            $result = mysqli_query($conn, $queryy);
            $ro = mysqli_num_rows($result);
            
            if($ro > 0){
                $sql = "Update searched set ngay = '$ngay' where noidung = '$keyy' and user_id = '$curr_id'";
                $result = mysqli_query($conn, $sql);
            } else{
                $sql = "INSERT INTO searched (stt, user_id, noidung, ngay) VALUES "
                . "('null', '$curr_id', '$keyy', '$ngay')";
                $result = mysqli_query($conn, $sql);
            }
            
            Respone(1000, $db);
        } else{
            // toke is invalid
            Respone(9998, []);
        }
    }
}

GetListPost();
?>




