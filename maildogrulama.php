<?php  session_start();

try  {
	$baglanti = new PDO("mysql:host=localhost;dbname=maildogrulama;charset=utf8","root","");
	$baglanti->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	
	}
	catch (PDOException $e) {
	die($e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="tr">
<head>
	<title>MAİL DOĞRULAMA</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
			<?php
            if(isset($_GET["guvenlikkodu"])):
                $gelenkod=$_GET["guvenlikkodu"];
				$kontrolet=$baglanti->prepare("SELECT * FROM uyeler WHERE dogrulama='".$gelenkod."'");
				$kontrolet->execute();
                if($kontrolet->rowCount()>0):
					$uyebilgisi=$kontrolet->fetch();
                    if($uyebilgisi["durum"]==1):
                        echo '<div class="alert alert-success">'.$uyebilgisi["ad"].'<br>Üyeliğiniz Zaten Aktifleştirilmiş</div>';
                        header("Refresh:3; url=index.php");
                    else:
                        $baglanti->query("UPDATE uyeler SET durum=1 WHERE id=".$uyebilgisi["id"]);
					    echo '<div class="alert alert-success">'.$uyebilgisi["ad"].'<br>Üyeliğiniz Başarıyla Aktifleştirildi </div>';
                    endif;
					//echo $uyebilgisi["ad"]."<br>";
					
				else:
					echo '<div class="alert alert-danger">'.@$uyebilgisi["ad"].'<br>Aktivasyon Kodu Hatalıdır</div>';
                    header("Refresh:3; url=ikinci.php");
				endif;
			else:	
                header("Refresh:3; url=ikinci.php");
			endif;			
				?>
			</div>
		</div>
	</div>
	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>