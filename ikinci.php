<?php  session_start();

try  {
	$baglanti = new PDO("mysql:host=localhost;dbname=maildogrulama;charset=utf8","root","");
	$baglanti->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	
	}
	catch (PDOException $e) {
	die($e->getMessage());
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMAİLLER/src/Exception.php';
require 'PHPMAİLLER/src/PHPMailer.php';
require 'PHPMAİLLER/src/SMTP.php';
$mail = new PHPMailer(true);
if(isset($_POST["mail"]) && $_POST["mail"]!=""):
	$kodumuz= substr(md5(mt_rand(0,99999)),2,6);


try {
    //Server settings
    $mail->SMTPDebug =0;                      //Enable verbose debug output
    $mail->isSMTP();                          //Send using SMTP
    $mail->Host       = 'bonusgafa.xyz';      //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                 //Enable SMTP authentication
    $mail->Username   = 'mtahakuyuk@bonusgafa.xyz';  //SMTP username
    $mail->Password   = 'TAHAtuna5319*';   //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
    $mail->Port       = 465;             //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
	//To load the French version
	$mail->setLanguage('tr','PHPMAİLLER/language/');
	$mail->CharSet='UTF-8';
    //Recipients
    $mail->setFrom($mail->Username, 'Mail Doğrulama Sistemi');
    $mail->addAddress(htmlspecialchars($_POST["mail"]));               //Name is optional

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'ÜYELİK AKTİVASYON';
    //$mail->Body    = '<b>DOĞRULAMA KODU:</b>'.$kodumuz.'<br><br><br>Üyeliğinizi aktif edin, fırsatlardan yararlanın'; //farklı sayfaya gitmeden doğrulama kodu
	$mail->Body    = '<b>DOĞRULAMA Linki:</b> http://localhost/maildogrulamabaslangic/maildogrulama.php?guvenlikkodu='.$kodumuz; //farklı sayfada doğrulama kodu girme
    $mail->send();
	$sifreSifrelendi=md5(@$_POST["sifre"]);
	$ekleme=$baglanti->prepare("INSERT INTO uyeler(ad,sifre,mail,dogrulama) VALUES(?,?,?,?)");
	$ekleme->execute(array(
		$_POST["username"],
		$sifreSifrelendi,
		$_POST["mail"],
		$kodumuz
	));

} 
catch (Exception $e) {
}
endif;
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
			if (isset($_POST["dogkod"])):
				$gelenkod=$_POST["dogkod"];
				$kontrolet=$baglanti->prepare("SELECT * FROM uyeler WHERE dogrulama='".$gelenkod."'");
				$kontrolet->execute();
				if($kontrolet->rowCount()>0):
					$uyebilgisi=$kontrolet->fetch();
					//echo $uyebilgisi["ad"]."<br>";
					$baglanti->query("UPDATE uyeler SET durum=1 WHERE id=".$uyebilgisi["id"]);
					echo '<div class="alert alert-success">'.$uyebilgisi["ad"].'<br>Üyeliğiniz Başarıyla Aktifleştirildi </div>';
				else:
					echo "yok";

				endif;
			
				
				// MAİL İLE GELEN KODU BURADA KONTROL EDECEĞİZ
			else:

			?>
			
				<form class="login100-form validate-form" method="post" action="ikinci.php">
					<span class="login100-form-title p-b-49">
						DOĞRULAMA KODU KONTROLÜ
					</span>

					<div class="wrap-input100 validate-input m-b-23" data-validate = "Doğrulama Kodu zorunludur">
						<span class="label-input100">Doğrulama Kodu</span>
						<input class="input100" type="text" name="dogkod" placeholder="Doğrulama Kodunu giriniz">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>
					
										

					
					<div class="container-login100-form-btn mt-3">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							
							
							<button class="login100-form-btn" type="submit">
								Tamam
							</button>
						</div>
					</div>

					

				</form>
				
					
				<?php 				
				
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