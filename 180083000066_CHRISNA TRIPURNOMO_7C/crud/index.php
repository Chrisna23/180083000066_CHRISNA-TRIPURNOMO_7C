<?php 
	//koneksi db
	$server		= "localhost";
	$user		= "root";
	$pass 		= "";
	$database 	= "crudmhs";

	$koneksi	= mysqli_connect($server, $user, $pass, $database) or die(mysqli_error($koneksi));

	//jika tombol simpan di klik
	if(isset($_POST['bsimpan']))
	{
		//pengujian data diedit atau disimpan
		if ($_GET['hal'] == "edit")
		{
			//data akan di edit
			$edit = mysqli_query($koneksi, "UPDATE mahasiswa set
												nim = '$_POST[tnim]',
												nama = '$_POST[tnama]',
												alamat = '$_POST[talamat]',
												jurusan = '$_POST[tjurusan]'
											WHERE id = '$_GET[id]' 
											");

			if($edit)	//jika edit sukses
			{
				echo "<script>alert('Edit Data Sukses!');document.location='index.php';</script>";
			}
			else
			{
				echo "<script>alert('Edit Data GAGAL!')document.location='index.php';</script>";
			}
		}
		else 
		{
			//data akan disimpan baru
			$simpan = mysqli_query($koneksi, "INSERT INTO mahasiswa (nim, nama, alamat, jurusan) 
											VALUES ('$_POST[tnim]',
													'$_POST[tnama]',
													'$_POST[talamat]',
													'$_POST[tjurusan]')
													");
			if($simpan) // jika simpan sukses
			{
				echo "<script>alert('Simpan Data Sukses!');document.location='index.php';</script>";
			}
			else
			{
				echo "<script>alert('Simpan Data GAGAL!')document.location='index.php';</script>";
			}
		}
	}

	//uji coba tombol hapus di klik
	if(isset($_GET['hal']))
	{
		//pengujian Edit data
		if($_GET['hal'] == "edit")
		{
			//tampilan data yg di edit
			$tampil = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE id = '$_GET[id]' ");
			$data = mysqli_fetch_array($tampil);
			if($data)
			{
				//jika data ditemukan akan ditampung ke dalam variabel
				$vnim = $data['nim'];
				$vnama = $data['nama'];
				$valamat = $data['alamat'];
				$vjurusan = $data['jurusan'];
			}
		}
		else if ($_GET['hal'] =="hapus")
		{
			//persiapan hapus data
			$hapus = mysqli_query($koneksi, "DELETE FROM mahasiswa WHERE id = '$_GET[id]' ");
			if($hapus){
				echo "<script>alert('Hapus Data Sukses')document.location='index.php';</script>";
			}
		}
	}		

?>
<!DOCTYPE html>
<html>
<head>
	<title>CRUD PHP</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">

<h1 class="text-center">DAFTAR PROFIL MAHASISWA</h1>
<h2 class="text-center">UNIVERSITAS MERDEKA MALANG</h2>

<!-- Awal Card Form -->
<div class="card mt-4">
  <div class="card-header bg-primary text-white">
    Form Pengisian Data Mahasiswa Universitas Merdeka Malang
  </div>
  <div class="card-body">
    <form method="post" action="">
    	<div class="form-group">
    		<label>NIM</label>
    		<input type="text" name="tnim" value="<?=@$vnim?>" class="form-control" placeholder="Silahkan Isi NIM Anda Di Sini" required>
  		</div>
  		<div class="form-group">
    		<label>Nama</label>
    		<input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Silahkan Isi Nama Anda Di Sini" required>
  		</div>
  		<div class="form-group">
    		<label>Alamat</label>
    		<textarea class="form-control" name="talamat" placeholder="Silahkan Isi Alamat Anda Di Sini"><?=@$valamat?></textarea>
  		</div>
  		<div class="form-group">
    		<label>Jurusan</label>
    		<select class="form-control" name="tjurusan">
    			<option value="<?=@$vjurusan?>"><?=@$vjurusan?></option>
    			<option value="Ilmu Komunikasi">Ilmu Komunikasi</option>
    			<option value="Sistem Informasi">Sistem Informasi</option>
    			<option value="Teknik Permesinan">Teknik Permesinan</option>
    			<option value="Hukum">Hukum</option>
    		</select>
  		</div>
  		<br>
  		<button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
  		<button type="reset" class="btn btn-danger" name="breset">Reset</button>
</div>
<!-- Akhir Card Form -->

<!-- Awal Card Table -->
<div class="card mt-4">
  <div class="card-header bg-success text-white">
    Mahasiswa Universitas Merdeka Yang Sudah Terdaftar 
  </div>
  <div class="card-body">
  	<table class="table table-bordered table-striped">
  		<tr>
  			<th>NO.</th>
  			<th>NIM</th>
  			<th>NAMA LENGKAP</th>
  			<th>ALAMAT</th>
  			<th>JURUSAN</th>
  			<th>OPSI</th>
  		</tr>
  		<?php 
  			$no = 1;
  			$tampil = mysqli_query($koneksi, "SELECT * from mahasiswa order by id desc");
  			while($data = mysqli_fetch_array($tampil)) :

  		?>
  		<tr>
  			<td><?=$no++;?></td>
  			<td><?=$data['nim']?></td>
  			<td><?=$data['nama']?></td>
  			<td><?=$data['alamat']?></td>
  			<td><?=$data['jurusan']?></td>
  			<td>
  				<a href="index.php?hal=edit&id=<?=$data['id']?>" class="btn btn-warning"> Edit </a>
  				<a href="index.php?hal=hapus&id=<?=$data['id']?>"
  				   onclick="return confirm('Apakah Data Ini Akan Di Hapus?')" class="btn btn-danger"> Hapus </a>
  		</tr>
  	<?php endwhile; //penutup ?>
  	</table>

  </div>
</div>
<!-- Akhir Card Table -->

</div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>