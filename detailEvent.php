<?php

include 'helper/koneksi.php';
    session_start();

$id_events = $_GET["id"]; 

$prev = $_SERVER['HTTP_REFERER'];
$query = "SELECT * FROM events WHERE id_events = $id_events";
	$result = mysqli_query($con, $query);

	if(mysqli_num_rows($result) == 1) {
        $event = mysqli_fetch_assoc($result);
        $id_events = $event["id_events"];
	} else {
	    echo "Event tidak ditemukan";
    }
    
?>

<!DOCTYPE html>
<html>

<head>
    <title><?= $event['judul_event']?> | Event.com</title>
    <?php include 'head.php'?>
</head>
<body>
    <?php include 'header.php'?>
    
    <div class="container descEvent">
        <div class="row">
            <div class="col-1"></div>
            <div class="container-fluid col-10 mt-4">
            <form class="detailEvent" action="proses/registrasiEvent.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="idEvents" value="<?php echo $event["id_events"];?>">
                <h2 class="judulEvent"><?php echo $event['judul_event']; ?></h2>
                    <p class="by">Dipublikasi oleh 
                    <?php
                        $query = "SELECT u.nama FROM users as u inner join events as e on e.id_users = u.id_users where e.id_events = $id_events";
						$result = mysqli_query($con, $query);
						$username = mysqli_fetch_assoc($result);
						echo $username['nama']; 
					?>
                    </p>
                    
                    <?php echo"<img class='card-img-top' src='gambar/" .$event['gambar_event']."' alt='Card image cap'>"?>
                    <div class="row">
                        <div class="col-8">
                            <h4 class="waktu_lokasi_desc">Deskripsi</h4>
                                <p class="deskripsi">
                                <?php echo $event['deskripsi']; ?>
                        </div>
                        <div class="col-4">
                            <label class="mb-2 waktu_lokasi_desc">Instansi Penyelenggara</label>
                            <p><?php echo $event['nama_penyelenggara']; ?></p>
                            
                            <label class="mt-4 mb-2 waktu_lokasi_desc">Tanggal dan Waktu</label>
                            <p class="timeEvent" style="font-size:0.8em;"><?php echo $event['tanggal_mulai']; ?>, <?php echo $event['waktu_mulai']; ?> WIB - </br><?php  echo $event['tanggal_akhir']; ?>, <?php echo $event['waktu_akhir']; ?> WIB</p>
                            
                            <label class="mt-4 mb-2 waktu_lokasi_desc">Lokasi</label>
                                <p class="place"> <?php echo $event['lokasi']; ?></p>
                                <p class="peta"> <a href="<?php echo $event['urls']; ?>"> Lihat Peta </a></p>

                            <label class="mt-4 mb-2 waktu_lokasi_desc">Tiket</label>
                                <span> : Rp 
                                <?php
                                    if ($event['harga'] == 0) {
                                        echo 'free';
                                    }
                                    else{
                                        echo $event['harga'];	
                                    }
                                ?>
                                </span> </br> 
                        </div>
                    </div>
                    <!-- <a href='proses/registrasiEvent.php?id=$id_events' class='btn btn-success btn-block mt-3'>Registrasi</a> -->
                    <?php
                        if ($prev == 'http://localhost/web_project/myEvent.php') {
                            echo '<a name="backBtn" id="backBtn" class="btn btn-dark btn-block mt-3" href="myEvent.php" role="button">Kembali</a>';
                        }
                        else {
                    ?>
                            <div class="row">
                                <div class="col-6">
                                    <a name="backBtn" id="backBtn" class="btn btn-dark btn-block mt-3" href="indexUser.php" role="button">Kembali</a>
                                </div>
                                <div class="col-6">
                                    <input type="submit" name="submit" value="submit" class="btn btn-success btn-block mt-3">
                                </div>
                            </div>
                    <?php
                        }
                    ?>
            </form> 
            </div>
            <div class="col-1"></div>
        </div>
    </div>
    <?php include 'footer.php';?>
</body>
</html>