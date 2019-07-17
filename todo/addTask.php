<?php 
include 'fonctions.php';
include 'login.php';
?>
	<div class="CONTAINER">
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6">
				<div id="addTaskBox">
					<div id="barreAddTask"><p id="textAddTask">הוסף משימה</p></div>
					<div id="inputAddTask">
						<form action="#" method="POST">
							<p>משימה:</p>
							<input type="text" value="" name="task" id="task">
							<br><br>
							<input type="submit" value="הוסף" id="btnAddTask" class="btn btn-default">
						</form>
					</div>
				</div> 
			</div>
			<div class="col-sm-3"></div>
		</div> 
<?php 
if(!empty($_POST)){
	if(validatePassword('task')){
		$co = getConnection($connection);
		$task = $_POST['task'];

		$username = 'SELECT username FROM users WHERE id = ' . $_SESSION['id'];
		$username = $co->query($username)->fetch();

		$requete = "INSERT INTO tasks (id_user, task, state, time_creation) VALUES (:id_user, :task, :state, :time_creation)";
		$insertion = $co->prepare($requete);
		$insertion->execute(array(
			":id_user" => $_SESSION['id'],
			":task" => $task,
			":state" => 0,
			":time_creation" => date("Y-m-d H:i:s")
		));

		echo "<p class=\"text-center\">הנה " . $username["username"] . ", המשימה : \"$task\" נוספה בהצלחה!</p>";
	}
}
 ?>
<?php 
include 'footer.php';
 ?>
