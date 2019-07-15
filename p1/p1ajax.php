<?php 
include ('dbcon1.php');
if (isset($_POST['readrecord'])) {
    $data = '<h3>partner 1</h3><table class="table">
    <tr>
        <th>No</th>
        <th>Id</th>
        <th>Email</th>
        <th>Name</th>
    </tr>';
    $sql = "SELECT * FROM member";
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
}
if (isset($_POST['readrecord1'])) {
    $data = '<h3>partner 1</h3><table class="table">
    <tr>
        <th>No</th>
        <th>Id</th>
        <th>Email</th>
        <th>Name</th>
        <th>Action</th>
    </tr>';
    $sql = "SELECT * FROM member";
    $query = mysqli_query($conn, $sql);
    while ($result = mysqli_fetch_assoc($query)) {
        $data .= '<tr>
            <td>' .$result['no']. '</td>
            <td>' .$result['id']. '</td>
            <td>' .$result['email']. '</td>
            <td>' .$result['name']. '</td>
            <td><button class = "btn btn-primary">Add</button></td>
            </tr>';
    }
    $data .= '</table>';
    echo $data;
}
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $check_sql = "SELECT * FROM member WHERE email = '$email' AND name = '$name'";
    $query = mysqli_query($conn, $check_sql);
    $row = mysqli_num_rows($query);
    if ($row == 0) {
        $add_sql = "INSERT INTO member (id, email, name) VALUES ('$id', '$email', '$name')";
        $query = mysqli_query($conn, $add_sql);
    } else {
        $error = "Already available member in your list";
        echo "$error";
    }
}
?>