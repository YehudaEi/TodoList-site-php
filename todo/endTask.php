<?php 
include 'login.php';
 ?>
	<div class="CONTAINER">
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-8">
				<div id="endTaskBox">
					<div id="barreEndTask"><p id="textEndTask">משימות שהושלמו:</p></div>
					<div id="endTaskDisplay">
						<p id="lign"></p>
						<h3 class="task"><b>משימה</b></h3>
						<h3 class="time"><b>משך זמן</b></h3>
						<div class="clearfix"></div>
						<p id="lign"></p>
						<?php 
							$co = getConnection($connection);
							$tasks = 'SELECT task FROM tasks WHERE id_user = ' . $_SESSION['id'];
							$tasks = $co->query($tasks)->fetchAll();
							$states = 'SELECT state FROM tasks WHERE id_user = ' . $_SESSION['id'];
							$states = $co->query($states)->fetchAll();
							$times_creation = 'SELECT time_creation FROM tasks WHERE id_user = ' . $_SESSION['id'];
							$times_creation = $co->query($times_creation)->fetchAll();
							$times_start = 'SELECT time_start FROM tasks WHERE id_user = ' . $_SESSION['id'];
							$times_start = $co->query($times_start)->fetchAll();
							$times_end = 'SELECT time_end FROM tasks WHERE id_user = ' . $_SESSION['id'];
							$times_end = $co->query($times_end)->fetchAll();
							
							foreach ($tasks as $key => $task){
								if($states[$key]['state'] === '2'){
									$time_length = new dateTime;
									$dteCreation = new DateTime($times_creation[$key]['time_creation']);
									$dteStart = new DateTime($times_start[$key]['time_start']);
		   							$dteEnd   = new DateTime($times_end[$key]['time_end']); 

									if($dteStart == "0000-00-00 00:00:00"){
										$time_length = $dteCreation->diff($dteEnd);
									}else{
										$time_length = $dteStart->diff($dteEnd);
									}
									echo '<h4 class="task" for=check' . $key . '>' . $task["task"]. '</h4>';
									echo '<h4 class="time">' . $time_length->format("%Y/%m/%d %H:%I:%S") . '</h4>';
									echo '<div class="clearfix"></div>';
									echo '<p id="lign"></p>';
								}	
							}
						?>
					</div>
				</div> 
				<!--
				//מחיקת הערות שסויימו אינה פעילה
				<form action="#" method="POST">
					<input type="submit" value="מחק משימות שהושלמו" id="btnEndTask" class="btn btn-default">
				</form>-->
			</div>
			<div class="col-sm-2"></div>
		</div>
	</div>
	<?php
	//מחיקת הערות שסויימו אינה פעילה
	if(false && isset($_POST)){
		$co = getConnection($connection);
		$requeteSuppr = 'DELETE FROM `tasks` WHERE state=2 AND id_user=' . $_SESSION['id'];
		$suppression = $co->prepare($requeteSuppr);
		$suppression = $co->exec($requeteSuppr);
	}
	 ?>
<?php 
include 'footer.php';
 ?>