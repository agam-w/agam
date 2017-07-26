<?php 
    require("init.php"); 
    $msg="";
    if (isset($_SESSION['msg'])) {
      $msg="<div class='notification is-".$_SESSION['msg']['type']."'>".$_SESSION['msg']['body']."</div>";
      unset($_SESSION['msg']);
    }
    if(!empty($_POST)) 
    {
        if(empty($_POST['username'])) 
        { 
            $_SESSION['msg']['type']="warning";
            $_SESSION['msg']['body']="Tolong pilih username";
            header("Location: register.php"); 
            die("Please enter a username."); 
        } 
         
        if(empty($_POST['password'])) 
        { 
            $_SESSION['msg']['type']="warning";
            $_SESSION['msg']['body']="Tolong masukkan kata sandi";
            header("Location: register.php");
            die("Please enter a password."); 
        } 
         
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
        { 
            $_SESSION['msg']['type']="danger";
            $_SESSION['msg']['body']="Apakah anda yakin alamat email anda sudah benar?";
            header("Location: register.php");
            die("Invalid E-Mail Address"); 
        } 
         
        $query = " 
            SELECT 
                1 
            FROM owners 
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
            $_SESSION['msg']['type']="danger";
            $_SESSION['msg']['body']="Kesalahan! (Bukan salah Anda)";
            header("Location: register.php");
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        $row = $stmt->fetch(); 
         
        if($row) 
        { 
            $_SESSION['msg']['type']="warning";
            $_SESSION['msg']['body']="Username sudah digunakan, harap memilih username yang lain";
            header("Location: register.php");
            die("This username is already in use"); 
        } 
         
        $query = " 
            SELECT 
                1 
            FROM owners 
            WHERE 
                email = :email 
        "; 
         
        $query_params = array( 
            ':email' => $_POST['email'] 
        ); 
         
        try 
        { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            $_SESSION['msg']['type']="danger";
            $_SESSION['msg']['body']="Kesalahan! (Anda tidak salah kok)";
            header("Location: register.php");
            die("Failed to run query: " . $ex->getMessage());
        } 
         
        $row = $stmt->fetch(); 
         
        if($row) 
        { 
            $_SESSION['msg']['type']="warning";
            $_SESSION['msg']['body']="Alamat email sudah terdaftar, tolong masukkan alamat email yang lain";
            header("Location: register.php");
            die("This email address is already registered"); 
        } 
         
        $query = " 
            INSERT INTO owners ( 
                username, 
                password, 
                salt,
                email,
                name,
                phone,
                company
            ) VALUES ( 
                :username, 
                :password, 
                :salt, 
                :email,
                :name,
                :phone,
                :company
            ) 
        "; 
         
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
         
        $password = hash('sha256', $_POST['password'] . $salt); 
         
        for($round = 0; $round < 65536; $round++) 
        { 
            $password = hash('sha256', $password . $salt); 
        } 
         
        $query_params = array( 
            ':username' => $_POST['username'], 
            ':password' => $password, 
            ':salt' => $salt, 
            ':email' => $_POST['email'],
            ':name' => $_POST['name'],
            ':phone' => $_POST['phone'],
            ':company' => $_POST['company']
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
         
        $_SESSION['message'] = "Account Created Please Login First"; 
        header("Location: login.php"); 
        die("Redirecting to login.php"); 
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
    <nav class="navbar">
        <div class="navbar-brand">
            <a class="navbar-item" href="#">
                    <span class="icon is-medium"><i class="fa fa-car"></i></span>
                    <span class="title" style="margin-left: .3em">GasOnline</span>
                </a>
            <div class="navbar-burger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div class="navbar-menu">
            <div class="navbar-end">
                <a class="navbar-item" href="login.php">Masuk</a>
            </div>
        </div>
    </nav>
    <section class="section">
        <div class="container columns">
            <div class="column is-2"></div>
            <div class="box column is-8">
                <?php echo $msg; ?>
                <h1 class="title" align="center">Pendaftaran Pengguna Baru</h1>
                <form action="register.php" method="post">
                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">Nama:</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control">
                                    <input class="input" type="text" placeholder="Nama" name="name" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">Perusahaan:</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control">
                                    <input class="input" type="text" placeholder="Perusahaan" name="company" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">Email:</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control">
                                    <input class="input" type="text" placeholder="Text input" name="email" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">No. telepon:</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control">
                                    <input class="input" type="text" placeholder="No. telepon" name="phone" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">Username:</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control">
                                    <input class="input" type="text" placeholder="Username" name="username" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">Password:</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control">
                                    <input class="input" type="password" placeholder="Password" name="password" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="button is-success is-pulled-right" value="Daftar">
                </form>
            </div>
            <div class="column is-2"></div>
        </div>
    </section>
</body>

</html>