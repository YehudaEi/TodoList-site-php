<?php 
include 'login.php';
 ?>
	<div class="CONTAINER">
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6">
				<div id="todoBox">
					<div id="barreTodo"><p id="textTodo">רשימת משימות</p></div>
					<div id="todoCheckbox">
						<form action="#" method="POST">
							<?php //toDo(); 
							$co = getConnection($connection);
							if(isset($_SESSION['id'])){
								$tasks = 'SELECT task FROM tasks WHERE id_user = ' . $_SESSION['id'];
								$tasks = $co->query($tasks)->fetchAll();
								$states = 'SELECT state FROM tasks WHERE id_user = ' . $_SESSION['id'];
								$states = $co->query($states)->fetchAll();
								foreach ($tasks as $key => $task)
								{		
									if($states[$key]['state'] === '0' || $states[$key]['state'] === '1')
									{		
										echo '<input name="box[]" type="checkbox" id="check' . $key . '" value=' . $key .' >';
										echo '<label class="checkBox" for=check' . $key . '>' . $task["task"]. '</label>';
										if($states[$key]['state'] === '1'){ echo '<label class="inProgress">מתבצעת</label>'; }
										echo '<br>';
									}	
								}
							}
							?>
							<?php if($cptTask > 0){ ?>
							    <br>
							    <input type="submit" value="המשימות הושלמו" class="btn btn-default" id="btnStartTask">
							<?php } else { ?>
							    <p>אין משימות שממתינות</p>
							<?php } ?>
						</form>
					</div>
				</div> 
			</div>
			<div class="col-sm-3"></div>
		</div> 
		<?php 
		if(isset($_POST) && isset($_POST['box']))
		{
			if(!empty($_POST['box'])){
			    foreach($_POST['box'] as $box) {
					$taskId = 'SELECT id FROM tasks WHERE id_user = ' . $_SESSION['id'];
					$taskId = $co->query($taskId)->fetchAll();
					if($states[$box]['state'] === '0' || $states[$box]['state'] === '1')
					{	
						$update = 'UPDATE tasks SET state=:state, time_end=:time_end WHERE id=:id';
						$update = $co->prepare($update);
						$update->execute(array(
							":state" => 2,
							":time_end" => date("Y-m-d H:i:s"),
							":id" => intval($taskId[$box]['id'])
						));
						echo "<script>location.reload();</script>";
					}
				}
			}
		}
		 ?>

<?php 
include 'footer.php';
 ?>