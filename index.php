<?php
error_reporting(E_ALL);
define('port', 8080);
define('host', '192.168.43.1');
class Sms {
	public function kirim($nomor, $pesan) {
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if ($socket === false) {
			echo '<script type="text/javascript">alert("socket_create() failed: reason: "' . socket_strerror(socket_last_error()) . '");</script>';
			header("location : http://localhost/smsgateway");

		}

		// Membuat koneksi ke socket
		$result = socket_connect($socket, host, port);

		if ($result === false) {
			echo '<script type="text/javascript">alert("Koneksi Socket Tidak Tersedia.");</script>';
			header("location : http://localhost/smsgateway");
		}

		$in = $nomor . ";" . $pesan . "\r\n\r\n";
		$out = '';
		socket_write($socket, $in, strlen($in));

		// Ambil response dari socket server
		$out = '';
		while ($buffer = socket_read($socket, 2048)) {
			$out = $out . $buffer;
		}
		socket_close($socket);

		echo '<script type="text/javascript">alert("Pesan Telah Dikirim.");</script>';
		header("location : http://localhost/smsgateway");
	}
}
$sms = new Sms();
(isset($_POST['phone']) ? $phone = $_POST['phone'] : null);
(isset($_POST['message']) ? $message = $_POST['message'] : null);
$sms->kirim($phone, $message);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="SMS Gateway">
		<meta name="author" content="Dias Taufik Rahman">
		<title>SMS Gateway</title>
		<!-- Bootstrap Core CSS -->
		<link href="./assets/css/bootstrap.min.css" rel="stylesheet">
		<!-- Custom CSS -->
		<style>
		body {
		padding-top: 70px;
		/* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
		}
		</style>
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<!-- Navigation -->
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">SMS Gateway</a>
				</div>
			</div>
			<!-- /.container -->
		</nav>
		<!-- Page Content -->
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					SMS Gateway
				</div>
				<div class="panel-body">
					<form class="form-horizontal" method="POST">
						<div class="form-group">
							<label class="col-sm-2 control-label">Nomor Telepon</label>
							<div class="col-sm-8">
								<input type="text" name="phone" class="form-control" placeholder="Nomor Telepon" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Pesan</label>
							<div class="col-sm-8">
								<textarea class="form-control" placeholder="Isi Pesan" name="message"></textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-8">
								<button type="submit" class="btn btn-default">Kirim</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<!-- /.row -->
		</div>
		<!-- /.container -->
		<!-- jQuery Version 1.11.1 -->
		<script src="./assets/js/jquery.js"></script>
		<!-- Bootstrap Core JavaScript -->
		<script src="./assets/js/bootstrap.min.js"></script>
	</body>
</html>