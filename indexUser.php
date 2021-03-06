
<?php
	include 'helper/koneksi.php';

	session_start();
	// session_destroy();
	if (isset($_SESSION['username']) and isset($_SESSION['idusers_level'])) {
        if ($_SESSION['idusers_level'] == '1') {
            header("location: admin/indexAdmin.php");
		}
	}
	else {
		header("location: login.php");
	}
    
?>

<!DOCTYPE html>
<html>
<head>
    <title>Event.com - book amazing events or make your own event</title>
    <?php include 'head.php'?>
	
</head>
<body>
<?php include 'header.php';?>
	<div class="container findEvent mt-3 mb-2">
		<div class="row">
			<div class="col-2"></div>
			<div class="col-8">
					<div class="row">
					<form action="" method="POST" class="col-6">
						<div class="row">
							<div class="col-6">
								<label for="event" class="mb-2" style="font-style:bold">Pencarian Event</label>
								<input type="text" name="search" class="form-control" placeholder="Event">
							</div>
							<div class="col-6 d-flex justify-content-center align-items-end">
								<input type="submit" name="searchByName" value="Search" class="btn btn-success btn-block">
								</div>
							</div>
					</form>
					<form action="" method="POST" class="col-6">
						<div class="row">
							<div class="col-6">
								<label for="lokasi" class="mb-2" style="font-style:bold">Kategori</label>
								<div class="dropdown">
 									<select name="kategori" cols="10" rows="5" class="form-control" > 
                    		            <?php
                    		                $query = "SELECT * FROM kategori WHERE deleted = 0";
                    		                $result = mysqli_query($con, $query);
                    		                if (mysqli_num_rows($result) > 0) {
                    		                    $kategori = 1;
                    		                    while($row = mysqli_fetch_assoc($result)){
                    		            ?>
                    		                        <option value=" <?php echo $row['id_kategori']?>"> <?php echo $row['jenis_kategori']?></option>        
                    		            <?php
                    		                    }
                    		                }
                    		            ?>
                    		            </select>
								</div>
							</div>
							<div class="col-6 d-flex justify-content-center align-items-end">
								<input type="submit" name="searchByKategori" value="Search" class="btn btn-success btn-block">
							</div>
							</div>
					</form>
						</div>
					
			</div>
			<div class="col-2"></div>
		</div>
	</div>

	<div class="content-box">
		<div class="wrap">
			<div class="clear"></div>
		</div>
	</div>

	<div class="container anyEvent">
		<div class="row">
				<?php
					$search = $_POST['search'];
					$jenis = $_POST['kategori'];
					$nama = $_POST['searchByName'];
					$kategori = $_POST['searchByKategori'];

					$query = "SELECT e.*,u.* FROM events AS e INNER JOIN users AS u ON e.id_users = u.id_users WHERE u.deleted = 0 AND e.deleted = 0";

					if (isset($nama)) {
						$query = "SELECT e.*,u.* FROM events AS e INNER JOIN users AS u ON e.id_users = u.id_users WHERE e.judul_event LIKE '%{$search}%' AND u.deleted = 0 AND e.deleted = 0";
					}
					else if(isset($kategori)){
						$query = "SELECT e.*,u.* FROM events AS e INNER JOIN users AS u ON e.id_users = u.id_users WHERE e.id_kategori = $jenis AND u.deleted = 0 AND e.deleted = 0";
					}
					else{
						$query = "SELECT e.*,u.* FROM events AS e INNER JOIN users AS u ON e.id_users = u.id_users WHERE u.deleted = 0 AND e.deleted = 0";
					}
					
					$result = mysqli_query($con, $query);

					if(mysqli_num_rows($result) > 0){
					$card = 1;
					while($row = mysqli_fetch_assoc($result)){
					$id_events = $row["id_events"];
					?>
					<div class="col-4">
					<div class="card" style="width: 22rem;">
					<?php echo" <a href='detailEvent.php?id=$id_events'><img class='card-img-top' src='gambar/" .$row['gambar_event']."' alt='Card image cap'></a>"?>
  						<div class="card-body">
  						  	<div class="row">
								<div class="col-6">
									<!-- <p class="month">Jan</p>
									<p class="day">20</p> -->
									<div class="eventTitle">
										<h2> <?php echo $row['judul_event']; ?> </h2>
									</div>
									<p class="time"><?php echo $row['tanggal_mulai']; ?>, <?php echo $row['waktu_mulai']; ?></p>
								</div>
								<div class="col-6">
									<p class="place"> <?php echo $row['lokasi']; ?> </p>
									<p class="status_ticket">
									<?php 
									if ($row['harga'] == 0) {
										echo 'free';
									}
									else{
										echo 'Rp '.$row['harga'];	
									}
									 ?> </p>
								</div>	
							</div>
							<p class="time"><?php echo $row['tanggal_mulai']; ?>, <?php echo $row['waktu_mulai']; ?></p>
							<p class="place"> <?php echo $row['lokasi']; ?> </p>
							<p class="status_ticket">
							<?php 
							if ($row['harga'] == 0) {
								echo 'free';
							}
							else{
								echo 'Rp '.$row['harga'];	
							}
							 ?> </p>
  						</div>
					</div>
					</div>
				<?php		
					}
				}
				mysqli_close($con); 
				?>
		</div>
		<div class="row">
			<div class="col-4"></div>
			<div class="col-4"></div>
			<div class="col-4"></div>
		</div>
	</div>

<?php include 'footer.php'?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.5.6/picker.js"></script>
</body>
</html>
				