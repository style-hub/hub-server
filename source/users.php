<?php
    // include header and database connections
    require('header.php');
    require('include/db_connect.inc.php');
    if(!$_SESSION['moderator']){
        header('Location: index.php'); // Only moderators should se the user list
    }
?>

<main role="main">
<div class="container py-3">
    <h1>Users</h1>
    <table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">UserName</th>
            <th scope="col">UserEmail</th>
            <th scope="col">Moderator</th>
            <th scope="col">Edit</th>
        </tr>
    </thead>
    <tbody>
    <?php
        // List all users from the users table in the table
        $sql = "SELECT * FROM users ORDER BY username;";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $username = $row['username'];
                $useremail = $row['useremail'];
                if($row['moderator']){
                    $usermoderator = 'Yes';
                } else {
                    $usermoderator = ' ';
                }
                echo('<tr>');
                echo('<td>'.$id.'</td>');
                echo('<td>'.$username.'</td>');
                echo('<td><a href="mailto:'.$useremail.'?subject=A message from the QGIS-Hub moderators">'.$useremail.'</a></td>');
                echo('<td>'.$usermoderator.'</td>');
                echo('<td><a href="#">edit</a></td>');
                echo('</tr>');
            }
        }

    ?>
    </tbody>
    </table>
</div><!-- container -->
</main>

<?php
    require('footer.php');
?>