<?php 
    include 'session.php';
    include 'fonctions.php';
    include 'database.php';
    
    if(isset($_SESSION["id"])) header("location: todo.php");
?>

<?php 
    include 'head.php';
    include 'menu.php';
?>
	<div class="CONTAINER">
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6">
				
			    <div id="message">המערכת דורשת התחברות</div>
				<div id="incorrectpassword">שם המשתמש או הסיסמה שגויים!</div>
				<div id="contact">
					<div id="barreConnexion"><p id="textConnexion">התחברות</p></div>
					<div id="formulaire">
						<form action="#" method="POST">
							<p>שם משתמש:</p>
							<input type="text" name="username" id="username" required autofocus autocomplete <?php displayValue('username') ?>>
							<p>סיסמה:</p>
							<input type="password" name="password" id="password" required>
							<p></p>
							<input type="submit" value="כניסה" id="btnLogin" class="btn btn-default">
						</form>
					</div>
				</div> 
			</div>
			<div class="col-sm-3"></div>
		</div> 

<?php 
if(!empty($_POST)){
	if(validateRequiredField('username') && validatePassword('password')){
		$co = getConnection($connection);
		$username = $_POST['username'];
		$sql = "SELECT * FROM users WHERE username LIKE \"$username\"";

		$result = $co->query($sql)->fetch();
		if($result !== false){
			$password = $result['password'];
			$salt = $result['salt'];
			hashPassword($_POST['password'], $salt);

			if(strcmp($_POST['password'], $password)== 0){
				$_SESSION['id'] = $result['id']; 
				echo "<script>window.location='todo.php'</script>";
				exit(0);
			}else{
				echo '<style>#incorrectpassword{ display:block; }</style>';
			}
		}else{
			echo '<style>#incorrectpassword{ display:block; }</style>';
		}
	}else{
		echo '<style>#message{ display:block; }</style>';
	}
}
if(!isset($_SESSION["count"])){
	$_SESSION["count"] = 1;
}else{
	echo '<style>#message{ display:block; }</style>';
}
 ?>

<?php 
    include 'footer.php';
?>

