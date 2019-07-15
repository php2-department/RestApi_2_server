<?php
header('Content-Type: application/json');
include ('dbcon1.php');


    $sql = "SELECT * FROM member";
    $query = mysqli_query($conn, $sql);
    $data = array();
    while ($result12 = mysqli_fetch_assoc($query)) {
        $id = $result12['id'];
        $email = $result12['email'];
        $name = $result12['name'];
        

            $data[] =array('id'=>$id, 'email'=>$email, 'name'=>$name);
    }

     
if (!empty($data)) {
    $result['status'] = 200;
    $result['msg'] = "ok";
    $result['data'] = $data;
   
} else {
     $result['status'] = 403;
    $result['msg'] ="data not found";
    

   
}

echo json_encode($result);

?>

