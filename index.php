<?php 
    require_once 'database.php';
    require __DIR__ . '/vendor/autoload.php';

    $data  = [];
    $sql   = "SELECT * FROM users";
    $query = $db->query($sql);
    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) $data[] = $row;
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Pusher</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <style>
        .new-user {
            background: #32f1b2;
        }
    </style>
</head>
<body>
    
    <div class="container py-5">
        <table class="table table-striped table-hover" id="tableUsers">
            <thead>
                <tr class="text-center">
                    <td>No.</td>
                    <td>First Name</td>
                    <td>Last Name</td>
                    <td>Created At</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody id="tableUsersTbody">
            
            <?php
                if ($data && count($data)) {
                    foreach ($data as $i => $dt) {
            ?>
                <tr class="text-center">
                    <td><?= $dt['user_id'] ?></td>
                    <td><?= $dt['first_name'] ?></td>
                    <td><?= $dt['last_name'] ?></td>
                    <td><?= date("F d, Y H:i A", strtotime($dt['created_at'])) ?></td>
                    <td></td>
                </tr>
            <?php
                    }
                } else {
            ?>
                <tr id="tableNoDataRow">
                    <td class="text-center" colspan="5">No data found.</td>
                </tr>
            <?php
                }
            ?>
            </tbody>
        </table>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('753fd9f4fd8b79b9d6ba', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('userChannel');
        channel.bind('userTable', function(data) {
            let { user_id, message } = data;
            
            $.ajax({
                method: "POST",
                url: "read.php",
                data: { user_id },
                async: true,
                dataType: "html",
                success: function(data) {
                    $("#tableNoDataRow").remove();
                    $("#tableUsersTbody").append(data);

                    setTimeout(function() {
                        $('.new-user').removeClass('new-user')
                    }, 5000);
                }
            })
        });
    </script>

</body>
</html>