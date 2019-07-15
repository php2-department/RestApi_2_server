<?php
include('dbcon2.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>API</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
     <div id = "message"></div>
    <div class="col-md-6" id = "partner2">
    </div>
    <div class="col-md-6" id = "partner1">
        <h3>partner 1</h3>
        <table id = "p2tbl" class="table">
            <tr>
                <th>Id</th>
                <th>Email</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
            
        </table>
    </div>
<script>   
   $(document).ready(function() {
        addrecord1();
    });
    function addrecord1() {
        var addrecord1 = "addrecord1";
        $.ajax({
            url:"p2data.php",
            type:"post",
            data:{addrecord1:addrecord1},
            success:function(data,status){
                $('#partner2').html(data);
                console.log('hii');
            }

        });
    }
    $(document).ready(function() {
        addrecord();
    });
    function addrecord() {
        var addrecord = "addrecord";
        $.ajax({
            url:"http://localhost/rest_api/p1/p1data.php",
            type:"post",
            data:{addrecord:addrecord},
            success:function(data,status){
                console.log(data);
                var tbl = '';
                $.each(data.data, function(index, value){
                console.log(value);
                tbl += '<tr>';
                tbl += '<td class="id" data-myval ='+value.id+'>'+value.id+'</td>';
                tbl += '<td class="email" data-myval ='+value.email+'>'+value.email+'</td>';
                tbl += '<td class="name" data-myval ='+value.name+'>'+value.name+'</td>';
                tbl += '<td><button class="btn btn-primary b_click">Add</button></td>';
                tbl += '<tr>';
            });
                
                $('#p2tbl').append(tbl);
            },
            error:function(data, status) {
                console.log(status);
            }
        });
    }
    $(document).ready(function() {
        $('#p2tbl').on('click', '.b_click', function(){
            console.log('hi');
            var row = $(this).closest('tr'); 
            var id = row.find('td:eq(0)').text();
            var email = row.find('td:eq(1)').text();
            var name = row.find('td:eq(2)').text();
            var dataString = 'id='+ id + '&email='+ email + '&name='+ name;
            $.ajax({
                type: "post",
                url: "insert_data2.php",
                data: dataString,
                success: function(data, status) {
                    console.log(data);
                    alert(data.message, "\nStatus: " + status);
                    addrecord1();
                }
            });
        });
    });
</script>
</body>
</html>