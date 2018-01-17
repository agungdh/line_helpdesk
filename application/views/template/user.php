<?php
	session_start();

	if(!isset($_SESSION['user_login'])){	
		header('location: index.php');
    return;
	}

?>


<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">MANAJEMEN TAMBAH USER</h3>
	</div><!-- /.box-header -->
	<!-- form start -->
	
	<form role="form" method="post" name="user">
		<div class="box-body">
		
			<div class="form-group">
				<label for="username">Nama User</label>
				<input type="text" class="form-control" id="username" name="username" placeholder="Nama User">
			</div>

			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" name="password" placeholder="Password">
			</div>

			<div class="form-group">
				<label for="level">Level Akses</label>
				<select class="form-control" id="level" name="level">
					<option value="1">Level User</option>
					<option value="2">Level Tamu</option>
					<option value="0">Level Administrator</option>
				</select>
			</div>

			<div class="form-group">
				<label for="avatar">Avatar</label>
				<select class="form-control" id="avatar" name="avatar">
					<option value="avatar1.png">Pilihan Avatar 01</option>
					<option value="avatar2.png">Pilihan Avatar 02</option>
					<option value="avatar3.png">Pilihan Avatar 03</option>
					<option value="avatar4.png">Pilihan Avatar 04</option>
					<option value="avatar5.png">Pilihan Avatar 05</option>
				</select>
			</div>
			
		</div><!-- /.box-body -->

		<div class="box-footer">
			<button type="submit" class="btn btn-primary" name="proses">Simpan Data User</button>
		</div>
	</form>
</div><!-- /.box -->

<!-- PESAN ERROR MODAL -->
<?php require('ok.php');?>
<?php require('error.php');?>

<?php
if(isset($_POST['proses']))
{
  $username = $_POST['username'];
  $password = $_POST['password'];
  $level = $_POST['level'];
  $avatar = $_POST['avatar'];
  
  if ( $_POST['username'] == null || $_POST['password'] == NULL ) 
  {
		?>
			<script>
				alertModal('<i class="icon fa fa-close"></i> Gagal!!','Data KOSONG tidak dapat disimpan...');
			</script>		
		<?php
		return;
  }
		
	$stmtCari = $db->prepare("select * from user where username=?");
	
	$stmtCari->bindParam(1, $username);
	$stmtCari->execute();
	
	$rowCari = $stmtCari->fetch();

	if ( $rowCari > 0 )
	{
		?>
			<script>
				alertModal('<i class="icon fa fa-close"></i> Gagal!!','Data USER sudah dipakai...');
			</script>		
		<?php
		return;
	}

	$stmtSimpan = $db->prepare("insert into user (username,password,level,avatar) values (?,md5(?),?,?)");
	
	$stmtSimpan->bindParam(1, $username);
	$stmtSimpan->bindParam(2, $password);
	$stmtSimpan->bindParam(3, $level);
	$stmtSimpan->bindParam(4, $avatar);
	$stmtSimpan->execute();

		?>
		<script>
			alertModalOk('<i class="icon fa fa-check"></i> Berhasil!','Data USER sudah disimpan');
		</script>
		<?php 
  
}
?>
