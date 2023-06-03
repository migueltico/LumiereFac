<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Password changed</title>
</head>

<body>
	<div id="card">
		<h1>Contraseña cambiada</h1>
		<p>Se ha cambiado la contraseña del usuario <strong><?php echo $user ?></strong> a <strong><?php echo $pass ?></strong></p>
	</div>
	<style>
		body {
			font-family: Arial, Helvetica, sans-serif;
		}

		h1 {
			color: #0d6efd;
		}

		p {
			color: #212529;
		}

		div#card {
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			width: 500px;
			padding: 20px 40px;
			border: 1px solid #ccc;
			border-radius: 10px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
		}
	</style>

</body>

</html>