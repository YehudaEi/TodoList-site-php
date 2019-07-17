<?php 

include 'session.php';
include 'database.php';
include 'fonctions.php';

if(isset($_SESSION["id"])) header("location: todo.php");

if(!empty($_POST)){
	if($_POST["password"] === $_POST["password2"]){
		if(validateRequiredField('username') && validatePassword('password')){
			$co = getConnection($connection);
			$username = $_POST['username'];
			$requete = "INSERT INTO users (username, password, salt) VALUES (:username, :password, :salt)";

			$salt = generateSalt();
			hashPassword($_POST['password'], $salt);
			$password = $_POST["password"];

			$insertion = $co->prepare($requete);
			$insertion->execute(array(
				":username" => $_POST["username"],
				":password" => $password,
				":salt" => $salt
			));
			$sqlSelect = "SELECT * FROM users WHERE username LIKE \"$username\"";
			$result = $co->query($sqlSelect)->fetch();
			$_SESSION['id'] = $result['id']; 
			header('Location: todo.php');
			exit(0);
		}
	}
}
 	 ?>
<?php 
include 'head.php';
include 'menu.php';
 ?>
	<div class="CONTAINER">
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6">
				
				<div id="contact">
					<div id="barreConnexion" style="margin-right: 7px;"><p id="textConnexion">הרשמה</p></div>
					<div id="formulaire">
						<form action="#" method="POST">
							<p>שם משתמש:</p>
							<input type="text" name="username" id="username" required autofocus autocomplete <?php displayValue('username') ?>>
							<p>סיסמה: </p>
							<input type="password" name="password" id="password" required>
							<p>אימות סיסמה:</p>
							<input type="password" name="password2" id="password" required>
							<p></p>
							<input type="submit" value="רישום" id="btnLogin" class="btn btn-default">
						</form>
					</div>
				</div> 
			</div>
			<div class="col-sm-3"></div>
		</div> 

<?php 
include 'footer.php';
 ?>