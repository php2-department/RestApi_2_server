<?php
header('content-type:application/json');
include 'dbcon1.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$id = $_POST['id'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	if($id == ""){
		$resultData = array('error' => true, 'message' => 'ID is Required');
		echo json_encode($resultData);
		return;
	}
	if(!is_numeric($id)){
		$resultData = array('error' => true, 'message' => 'ID is Must Be Numaric');
		echo json_encode($resultData);
		return;
	}
	if($name == ""){
		$resultData = array('error' => true, 'message' => 'Name is Required');
		echo json_encode($resultData);
		return;
	}
	if($email == ""){
		$resultData = array('error' => true, 'message' => 'Email is Required');
		echo json_encode($resultData);
		return;
	}
    if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",$email)){
    	$resultData = array('error' => true, 'message' => 'Invalid Emial-ID Insert Again');
		echo json_encode($resultData);
		return;
	}
	if(isEmailAreadyExist($conn,$email)){
		$resultData = array('error' => true, 'message' => 'Email is Already Exist In Server');
		echo json_encode($resultData);
		return;
	}
	$stmt = $conn->prepare("INSERT INTO `member`(`id`,`name`,`email`) VALUES (?,?,?)");
	$stmt->bind_param('iss',$id,$name,$email);
	if($stmt->execute()){
		$resultData = array(
			'error' => false,
			'message' => 'Data Inserted Successfully',
			'status'=>200
		);
		echo json_encode($resultData);
		return;
	}
	else{
		$resultData = array('error' => true, 'message' => $stmt->error);
		echo json_encode($resultData);
		return;	
	}
}
else{
	$resultData = array('error' => true, 'message' => 'Invalid Request');
		echo json_encode($resultData);
		return;
}
function isEmailAreadyExist($conn, $email){
	$query = "SELECT * FROM `member` WHERE email = '$email'";
	if($result = $conn->query($query)){
		if($result->num_rows > 0){
			return true;
		}
		return false;
		}
}
?>