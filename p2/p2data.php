<?php   
include ('dbcon2.php');
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
}
?>