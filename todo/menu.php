	<div id="menu">
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
				</div>
				<?php 
				if(isset($_SESSION["id"])){
					echo '<a class="navbar-brand navbar-right" href="todo.php">מנהל המשימות</a>';
					echo '<ul class="nav navbar-nav navbar-right" id="listeMenu">';
						echo '<li class="menu"><a href="endTask.php">משימות שהושלמו</a></li>';
						echo '<li class="menu"><a href="taskInProgress.php">משימות בביצוע</a></li>';
						echo '<li class="menu"><a href="startTask.php">התחל משימה</a></li>';
						echo '<li class="menu"><a href="addTask.php">הוסף משימה חדשה</a></li>';
						echo '<li class="menu active"><a href="todo.php">רשימת משימות</a></li>';
					echo '</ul>';
					//echo '<script type="text/javascript" src="js/script.js"></script>';
					echo '<ul class="nav navbar-nav">';
					    echo '<li><a href="logout.php">התנתקות</a></li>';
						echo '<li id="welcome">';
						$co = getConnection($connection);
						$sqlSelectName = 'SELECT username FROM users WHERE id = ' . $_SESSION['id'];
						$nom = $co->query($sqlSelectName)->fetch();
						echo "שלום " . $nom["username"] . "! </li>";
					echo '</ul>';
				}else{
					echo '<a class="navbar-brand navbar-right" href="index.php">מנהל המשימות</a>';
					echo '<ul class="nav navbar-nav">';
						echo '<li><a href="register.php">משתמש חדש</a></li>';
						echo '<li><a href="index.php">התחברות</a></li>';
					echo '</ul>';
				}
				?>
			</div>
		</nav>
		
