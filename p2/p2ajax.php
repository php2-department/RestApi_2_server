<?php
header('Content-Type: application/json');
include ('dbcon2.php');

// if (isset($_POST['addrecord'])) {
    /*$data = '<h3>partner 2</h3><table class="table" id="p2tbl">
    <tr>
        <th>No</th>
        <th>Id</th>
        <th>Email</th>
        <th>Name</th>
        <th>Action</th>
    </tr>';*/

    $sql = "SELECT * FROM members";
    $query = mysqli_query($conn, $sql);
    $data = array();
    while ($result12 = mysqli_fetch_assoc($query)) {
        $id = $result12['id'];
        $email = $result12['email'];
        $name = $result12['name'];
        

            $data[] =array('id'=>$id, 'email'=>$email, 'name'=>$name);
    }
    // $data .= '</table>';


    // echo json_encode($data);

     
if (!empty($data)) {
    $result['status'] = 200;
    $result['msg'] = "ok";
    $result['data'] = $data;
   
} else {
     $result['status'] = 403;
    $result['msg'] ="data not found";
    

   
}

echo json_encode($result);

    /*

if (isset($_POST['addrecord1'])) {
    $data = '<h3>partner 2</h3><table class="table">
    <tr>
        <th>No</th>
        <th>Id</th>
        <th>Email</th>
        <th>Name</th>
        
    </tr>';

    $sql = "SELECT * FROM members";
    $query = mysqli_query($conn, $sql);
    while ($result = mysqli_fetch_assoc($query)) {
        $data .= '<tr>
            <td>' .$result['no']. '</td>
            <td>' .$result['id']. '</td>
            <td>' .$result['email']. '</td>
            <td>' .$result['name']. '</td>
            </tr>';
    }
    $data .= '</table>';
    echo $data;
}*/

?>

