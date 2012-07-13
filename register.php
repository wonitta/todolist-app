<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

require_once 'engine.php';
include 'header.php';
?>

		<?php if(isset($msg)): ?>
		<div id="message">
		<?php echo $msg; ?>
		</div>
		<?php endif; ?>
		
		<?php if(isset($_SESSION["user"])): ?>
		<form method="post">
			<a href="./login.php" title="refresh">home</a>
			<input id="logout" name="logout" type="submit" value="logout" />
		</form>


		<hr/>
		<?php echo $form; ?>
		<hr/>
		<?php else: ?>
		<center><form id=myform method="post">
			<fieldset>
				<legend>Create a new user</legend>
				<ol>
					<li>
						<label for="username">Username</label>
						<input id="username" name="username" type=text placeholder="Enter a username" required autofocus>
					</li>
					<li>
						<label for="password">Password</label>
						<input id="password" name="password" type=text placeholder="Enter a password" required>
					</li>
				</ol>
			</fieldset>
			<center><input name="register" type="submit" value="SIGN UP!" class="button" id="button"/></center>
		</form></center>
		<?php endif; ?>		
		<hr/>

<?php include 'footer.php'; ?>

