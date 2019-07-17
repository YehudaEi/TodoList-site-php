<?php 
include 'login.php';

 ?>
	<div class="CONTAINER">
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6">
				<div id="startTaskBox">
					<div id="barreStartTask"><p id="textStartTask">התחל משימה</p></div>
					<div id="selectStartTask">
						<form action="" method="POST">
							<?php
								$co = getConnection($connection);
								$id = intval($_SESSION['id']);
								$tasks = 'SELECT task FROM tasks WHERE id_user = ' . $_SESSION['id'];
								$tasks = $co->query($tasks)->fetchAll();
								$states = 'SELECT state FROM tasks WHERE id_user = ' . $_SESSION['id'];
								$states = $co->query($states)->fetchAll();
								$cptTask = 0;
								foreach ($tasks as $key => $task)
								{		
									if($states[$key]['state'] === '0')
									{
										echo '<input type="radio" name="selectRadio" id="check' . $key . '" value="' . $key . '" >';
										echo '<label class="checkBox" for=check' . $key . '>' . $task["task"]. '</label>';
										if($states[$key]['state'] === '1')
											echo '<label class="inProgress">בתהליך</label>';
										
										echo '<br>';
										$cptTask++;
									}
								}
								if($cptTask === 0){
									echo "<p>אין משימות שממתינות</p>";
								}
							 ?>
							<br>
							<?php if($cptTask > 0){ ?>
							    <input type="submit" value="התחל" class="btn btn-default" id="btnStartTask">
							<?php } ?>
						</form>
					</div>
				</div> 
			</div>
			<div class="col-sm-3"></div>
		</div>
		<?php 
		if(isset($_POST) && isset($_POST['selectRadio'])){
			$taskId = 'SELECT id FROM tasks WHERE id_user = ' . $_SESSION['id'];
			$taskId = $co->query($taskId)->fetchAll();
			foreach ($taskId as $key => $ID) 
			{
				if($states[$key]['state'] === '0' && intval($_POST["selectRadio"]) === $key)
				{	
					$update = 'UPDATE test.tasks SET `state`=:state, `time_start`=:time_start WHERE `id`=:id';
					$update = $co->prepare($update);
					$update->execute(array(
						":state" => 1,
						":time_start" => date("Y-m-d H:i:s"),
						":id" => intval($ID['id'])
					));
					echo "<script>location.reload();</script>";
				}
			}
		}
		 ?>		
<?php 
include 'footer.php';
 ?> 