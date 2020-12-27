<?php
ob_start();
?>
<?php
if (!isset($_SESSION)) session_start(); //Checks if a session has been started and if not it starts it. You will need a session to be able to pass the login data from one page to another in a $_SESSION variable
require_once('connection/conn.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="description" content="User Login Form">
	<title>Packshoot ApS - Ordregodkendelse</title>
	<meta name="author" content="Torben Petersen Fink">


	<!-- CDN -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
		integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

	<!-- Custom styles for this template -->
	<link href="css/signin.css" rel="stylesheet">
</head>

<body>
<?php
		if (isset($_SESSION['id'])) { //checks that the session contains the id, if not forbids access to the page
      header('Location: mineordrer.php');
      ob_flush();
		}
		?>

	<form class="form-signin" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
		<div class="text-center">
			<img class="mb-5" src="img/logo-black.png" alt="" width="171" height="75">
		</div>
		<h1 class="h3 mb-3 font-weight-normal">Log ind</h1>
		<label for="inputEmail" class="sr-only">Email addresse</label>
		<input type="text" name="email" id="inputEmail" class="form-control" placeholder="Email address" required
			autofocus>
		<label for="inputPassword" class="sr-only">Kodeord</label>
		<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
		<button class="btn btn-lg btn-dark btn-block" type="submit" name="submit">Log ind</button>

	<?php
		if (isset($_POST['email']) && isset($_POST['password'])) {
			$email_temp = mysqli_entities_fix_string($dbCon, $_POST['email']); //temporary value of username secured through a function
			$password_temp = mysqli_entities_fix_string($dbCon, $_POST['password']); //temporary value of password secured through a function
			$query = "SELECT * FROM psv2_users WHERE email = '$email_temp'"; //Her indsætter du, at email skal være = med den indskrevet ligmed fra tabellen.
            $result = mysqli_query($dbCon, $query);
            
			if (!$result) { //Hvis vi ikke modtager et resultat, så send en ERROR.
				echo "<p class='error'>MySQL Error: " . mysqli_error($dbCon) . "</p>";
				die();
			}
			elseif (mysqli_num_rows($result)) { // Ellers hvis, vi modtager et resultat fra databasen, så INDHENT EMAIL, OG PASSWORD.
				$row = mysqli_fetch_assoc($result);
				mysqli_free_result($result);

				$id = $row['id'];
				$email = $row['email'];
				$password = $row['password'];

				$token = (password_verify($password_temp, $password));
                
				if ($token == $password_temp) { // HVIS PASSWORD ER KORREKT, TILLADES BRUGEREN AT TILGÅ SIDEN.
					$_SESSION['id'] = $id; //SESSION SÆTTES. VÆRDIEN id INDSAMLES FRA OVEN, OG GØR DET MULIGT VIDERESENDE VORES S_SESSIONVARIABLE.
					header('Location: mineordrer.php');
					ob_flush();
                }
				else {
					echo "<p class='text-center'>Password eller kode er forkert.</p>"; // This is triggered if the password fails
					die();
				}
			}
				else {
					echo "<p class='text-center'>Password eller kode er forkert.</p>"; // This is triggered if the username fails
					die();
			}
		}
		?>

<a href="img\ordrer\18924-Soyaconcept PS21.rar" download>hej

</a>
</form>
</body>

</html>

<?php
function mysqli_entities_fix_string($dbCon, $string) {
	return htmlentities(mysqli_fix_string($dbCon, $string));
}

function mysqli_fix_string($dbCon, $string) {
	if (get_magic_quotes_gpc()) $string = stripslashes($string);
	return mysqli_real_escape_string($dbCon, $string);
}
?>