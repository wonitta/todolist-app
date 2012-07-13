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
		
		<?php if(isset($_SESSION["user"])): 
			header('Location: ./todolist.php'); ?>			
		<?php else: ?>
		<center><form id=myform method="post">
			<fieldset>
				<legend>Login Information:</legend>
				<ol>
					<li>
						<label for="username">Username</label>
						<input id="username" name="username" type=text placeholder="Enter your username" required autofocus>
					</li>
					<li>
						<label for="password">Password</label>
						<input id="password" name="password" type=text placeholder="Enter your password" required>
					</li>
				</ol>
			</fieldset>
			<center><input name="login" type="submit" value="Login" class="button" id="button"/></center>
		</form></center>
		<?php endif; ?>		
		<hr/>

<?php include 'footer.php'; ?>


