<?php
include 'dbCon.php';

function GetSearched() {
    if(empty($_POST['token'])){
        Respone(1002, []); 
    } else {
        $token = $_POST['token'];
        $isA = isAuth($token);
        
        if($isA == 1){
            $db = DecodeToken($token);
            $curr_id = $db['id'];
            
            $conn = connectt();
            $inde  = 0;
            if(!empty($_POST['index'])){
                $inde = $_POST['index'];
            }
            
            $count = 10;
            if(!empty($_POST['count'])){
                $count = $_POST['count'];
            }
            if($inde == 0){
                $queryy = "Select * from searched where user_id = '$curr_id' "
                    . "order by stt desc limit ".$count;
            } else{
                $queryy = "Select * from searched where user_id = '$curr_id' and stt < '$inde' "
                    . "order by stt desc limit ".$count;
            }
            $result = mysqli_query($conn, $queryy);
        
            $soR = mysqli_num_rows($result);
        if ($soR > 0){
            $row = mysqli_fetch_all($result);
            
            $db = [];
            $dem = 1;
            $tt = 'Key ';
            
            foreach ($row as $va) {
                $db[$tt.$dem]['id'] = $va[0];
                $db[$tt.$dem]['keyword'] = $va[2];
                $db[$tt.$dem]['created'] = $va[3];
                
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
GetSearched();
?>




