<?php
require("init.php");
$submitted_username = '';
$telo="";
if(!empty($_POST))
{
$query = "
SELECT
*
FROM admin
WHERE
username = :username
";
$query_params = array(
':username' => $_POST['username']
);
try
{
$stmt = $db->prepare($query);
$result = $stmt->execute($query_params);
}
catch(PDOException $ex)
{
die("Failed to run query: " . $ex->getMessage());
}
$login_ok = false;
$row = $stmt->fetch();
if($row)
{
$check_password = md5($_POST['password']);
if($check_password === $row['password'])
{
unset($row['password']);
$_SESSION['user'] = $row;
$_SESSION['admin'] = "yeah";
header("Location: admin.php");
die("Redirecting to: admin.php");
}
elseif($check_password !== $row['password']){
$telo="<div class='notification is-danger'>Wrong Password</div>";
$submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
}
else{
$telo="<div class='notification is-danger'>Login failed</div>";
$submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
}
}
}
?>
    <!DOCTYPE html>

    <head>
        <title>GasOnline</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/bulma.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>
        <div class="modal is-active columns">
            <div class="modal-background"></div>
            <div class="modal-card column is-4">
                <header class="modal-card-head">
                    <p class="modal-card-title">Admin</p>
                </header>
                <form action="logini.php" method="post">
                    <section class="modal-card-body">
                    <?php if(isset($telo)){ echo $telo; } ?>
                        <div class="field">
                            <p class="control has-icons-left has-icons-right">
                                <input class="input is-danger" type="text" placeholder="Username" name="username" autofocus>
                                <span class="icon is-small is-left">
      <i class="fa fa-user"></i>
    </span>
                            </p>
                        </div>
                        <div class="field">
                            <p class="control has-icons-left">
                                <input class="input is-danger" type="password" placeholder="Password" name="password">
                                <span class="icon is-small is-left">
      <i class="fa fa-lock"></i>
    </span>
                            </p>
                        </div>
                        <nav class="level">
                            <div class="level-item">
                                <input type="submit" class="button is-danger" value="Masuk">
                            </div>
                        </nav>
                    </section>
                    <footer class="modal-card-foot">
                        <p>Bukan admin? Masuk <a href="login.php">di sini</a></p>
                    </footer>
                </form>
            </div>
        </div>
    </body>

    </html>
