<?php
$host           = "localhost";
$user           = "root";
$pass           = "";
$db             = "tugas_php";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Tidak bisa terkoneksi ke database");
}
$npm     = "";
$nama    = "";
$jurusan = "";
$sukses  = "";
$error   = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'delete'){
    $id     = $_GET['id'];
    $sql1   = "delete from mahasiswa_kampus where id = '$id'";
    $q1     = mysqli_query($koneksi, $sql1);

}


if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql3       = "select * from mahasiswa_kampus where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql3);
    $r1         = mysqli_fetch_array($q1);
    $npm        = $r1['npm'];
    $nama       = $r1['nama'];
    $jurusan    = $r1['jurusan'];

    if ($npm == '') {
        $error = "Data tidak ditemukan";
    }
}

if (isset($_POST['simpan'])) {
    $npm        = $_POST['npm'];
    $nama       = $_POST['nama'];
    $jurusan    = $_POST['jurusan'];

    if ($npm && $nama && $jurusan) {
        if ($op == 'edit') {
            $sql4 = "Update mahasiswa_kampus set npm ='$npm',nama ='$nama',jurusan ='$jurusan' where id ='$id'";
            $q10 = mysqli_query($koneksi, $sql4);
            if ($q10) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error = "Data gagal diupdate";
            }
        } else {
            $sql5 = "insert into mahasiswa_kampus (npm,nama,jurusan) values ('$npm','$nama','$jurusan')";
            $q1   = mysqli_query($koneksi, $sql5);
            if ($q1) {
                $sukses = "Berhasil Memasukkan Data";
            } else {
                $error = "Gagal Memasukkan Data";
            }
        }
    } else {
        $error = "Masukkan Data";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- untuk memasukan data -->
        <div class="card">
            <div class="card-header">
                LIST MAHASISWA STMIK AMIKBANDUNG
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header ("refresh:0;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="npm" class="col-sm-2 col-form-label">NPM</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="npm" name="npm" value="<?php echo $npm ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">NAMA</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="jurusan" class="col-sm-2 col-form-label">JURUSAN</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="jurusan" id="jurusan">
                                <option value="">- Pilih Jurusan -</option>
                                <option value="TI" <?php if ($jurusan == "TI") echo "selected" ?>>TI</option>
                                <option value="SI" <?php if ($jurusan == "SI") echo "selected" ?>>SI</option>
                                <option value="DKV" <?php if ($jurusan == "DKV") echo "selected"?>>DKV</option>

                            </select>

                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <!-- mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Mahasiswa
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">NO</th>
                            <th scope="col">NPM</th>
                            <th scope="col">NAMA</th>
                            <th scope="col">JURUSAN</th>

                        </tr>
                    <tbody>

                        <?php
                        $sql2 = "select * from mahasiswa_kampus order by id desc";
                        $q2   = mysqli_query($koneksi, $sql2);
                        $urut       = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {


                            $id         = $r2['id'];
                            $npm        = $r2['npm'];
                            $nama       = $r2['nama'];
                            $jurusan    = $r2['jurusan'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $npm ?></td>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $jurusan ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id?>"onclick = "return confirm('Yakin?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                    
  
                            </tr>
                        <?php
                        }

                        ?>
                    </tbody>


                    </thead>

            </div>
        </div>
    </div>
</body>

</html>