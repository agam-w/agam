<?php
require("init.php");
if(empty($_SESSION['user']))
{
header("Location: logini.php");
die("Redirecting to login.php");
}
if ($_SESSION['user']['username']!='admin') {
    header('location:index.php');
    die("you're not an admin");
}
?>
    <!DOCTYPE html>

    <head>
        <title>GasOnline</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="assets/core.css">
        <link rel="stylesheet" href="assets/bulma.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="assets/jquery.min.js"></script>
        <script src="assets/velocity.min.js"></script>
        <script src="assets/velocity.ui.js"></script>
        <script src="assets/core.js"></script>

        <body>
            <nav class="navbar" style="top: 0;left: 0;right: 0;position: fixed;z-index: 2;">
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
                        <a class="navbar-item is-hidden-mobile" onclick="editadmin();">Edit data</a>
                        <span page="vehicles" class="menu navbar-item is-hidden-desktop">
                            <a>
                        <span class="icon"><i class="fa fa-car"></i></span>
                        <span>Daftar Kendaraan</span>
                        </a>
                        </span>
                        <span class="menu navbar-item is-hidden-desktop" page="orders">
                            <a>
                        <span class="icon"><i class="fa fa-phone"></i></span>
                        <span>Daftar Pemesanan</span>
                        </a>
                        </span>
                        <span page="users" class="menu navbar-item is-hidden-desktop">
                            <a>
                        <span class="icon"><i class="fa fa-user"></i></span>
                        <span>Daftar Pengguna</span>
                        </a>
                        </span>
                        <span class="navbar-item">
                        <span class="tag is-primary is-medium">
<?php
echo $_SESSION['user']['username'];
?>
  <button class="delete is-small" onclick="location='logout.php';"></button>
</span></span>
                    </div>
                </div>
            </nav>
            <div class="modyal">
                <?php
        if (isset($_SESSION['result'])) {
            if ($_SESSION['result']['message']=="ok") {
                echo "<div class='notification is-success msg'>Perubahan berhasil disimpan</div>";
            } else{
                echo "<div class='notification is-danger msg'>Ada kesalahan!</div>";
            }
        }
        ?>
            </div>
            <div class="tabs is-medium is-fullwidth is-boxed is-hidden-mobile">
                <ul>
                    <li page="vehicles">
                        <a>
                        <span class="icon"><i class="fa fa-car"></i></span>
                        <span>Daftar Kendaraan</span>
                    </a>
                    </li>
                    <li class="is-active" page="orders">
                        <a>
                        <span class="icon"><i class="fa fa-phone"></i></span>
                        <span>Daftar Pemesanan</span>
                    </a>
                    </li>
                    <li page="users">
                        <a>
                        <span class="icon"><i class="fa fa-user"></i></span>
                        <span>Daftar Pengguna</span>
                    </a>
                    </li>
                </ul>
            </div>
            <section id="inti" class="section" style="padding-top: 0px;"></section>
            <script>
            $(function() {
                <?php
                    if (isset($_SESSION['result'])) {
                        echo "run('get', '".$_SESSION['result']['from']."');";
                        echo "$('.tabs').find('li').removeClass('is-active');";
                        echo "$('.tabs').find(\"li[page='".$_SESSION['result']['from']."']\").addClass('is-active');";
                        unset($_SESSION['result']);
                    } else{
                        echo "run('get', 'orders');";
                        unset($_SESSION['result']);
                    }
                    ?>
                if ($('.msg').length) {
                    $('.modyal').velocity("transition.slideUpBigIn");
                    setTimeout(function() {
                        $('.modyal').velocity("reverse");
                    }, 3000);
                }
                setTimeout(check(), 1000);
                $('.tabs').find('li').click(function() {
                    var pg = $(this).attr('page');
                    $(this).siblings().removeClass('is-active');
                    $(this).addClass('is-active');
                    run('get', pg);
                });
            });
            </script>
        </body>

        </html>