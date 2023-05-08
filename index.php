<?php
    // Koneksi Database
    $server = "localhost";
    $user = "root";
    $pass = "";
    $database = "tugassbd";

    $koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

    if(isset($_POST['bsimpan']))
    {
        
        if($_GET['hal'] == "edit") {
            $edit = mysqli_query($koneksi, " UPDATE tmhs set
                                                nim = '$_POST[tnim]',
                                                nama = '$_POST[tnama]',
                                                alamat = '$_POST[talamat]',
                                                prodi = '$_POST[tprodi]'
                                             WHERE id_mhs = '$_GET[id]'
                                           ");
            if($edit) {
                echo "<script>
                        alert('Edit data sukses!');
                        document.location='index.php';
                    </script>";
            } else {
                echo "<script>
                        alert('Edit data Gagal!');
                        document.location='index.php';
                    </script>";
            }

        }else{
            $simpan = mysqli_query($koneksi, "INSERT INTO tmhs(nim, nama, alamat, prodi)
                                          VALUES ('$_POST[tnim]', 
                                                 '$_POST[tnama]',
                                                 '$_POST[talamat]',
                                                 '$_POST[tprodi]') 
                                         ");
            if($simpan) {
                echo "<script>
                        alert('Simpan data sukses!');
                        document.location='index.php';
                    </script>";
            } else {
                echo "<script>
                        alert('Simpan data Gagal!');
                        document.location='index.php';
                    </script>";
            }

        }

        
    }

    if(isset($_GET['hal']))
    {
        if($_GET['hal'] == "edit")
        {
            $tampil = mysqli_query($koneksi, "SELECT * FROM tmhs WHERE id_mhs = '$_GET[id]' ");
            $data = mysqli_fetch_array($tampil);
            if($data)
            {
                $vnim = $data['nim'];
                $vnama = $data['nama'];
                $valamat = $data['alamat'];
                $vprodi = $data['prodi'];
            }
        }
        else if ($_GET['hal'] == "hapus") {
            $hapus = mysqli_query($koneksi, "DELETE FROM tmhs WHERE id_mhs = '$_GET[id]' ");
            if($hapus) {
                echo "<script>
                alert('Hapus data sukses!');
                document.location='index.php';
                </script>";
            }
        }
    }
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas Sistem Basis Data</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div>
            <h3 class="text-center">Tugas SBD Kelas B Kelompok 5</h3>
        </div>

        <!-- awal -->
        <div class="card mt-3">
            <div class="card-header bg-primary text-white">
                Form Input Data Mahasiswa
            </div>
        </div>
        <div class="card-body">
            <form method="post" action="">
                <div class="form-group">
                    <label>Nim</label>
                    <input type="text" name="tnim" value="<?=@$vnim?>"class="form-control" placeholder="Input Nim anda disini!" required>
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Input Nama anda disini!" required>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea class="form-control" name="talamat" class="form-control" placeholder="Input Alamat anda disini!" ><?=@$valamat?></textarea>
                </div>
                <div class="form-group">
                    <label>Program Studi</label>
                    <select class="form-control" name="tprodi">
                        <option value="<?=@$vprodi?>"><?=@$vprodi?></option>
                        <option value="S1-MATEMATIKA">S1-MATEMATIKA</option>
                        <option value="S1-FISIKA">S1-FISIKA</option>
                        <option value="S1-KIMIA">S1-KIMIA</option>
                        <option value="S1-BIOLOGI">S1-BIOLOGI</option>
                        <option value="S1-FARMASI">S1-FARMASI</option>
                        <option value="S1-SISTEM INFORMASI">S1-SISTEM INFORMASI</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
                <button type="submit" class="btn btn-danger" name="breset">Reset</button>
            </form>
        </div>
        <div class="card mt-3">
            <div class="card-header bg-success text-white">
               Daftar Mahasiswa
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-stripped">
                <tr>
                    <th>No.</th>
                    <th>Nim</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Program Studi</th>
                    <th>Aksi</th>
                </tr>
                <?php
                    $no = 1;
                    $tampil = mysqli_query($koneksi, "SELECT * from tmhs order by id_mhs desc");
                    while($data = mysqli_fetch_array($tampil)) :
                
                
                
                ?>
                <tr>
                    <td><?=$no++;?></td>
                    <td><?=$data['nim']?></td>
                    <td><?=$data['nama']?></td>
                    <td><?=$data['alamat']?></td>
                    <td><?=$data['prodi']?></td>
                    <td>
                        <a href="index.php?hal=edit&id=<?=$data['id_mhs']?>" class="btn btn-warning">Edit</a>
                        <a href="index.php?hal=hapus&id=<?=$data['id_mhs']?>" onClick="return confirm('Ingin mennghapus data ini ?')" class="btn btn-danger">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>  
            </table>
        </div>
    </div>
    <!-- akhir -->


<script src="text/javascript" src="js/bootstrap.bundle.min.js"></script>
</body>
</html>