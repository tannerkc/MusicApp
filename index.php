<?php
	include("includes/config.php");
	include("includes/classes/Account.php");
	include("includes/classes/Constants.php");

	$account = new Account($con);

	include("includes/handlers/login-handler.php");
	include("includes/handlers/register-handler.php");

	function getInputValue($name) {
		if(isset($_POST[$name])) {
			echo $_POST[$name];
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Riverr</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="stylesheet" type="text/css" href="https://kit-pro.fontawesome.com/releases/v5.11.2/css/pro.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    
    <link rel="stylesheet" type="text/css" href="assets/css/register.css">

</head>
<body>

<div id="background"></div>
	<div id="loginContainer">
		<div id="inputContainer">
		<form id="loginForm" action="index.php" method="POST">
			<h2>Login</h2>
			<?php echo $account->getError(Constants::$loginFailed); ?>
			<p>
				<label for="loginUsername">Username</label>
				<input id="loginUsername" name="loginUsername" type="text" placeholder="e.g. peaTearGriffin" value="<?php getInputValue('loginUsername') ?>" required>
			</p>
			<p>
				<label for="loginPassword">Password</label>
				<input id="loginPassword" name="loginPassword" type="password" placeholder="*******" required>
			</p>
			<button type="submit" name="loginButton"> Continue </button>

			<div class="hasAccount">
				<span id="hideLogin">Dont have an account yet? Sign Up.</span>
			</div>
		</form>
	

		<form id="signupForm" action="index.php" method="POST">
			<h2>Sign Up</h2>
			<p>
				<?php echo $account->getError(Constants::$usernameCharacters); ?>
				<?php echo $account->getError(Constants::$usernameTaken); ?>
				<label for="username">Username</label>
				<input id="username" name="username" type="text" placeholder="e.g. peaTearGriffin" value="<?php getInputValue('username') ?>" required>
			</p>
			<p>
				<?php echo $account->getError(Constants::$fnameCharacters); ?>
				<label for="firstName">First Name</label>
				<input id="firstName" name="firstName" type="text" placeholder="e.g. Peter" value="<?php getInputValue('firstName') ?>" required>
			</p>
			<p>
				<?php echo $account->getError(Constants::$lnameCharacters); ?>
				<label for="lastName">Last Name</label>
				<input id="lastName" name="lastName" type="text" placeholder="e.g. Griffin" value="<?php getInputValue('lastName') ?>" required>
			</p>
			<p>
				<?php echo $account->getError(Constants::$emailInvalid); ?>
				<?php echo $account->getError(Constants::$emailTaken); ?>
				<label for="email">Email</label>
				<input id="email" name="email" type="email" placeholder="e.g. ptgriffin@hotmail.com" value="<?php getInputValue('email') ?>" required>
			</p>
			<p>
				<?php echo $account->getError(Constants::$pwNoMatch); ?>
				<?php echo $account->getError(Constants::$pwNotAlphanumeric); ?>
				<?php echo $account->getError(Constants::$pwCharacters); ?>
				<label for="password">Password</label>
				<input id="password" name="password" type="password" placeholder="*******" required>
			</p>
			<p>
				<label for="confPassword">Password</label>
				<input id="confPassword" name="confPassword" type="password" placeholder="*******" required>
			</p>
			<button type="submit" name="signupButton"> Continue </button>
			<div class="hasAccount">
				<span id="hideRegister">Already have an account? Log in.</span>
			</div>
		</form>
	</div>
	<div id="loginText">
		<h1>Welcome to Riverr</h1>
		<h2>Great music in seconds, for free.</h2>
		<ul>
			<li><i class="fas fa-check"></i> Discover New Artists</li>
			<li><i class="fas fa-check"></i> Create Custom Playlists</li>
			<li><i class="fas fa-check"></i> Follow Artists and Stay Up-To-Date</li>
		</ul>
	</div>

</div>

<script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
<script type="text/javascript" src="assets/js/register.js"></script>

	<?php
	if(isset($_POST['signupButton'])) {
		echo '<script>
		$(document).ready(function() {
			$("#loginForm").hide();
			$("#signupForm").show();
		});
		</script>';
	}
	else {
		echo '<script>
		$(document).ready(function() {
			$("#loginForm").show();
			$("#signupForm").hide();
		});
		</script>';
	}
	?>
</body>
</html>