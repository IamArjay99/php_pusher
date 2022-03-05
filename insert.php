<?php
    
    require_once 'database.php';
    require __DIR__ . '/vendor/autoload.php';

    if (isset($_POST['first_name']) && isset($_POST['last_name'])) {
        
        $first_name = $_POST['first_name'];
        $last_name  = $_POST['last_name'];
        $created_at = date("Y-m-d H:i:s");

        $sql = "INSERT INTO users (first_name, last_name, created_at) VALUES ('$first_name', '$last_name', '$created_at')";
        $query = $db->query($sql);
        if ($query) {
            $options = array(
                'cluster' => 'ap1',
                'useTLS' => true
            );
            $pusher = new Pusher\Pusher(
                '753fd9f4fd8b79b9d6ba',
                'a5ee7b926902e544f893',
                '1356997',
                $options
            );
        
            $data['user_id'] = $db->insert_id;
            $data['message'] = "$first_name $last_name successfully created!";

            $pusher->trigger('userChannel', 'userTable', $data);
            // $pusher->trigger('createChannel', 'createTable', $data); // CAN BE MULTIPLE TRIGGER

            header("Location: create.php");
        } else {
            echo $db->error;
        }
    }

?>