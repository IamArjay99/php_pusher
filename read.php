<?php 

    require_once 'database.php';

    if (isset($_POST['user_id'])) {
        $html = '';

        $sql = "SELECT * FROM users WHERE user_id = " . $_POST['user_id'];
        $query = $db->query($sql);

        if ($query) {
            while ($row = mysqli_fetch_assoc($query)) {
                $user_id    = $row['user_id'];
                $first_name = $row['first_name'];
                $last_name  = $row['last_name'];
                $created_at = date("F d, Y H:i A", strtotime($row['created_at']));

                $html .= "
                <tr class='text-center new-user'>
                    <td>$user_id</td>
                    <td>$first_name</td>
                    <td>$last_name</td>
                    <td>$created_at</td>
                    <td></td>
                </tr>";
            }

        }
        echo $html;
    }