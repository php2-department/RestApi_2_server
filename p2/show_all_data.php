<?php

include('dbcon2.php');

$sql = "SELECT * FROM `members`";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>API</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
	<table id="mytable" class="table table-striped">
    <thead>
      <tr>
        <th>id</th>
        <th>name</th>
        <th>Email</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0) {
      	while($row = $result->fetch_assoc()){
      	?>
      	<tr id="<?php echo $row['no'];  ?>" >
      		<td id="id-<?php echo $row['no'];  ?>"><?php echo $row['id']; ?></td>
      		<td class="name-<?php echo $row['no'];  ?>"><?php echo $row['name']; ?></td>
      		<td class="email-<?php echo $row['no'];  ?>"><?php echo $row['email']; ?></td>
      		<td class="btn"><input type="button" value="Add" class="btn btn-primary"></td>
    <?php }
  			} ?>
    </tbody>
  </table>

  <script type="text/javascript">
  	$(document).ready(function(){
	    $("tr input[type=button]").on('click', function(e){
	        var row_id = $(this).closest('tr');

	      	var send_id = row_id.find("td:eq(0)").text();
	      	var send_name = row_id.find("td:eq(1)").text();
	      	var send_email = row_id.find("td:eq(2)").text();
	        
	        var url ="http://localhost/rest_api/p1/insert_data.php";
	        $.post(url,{
	        	id: send_id,
	        	name: send_name,
	        	email: send_email
	        },
	        function(data,status){
				alert(data.message, "\nStatus: " + status);
		    });
	    });
	});
  </script>
</body>
</html>