<?php
require("init.php");
if(empty($_SESSION['user']))
{
    header("Location: login.php");
    die("Redirecting to login.php");
} else{
    $flip = $_POST['cmd'];
    $usr = $_SESSION['user']['username'];
    $pg = $_POST['page'];

    if($flip=='get'){

        if ($usr=='admin') {
            switch ($pg) {
                case 'inputtanki':
                    $sql = "SELECT * FROM owners ORDER BY id ASC";
                    $tutu = $db->query($sql);
?>
    <article class="message is-primary">
        <div class="message-header" style="top: 0;left: 0;right: 0;position: fixed;z-index: 2;">
            <p>Tambah kendaraan baru</p>
            <button class="delete"></button>
        </div>
        <div class="message-body">
            <form action="do.php" method="post">
                <input type="hidden" value="set" name="cmd" />
                <input type="hidden" value="newtanki" name="type" />
                <div class="field">
                    <label class="label">Pengguna</label>
                    <div class="control">
                        <span class="select">
                    <select name="user" required>
                        <option value="">-- pilih pengguna --</option>
                        <?php foreach($tutu as $data) : ?>
                        <option value="<?php echo $data['id']; ?>">
                            <?php echo $data['username']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </span>
                    </div>
                </div>
                <div class="field">
                    <label class="label">UID</label>
                    <div class="control">
                        <input type="text" name="uid" class="input is-small" required />
                    </div>
                </div>
                <div class="field">
                    <label class="label">Nama Kendaraan</label>
                    <div class="control">
                        <input type="text" name="truck" class="input is-small" required />
                    </div>
                </div>
                <div class="field">
                    <label class="label">Nomor plat</label>
                    <div class="control">
                        <input type="text" name="noplat" class="input is-small" required />
                    </div>
                </div>
                <div class="field">
                    <label class="label">Kapasitas tanki bahan bakar</label>
                    <div class="control">
                        <input type="number" name="capacity" class="input is-small" required />
                    </div>
                </div>
                <input type="submit" value="Simpan" class="button is-primary" />
            </form>
        </div>
    </article>
    <?php
                    break;
            
                case 'adminedit':
                    $sql = "SELECT * FROM admin WHERE username='$usr'";
                    $tutu = $db->query($sql);
                    $data  = $tutu->fetch(PDO::FETCH_ASSOC);
?>
        <div class="container" id="dataadmin">
            <div class="box">
                <nav class="level">
                    <div class="level-left">
                        <div class="level-item">
                            <h1 class="title">Edit data admin</h1>
                        </div>
                    </div>
                    <div class="level-right">
                        <div class="level-item">
                            <button class="button" onclick="openmodal('editadminpass')">Edit password</button>
                        </div>
                    </div>
                </nav>
                <form action="do.php" method="post">
                    <input name="cmd" value="set" type="hidden" />
                    <input name="type" value="editadmin" type="hidden" />
                    <input name="username" value="<?php echo $data['username']; ?>" type="hidden" />
                    <div class="field">
                        <label class="label">Nama</label>
                        <div class="control">
                            <input class="input" name="name" type="text" placeholder="Nama" value="<?php echo $data['name']; ?>">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control">
                            <input class="input" name="email" type="text" placeholder="Email" value="<?php echo $data['email']; ?>">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Nomer yang dapat dihubungi</label>
                        <div class="control">
                            <input class="input" name="phone" type="text" placeholder="Nomor telp." value="<?php echo $data['phone']; ?>">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Alamat</label>
                        <div class="control">
                            <input class="input" name="address" type="text" placeholder="Alamat" value="<?php echo $data['address']; ?>">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Perusahaan</label>
                        <div class="control">
                            <input class="input" name="company" type="text" placeholder="Perusahaan" value="<?php echo $data['company']; ?>">
                        </div>
                    </div>
                    <div class="field is-grouped">
                        <div class="control">
                            <input type="submit" class="button is-primary" value="Edit data">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php
                    break;

                case 'editadminpass':
?>
            <article class="message is-primary">
                <div class="message-header" style="top: 0;left: 0;right: 0;position: fixed;z-index: 2;">
                    <p>Edit password admin</p>
                    <button class="delete"></button>
                </div>
                <div class="message-body">
                    <form action="do.php" method="post" id="form3">
                        <input name="cmd" value="set" type="hidden" />
                        <input name="type" value="editadminpass" type="hidden" />
                        <div class="field">
                            <label class="label">Masukkan password yang baru</label>
                            <div class="control">
                                <input class="input" name="pass1" type="password">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Tulis sekali lagi</label>
                            <div class="control">
                                <input class="input" name="pass2" type="password" onchange="checktwice($(this))">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Masukkan kata kunci lama anda</label>
                            <div class="control">
                                <input class="input" name="passlama" type="password">
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <input type="submit" class="button is-primary" value="Edit password">
                            </div>
                        </div>
                    </form>
                </div>
            </article>
            <?php
                    break;

                case 'edittanki':
                    $sql = "SELECT * FROM owners";
                    $tutu = $db->query($sql);
?>
                <td colspan="2" class="has-text-right">
                    <big>Masukkan data baru:</big>
                </td>
                <td colspan="2">
                    <form action="do.php" method="post">
                        <input name="cmd" value="set" type="hidden" />
                        <input name="type" value="edittanki" type="hidden" />
                        <div class="field">
                            <div class="control">
                                <input class="input is-small" name="truck" type="text" placeholder="Merk kendaraan" required/>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <input class="input is-small" name="noplat" type="text" placeholder="Nomor plat kendaraan" required/>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <input class="input is-small" name="capacity" type="number" placeholder="Kapasitas tanki" required/>
                            </div>
                        </div>
                        <div class="field is-grouped">
                            <div class="control is-expanded">
                                <div class="select is-fullwidth is-small">
                                    <select name="user" required>
                                        <option value="">-- pilih user --</option>
                                        <?php foreach($tutu as $data) : ?>
                                        <option value="<?php echo $data['id']; ?>">
                                            <?php echo $data['name']." (".$data['username'].")"; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <input type="submit" class="button is-small" value="Rubah data" />
                        </div>
                    </form>
                </td>
                <td colspan="2"><strong>Info:</strong>
                    <br>Semua input harus diisi</td>
                <?php
                    break;
                
                case 'users':
                    $sql = "SELECT * FROM owners";
                    $tutu = $db->query($sql);
?>
                    <div class="container" style="overflow-x: auto;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Perusahaan</th>
                                    <th>Email</th>
                                    <th>No. HP</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Perusahaan</th>
                                    <th>Email</th>
                                    <th>No. HP</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                    $no  = 1;
                    foreach ($tutu as $data) :
?>
                                    <tr>
                                        <td>
                                            <?php echo $data['id']; ?>
                                        </td>
                                        <td>
                                            <?php echo $data['name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $data['username']; ?>
                                        </td>
                                        <td>
                                            <?php echo $data['company']; ?>
                                        </td>
                                        <td>
                                            <?php echo $data['email']; ?>
                                        </td>
                                        <td>
                                            <?php echo $data['phone']; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    break;

                case 'vehicles':
                    $sql = "SELECT * FROM tanki,owners WHERE tanki.owner_id=owners.id";
                    $tutu = $db->query($sql);
?>
                        <nav class="level is-fullwidth is-mobile">
                            <div class="level-left">
                                <div class="level-item">
                                    <a class="button" onclick="openmodal('inputtanki')">Tambah baru</a>
                                </div>
                            </div>
                            <div class="level-right">
                                <div class="level-item">
                                    <a class="button" onclick="$(this).toggleClass('is-primary'); toggledit();">Edit data</a>
                                </div>
                            </div>
                        </nav>
                        <div class="container" style="overflow-x: auto;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Kendaraan</th>
                                        <th>No. Plat</th>
                                        <th>Kapasitas tanki</th>
                                        <th>UID</th>
                                        <th>Pengguna</th>
                                        <th class="ed">Edit</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Kendaraan</th>
                                        <th>No. Plat</th>
                                        <th>Kapasitas tanki</th>
                                        <th>UID</th>
                                        <th>Pengguna</th>
                                        <th class="ed">Edit</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                    $no  = 1;
                    foreach ($tutu as $data) :
?>
                                        <tr>
                                            <td>
                                                <?php echo $data['truck']; ?>
                                            </td>
                                            <td>
                                                <?php echo $data['noplat']; ?>
                                            </td>
                                            <td>
                                                <?php echo $data['capacity']; ?> Liter
                                            </td>
                                            <td>
                                                <?php echo $data['uid']; ?>
                                            </td>
                                            <td>
                                                <?php echo $data['name']." (".$data['username'].")"; ?>
                                            </td>
                                            <td class="ed">
                                                <a class="button is-small is-warning action" onclick="$(this).siblings().toggle(); edittanki('<?php echo $data['uid']; ?>');">
                                    <span class="icon is-small">
                                        <i class="fa fa-pencil"></i>
                                    </span>
                                </a>
                                                <a class="button is-small is-danger action" onclick="deletetanki('<?php echo $data['uid']; ?>');">
                                    <span class="icon is-small">
                                        <i class="fa fa-times"></i>
                                    </span>
                                </a>
                                            </td>
                                        </tr>
                                        <tr class="edit" id="<?php echo $data['uid']; ?>">
                                        </tr>
                                        <?php
    endforeach;
    ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    break;

                default:
                    $sql = "SELECT * FROM orders, tanki, owners WHERE orders.tanki_id = tanki.id AND orders.owner_id = owners.id";
                    $tutu = $db->query($sql);
?>
                            <div class="container" style="overflow-x: auto;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal pemesanan</th>
                                            <th>Pemesan</th>
                                            <th>Kendaraan</th>
                                            <th>Volume</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal pemesanan</th>
                                            <th>Pemesan</th>
                                            <th>Kendaraan</th>
                                            <th>Volume</th>
                                            <th>Status</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
    
    $no  = 1;
   foreach ($tutu as $data) :
    ?>
                                            <tr>
                                                <td>
                                                    <?php echo $no++; ?>
                                                </td>
                                                <td>
                                                    <?php echo $data['datetime']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $data['name']; ?> (
                                                    <?php echo $data['username']; ?>)
                                                </td>
                                                <td>
                                                    <?php echo $data['truck']; ?> (
                                                    <?php echo $data['noplat']; ?>)
                                                </td>
                                                <td>
                                                    <?php echo $data['volume']; ?> Liter
                                                </td>
                                                <td>
                                                    <?php if($data['ispaid']==1){ echo "Sudah diambil"; } else { echo "Belum diambil"; } ?>
                                                </td>
                                            </tr>
                                            <?php
    endforeach;
    ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                break;
            }
        } else {
            switch ($pg) {
                case 'profile':
                    $sql = "SELECT * FROM owners WHERE username='$usr'";
                    $tutu = $db->query($sql);
                    $data  = $tutu->fetch(PDO::FETCH_ASSOC);
?>
                                <div class="container" id="datauser">
                                    <div class="box">
                                        <nav class="level">
                                            <div class="level-left">
                                                <div class="level-item">
                                                    <h1 class="title"><?php echo $data['name']; ?>
                                                     <small>(<?php echo $data['username']; ?>)</small></h1>
                                                </div>
                                            </div>
                                            <div class="level-left">
                                                <div class="level-item">
                                                    <a class="button" id="editbutton" onclick="openmodal('editdatauser');">Edit data</a>
                                                </div>
                                                <div class="level-item">
                                                    <button class="button" onclick="openmodal('edituserpass')">Edit password</button>
                                                </div>
                                            </div>
                                        </nav>
                                        <table class="table" id="tabeldata">
                                            <tr>
                                                <td>No telp.</td>
                                                <td>
                                                    :
                                                    <?php echo $data['phone']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Alamat email</td>
                                                <td>
                                                    :
                                                    <?php echo $data['email']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Alamat</td>
                                                <td>
                                                    :
                                                    <?php echo $data['address']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Perusahaan</td>
                                                <td>
                                                    :
                                                    <?php echo $data['company']; ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <?php
                    break;

                case 'editdatauser':
                    $sql = "SELECT * FROM owners WHERE username='$usr'";
                    $tutu = $db->query($sql);
                    $data  = $tutu->fetch(PDO::FETCH_ASSOC);
?>
                                    <article class="message is-primary">
                                        <div class="message-header" style="top: 0;left: 0;right: 0;position: fixed;z-index: 2;">
                                            <p>Edit data pengguna</p>
                                            <button class="delete"></button>
                                        </div>
                                        <div class="message-body">
                                            <form action="do.php" method="post" id="form1">
                                                <input name="cmd" value="set" type="hidden" />
                                                <input name="type" value="edituser" type="hidden" />
                                                <div class="field">
                                                    <label class="label">Nama</label>
                                                    <div class="control">
                                                        <input class="input" name="name" type="text" placeholder="Nama" value="<?php echo $data['name']; ?>">
                                                    </div>
                                                </div>
                                                <div class="field">
                                                    <label class="label">Username</label>
                                                    <div class="control has-icons-right">
                                                        <input class="input" name="username" type="text" placeholder="Username" onblur="checkusername($(this))" value="<?php echo $data['username']; ?>">
                                                        <span class="icon is-big is-right"><i class="fa fa-check"></i></span>
                                                    </div>
                                                    <p class="help">Username sudah digunakan.</p>
                                                </div>
                                                <div class="field">
                                                    <label class="label">Email</label>
                                                    <div class="control">
                                                        <input class="input" name="email" type="text" placeholder="Email" value="<?php echo $data['email']; ?>">
                                                    </div>
                                                </div>
                                                <div class="field">
                                                    <label class="label">Nomor yang dapat dihubungi</label>
                                                    <div class="control">
                                                        <input class="input" name="phone" type="text" placeholder="Nomor telp." value="<?php echo $data['phone']; ?>">
                                                    </div>
                                                </div>
                                                <div class="field">
                                                    <label class="label">Alamat</label>
                                                    <div class="control">
                                                        <input class="input" name="address" type="text" placeholder="Alamat" value="<?php echo $data['address']; ?>">
                                                    </div>
                                                </div>
                                                <div class="field">
                                                    <label class="label">Perusahaan</label>
                                                    <div class="control">
                                                        <input class="input" name="company" type="text" placeholder="Perusahaan" value="<?php echo $data['company']; ?>">
                                                    </div>
                                                </div>
                                                <div class="field">
                                                    <div class="control">
                                                        <input type="submit" name="submitbtn" class="button is-primary is-static" value="Edit data">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </article>
                                    <?php
                    break;

                case 'edituserpass':
?>
                    <article class="message is-primary">
                <div class="message-header" style="top: 0;left: 0;right: 0;position: fixed;z-index: 2;">
                    <p>Edit password</p>
                    <button class="delete"></button>
                </div>
                <div class="message-body">
                    <form action="do.php" method="post" id="form2">
                        <input name="cmd" value="set" type="hidden" />
                        <input name="type" value="edituserpass" type="hidden" />
                        <div class="field">
                            <label class="label">Masukkan password yang baru</label>
                            <div class="control">
                                <input class="input" name="pass1" type="password">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Tulis sekali lagi</label>
                            <div class="control">
                                <input class="input" name="pass2" type="password" onchange="checktwice($(this))">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Masukkan kata kunci lama anda</label>
                            <div class="control">
                                <input class="input" name="passlama" type="password">
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <input type="submit" class="button is-primary" value="Edit password">
                            </div>
                        </div>
                    </form>
                </div>
            </article>
<?php
                    break;

                case 'inputorder':
                $sql = "SELECT * FROM owners WHERE username='$usr'";
                $tutu = $db->query($sql);
                $uwer  = $tutu->fetch(PDO::FETCH_ASSOC);
                $id = $uwer['id'];
                $sqlb = "SELECT * FROM tanki WHERE owner_id = '$id'";
                $tanki = $db->query($sqlb);
                    
?>
                                        <article class="message is-primary">
                                            <div class="message-header" style="top: 0;left: 0;right: 0;position: fixed;z-index: 2;">
                                                <p>Tambah pesanan baru</p>
                                                <button class="delete"></button>
                                            </div>
                                            <div class="message-body">
                                                <form action="do.php" method="post">
                                                    <input name="cmd" value="set" type="hidden" />
                                                    <input name="type" value="addorder" type="hidden" />
                                                    <input type="hidden" name="owner_id" value="<?php echo $id; ?>" />
                                                    <div class="field">
                                                        <div class="control is-expanded">
                                                            <div class="select">
                                                                <select name="tanki_id" required>
                                                                    <?php foreach($tanki as $data) : ?>
                                                                    <option value="<?php echo $data['id']; ?>">
                                                                        <?php echo $data['truck']." (".$data['noplat'].")"; ?>
                                                                    </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="field has-addons">
                                                        <div class="control is-expanded">
                                                            <input class="input" name="volume" type="number" placeholder="Volume (Liter)" required autofocus />
                                                        </div>
                                                        <div class="control">
                                                            <input type="submit" class="button is-primary" value="Tambah pesanan" />
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </article>
                                        <?php
                    break;

                case 'editorder':
?>
                                            <form action="do.php" method="post">
                                                <input name="cmd" value="set" type="hidden" />
                                                <input name="type" value="editorder" type="hidden" />
                                                <input type="hidden" name="ido" />
                                                <div class="field has-addons">
                                                    <div class="control">
                                                        <input class="input is-small" name="volume" type="number" placeholder="Volume baru" size="5" required/>
                                                    </div>
                                                    <div class="control">
                                                        <input type="submit" class="button is-small is-primary" value="Rubah data" />
                                                    </div>
                                                </div>
                                            </form>
                                            <?php
                    break;

                default:
                    $sql = "SELECT * FROM orders, tanki, owners WHERE owners.username = '$usr' AND orders.tanki_id = tanki.id AND orders.owner_id = owners.id ORDER BY ispaid ASC";
                    $tutu = $db->query($sql);
?>
                                                <nav class="level is-fullwidth is-mobile">
                                                    <div class="level-left">
                                                        <div class="level-item">
                                                            <a class="button" onclick="openmodal('inputorder')">Buat pesanan</a>
                                                        </div>
                                                    </div>
                                                    <div class="level-right">
                                                        <div class="level-item">
                                                            <a class="button" onclick="$(this).toggleClass('is-primary'); editmode();">Edit data</a>
                                                        </div>
                                                    </div>
                                                </nav>
                                                <div class="container" style="overflow-x: auto;">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Tanggal pemesanan</th>
                                                                <th>Kendaraan</th>
                                                                <th>Volume</th>
                                                                <th class="stat">Status</th>
                                                                <th class="ed">Edit</th>
                                                            </tr>
                                                        </thead>
                                                        <tfoot>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Tanggal pemesanan</th>
                                                                <th>Kendaraan</th>
                                                                <th>Volume</th>
                                                                <th class="stat">Status</th>
                                                                <th class="ed">Edit</th>
                                                            </tr>
                                                        </tfoot>
                                                        <tbody>
                                                            <?php $no  = 1; foreach ($tutu as $data) : ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo $no++; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $data['datetime']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $data['truck']; ?> (
                                                                    <?php echo $data['noplat']; ?>)
                                                                </td>
                                                                <td>
                                                                    <?php echo $data['volume']; ?> Liter
                                                                </td>
                                                                <td class="stat">
                                                                    <?php if($data['ispaid']==1){ echo "Sudah diambil"; } else { echo "Belum diambil"; } ?>
                                                                </td>
                                                                <td class="edit" id="<?php echo $data['ido']; ?>"></td>
                                                                <td class="ed">
                                                                    <?php if($data['ispaid']==0){ ?>
                                                                    <a class="button is-small is-warning action" onclick="$(this).siblings().toggle(); editorder('<?php echo $data['ido']; ?>');">
                                    <span class="icon is-small">
                                        <i class="fa fa-pencil"></i>
                                    </span>
                                </a>
                                                                    <?php } ?>
                                                                    <a class="button is-small is-danger action" onclick="notify('danger','Klik 2 kali (double click) pada tanda silang untuk menghapus data');" ondblclick="deleteorder('<?php echo $data['ido']; ?>');">
                                    <span class="icon is-small">
                                        <i class="fa fa-times"></i>
                                    </span>
                                </a>
                                                                </td>
                                                            </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <?php
                    break;
            }
        }
    } elseif($flip=='set'){
        if(isset($_POST['type'])){
            switch ($_POST['type']) {
                case 'newtanki':
                    if ($usr!='admin') {
    header('location:index.php');
    die("you're not an admin");
                    }
                    $in=$db->prepare("INSERT INTO tanki (uid,truck,capacity,noplat,owner_id) VALUES (:uid,:truck,:capacity,:noplat,:owner_id)");
                    $in->bindParam(':uid',$_POST['uid']);
                    $in->bindParam(':truck',$_POST['truck']);
                    $in->bindParam(':capacity',$_POST['capacity']);
                    $in->bindParam(':noplat',$_POST['noplat']);
                    $in->bindParam(':owner_id',$_POST['user']);
                    if($in->execute()){
                        header("location:admin.php");
                        $_SESSION['result']['message'] = "ok";
                    } else{
                        header("location:admin.php");
                        $_SESSION['result']['message'] = "no";
                    }
                    $_SESSION['result']['from'] = 'vehicles';
                    break;

                case 'edittanki':
                    if ($usr!='admin') {
    header('location:index.php');
    die("you're not an admin");
                    }
                    $edit=$db->prepare("UPDATE tanki SET truck = :truck, noplat = :noplat, capacity = :capacity, owner_id = :ownerid WHERE uid = :uid");
                    $edit->bindParam(':truck',$_POST['truck']);
                    $edit->bindParam(':noplat',$_POST['noplat']);
                    $edit->bindParam(':capacity',$_POST['capacity']);
                    $edit->bindParam(':ownerid',$_POST['user']);
                    $edit->bindParam(':uid',$_POST['uid']);
                    if($edit->execute()){
                        header("location:admin.php");
                        $_SESSION['result']['message'] = "ok";
                    } else{
                        header("location:admin.php");
                        $_SESSION['result']['message'] = "no";
                    }
                    $_SESSION['result']['from'] = 'vehicles';
                    break;

                case 'deletetanki':
                    if ($usr!='admin') {
    header('location:index.php');
    die("you're not an admin");
                    }
                    $spell=$db->prepare("DELETE FROM tanki WHERE uid = :uid");
                    $spell->bindParam(':uid',$_POST['uid']);
                    if($spell->execute()){
                        echo "Penghapusan data selesai";
                    } else{
                        echo "Terjadi kegagalan";
                    }
                    break;

                case 'editadmin':
                    if ($usr!='admin') {
    header('location:index.php');
    die("you're not an admin");
                    }
                    $ed=$db->prepare("UPDATE admin SET name = :name, company = :company, address = :address, email = :email, phone = :phone WHERE username = :username");
                    $ed->bindParam(':name',$_POST['name']);
                    $ed->bindParam(':company',$_POST['company']);
                    $ed->bindParam(':address',$_POST['address']);
                    $ed->bindParam(':email',$_POST['email']);
                    $ed->bindParam(':phone',$_POST['phone']);
                    $ed->bindParam(':username',$_POST['username']);
                    if($ed->execute()){
                        header("location:admin.php");
                        $_SESSION['result']['message'] = "ok";
                    } else{
                        header("location:admin.php");
                        $_SESSION['result']['message'] = "no";
                    }
                    $_SESSION['result']['from'] = 'vehicles';
                    break;

                case 'editadminpass':
                    if ($usr!='admin') {
                        header('location:index.php');
                        die("you're not an admin");
                    }
                    $pass1=$_POST['pass1'];
                    $pass2=$_POST['pass2'];
                    $passlama=$_POST['passlama'];
                    $pass=md5($passlama);
                    if ($pass1 == $pass2) {
                        $sql = "SELECT * FROM admin WHERE username='$usr'";
                        $tutu = $db->query($sql);
                        $data  = $tutu->fetch(PDO::FETCH_ASSOC);
                        if ($data['password']==$pass) {
                            $password=md5($pass2);
                            $ed=$db->prepare("UPDATE admin SET password = '$password' WHERE username = '$usr'");
                            if($ed->execute()){
                                echo "ok";
                            } else{
                                echo "error";
                            }
                        } else{
                            echo "Wrong!";
                        }
                    } else{
                        echo "pass dont match";
                    }
                    break;

                case 'checkusername':
                    if (!isset($_SESSION['user'])) {
                        header('location:index.php');
                        die("moh");
                    }
                    if ($usr!='admin') {
                        $uname=$_POST['uname'];
                        $sql = "SELECT count(id) as c FROM owners WHERE username='$uname'";
                        $tutu = $db->query($sql);
                        $data  = $tutu->fetch(PDO::FETCH_ASSOC);
                        // echo $data['c'];
                        if ($data['c']==1) {
                            echo "no";
                        } else {
                            echo "ok";
                        }
                    } else {
                        $sql = "SELECT * FROM admin WHERE username='$uname'";
                        $data = $db->query($sql);
                        if ($data) {
                            echo "no";
                        } else {
                            echo "ok";
                        }
                    }
                    break;

                case 'edituser':
                    $ed=$db->prepare("UPDATE owners SET name = :name, username = :username, company = :company, address = :address, email = :email, phone = :phone WHERE username = :usr");
                    $ed->bindParam(':name',$_POST['name']);
                    $ed->bindParam(':username',$_POST['username']);
                    $ed->bindParam(':company',$_POST['company']);
                    $ed->bindParam(':address',$_POST['address']);
                    $ed->bindParam(':email',$_POST['email']);
                    $ed->bindParam(':phone',$_POST['phone']);
                    $ed->bindParam(':usr',$usr);
                    $result=$ed->execute();
                    if($result){
                        echo "ok";
                        $_SESSION['user']['username']=$_POST['username'];
                    } else{
                        echo $result;
                    }
                    break;

                case 'edituserpass':
                    if (!isset($usr)) {
                        header('location:index.php');
                        die("you're not here when i need you");
                    }
                    $sql = "SELECT * FROM owners WHERE username='$usr'";
                    $tutu = $db->query($sql);
                    $row  = $tutu->fetch(PDO::FETCH_ASSOC);

                    $pass1=$_POST['pass1'];
                    $pass2=$_POST['pass2'];

                    $check_password = hash('sha256', $_POST['passlama'] . $row['salt']);
                    for($round = 0; $round < 65536; $round++)
                    {
                        $check_password = hash('sha256', $check_password . $row['salt']);
                    }
                    if($check_password === $row['password'])
                    {
                        if ($pass1 == $pass2) {
                            $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
                            $password = hash('sha256', $_POST['pass2'] . $salt);
                            for($round = 0; $round < 65536; $round++) 
                            { 
                                $password = hash('sha256', $password . $salt); 
                            }
                            $ed=$db->prepare("UPDATE owners SET password = '$password', salt = '$salt' WHERE username = '$usr'");
                            if($ed->execute()){
                                echo "ok";
                            } else{
                                echo "error";
                            }
                        } else {
                            echo "pass dont match";
                        }
                    } else{
                        echo "Wrong password";
                    }
                    break;
                    
                case 'addorder':
                    $add=$db->prepare("INSERT INTO orders (owner_id,tanki_id,volume) VALUES (:owner_id,:tanki_id,:volume)");
                    $add->bindParam(':owner_id',$_POST['owner_id']);
                    $add->bindParam(':tanki_id',$_POST['tanki_id']);
                    $add->bindParam(':volume',$_POST['volume']);
                    if($add->execute()){
                        header("location:index.php");
                        $_SESSION['result']['message'] = "ok";
                    } else{
                        header("location:index.php");
                        $_SESSION['result']['message'] = "no";
                    }
                    $_SESSION['result']['from'] = 'orders';
                    break;

                case 'editorder':
                    $edit=$db->prepare("UPDATE orders SET volume = :volume WHERE ido = :ido");
                    $edit->bindParam(':volume',$_POST['volume']);
                    $edit->bindParam(':ido',$_POST['ido']);
                    if($edit->execute()){
                        header("location:index.php");
                        $_SESSION['result']['message'] = "ok";
                    } else{
                        header("location:admin.php");
                        $_SESSION['result']['message'] = "no";
                    }
                    $_SESSION['result']['from'] = 'orders';
                    break;

                case 'deleteorder':
                    $spell=$db->prepare("DELETE FROM orders WHERE ido = :ido");
                    $spell->bindParam(':ido',$_POST['ido']);
                    if($spell->execute()){
                        echo "Penghapusan data selesai";
                    } else{
                        echo "Terjadi kegagalan";
                    }
                    break;

                default:
                    echo "hmm?";
                    break;
            }
        } else{
            echo "moh";
        }
    } else{

    }
}