<?php 
include("includes/includedFiles.php");
?>

<div class="userDetails">

	<div class="container borderBottom">
		<h2>Email</h2>
		<input type="email" name="email" class="email" placeholder="Update Email..." value="<?php echo lcfirst($userLoggedIn->getEmail()); ?>">
		<span class="message"></span>
		<button class="button" onclick="updateEmail('email')">Update</button>
	</div>

	<div class="container">
		<h2>Password</h2>
		<input type="password" name="oldPassword" class="oldPassword" placeholder="Current Password">
		<input type="password" name="newPassword1" class="newPassword1" placeholder="New Password">
		<input type="password" name="newPassword2" class="newPassword2" placeholder="Confirm New Password">
		<span class="message"></span>
		<button class="button" onclick="updatePassword('oldPassword', 'newPassword1', 'newPassword2')">Update</button>
	</div>
	
</div>