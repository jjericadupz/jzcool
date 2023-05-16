<?php
session_start();

	if(isset($_SESSION['userN'])){
		echo "Welcome ".$_SESSION['userN'];
		displaysessionDestroy();
	}else{
		$conn = mysqli_connect("localhost","root","");
		if(!$conn){
			echo "Could not connect to mysql Please Start your Mysql Service First or check your connetion details!";
		}else{
			//echo "Connected!";
				$show = "show databases like 'admindb';";
				$exec = mysqli_query($conn,$show);
				if(MYSQLI_NUM_ROWS($exec) > 0){
					//echo "yes";
						$selectdb = mysqli_select_db($conn,'admindb');
						$showtbl = "show tables like 'admin'";
						$showqry = mysqli_query($conn, $showtbl);

						if(MYSQLI_NUM_ROWS($showqry) > 0){
							//echo "table exists";
							$showAll = "select * from admin where username = 'admin' and password = 'admin'";
							$showAllqry = mysqli_query($conn,$showAll);

							if(MYSQLI_NUM_ROWS($showAllqry) > 0){
								//echo "user found";
								displayLoginPage();
							}else{
								//echo "no users!";
								$insertsql = "insert into admin (id,username,password)values(1,'admin','admin');";
								$insertqry = mysqli_query($conn, $insertsql);
								header('location: /index.php');
							}
						}else{
							//echo "table does not exists";
							$createtbl = "create table admin (id int, username varchar(255) not null, password varchar(255) not null, primary key(id));";
							$createqry = mysqli_query($conn, $createtbl);
							header('location: /index.php');
						}
				}else{
					   $sql = "CREATE Database admindb";
					   $retval = mysqli_query($conn,$sql);
					   if(!$retval){
					   	//echo "Could not create database!";
					   }else{
					   	//echo "Database created successfully!";
					   	header('location: /index.php');
					   }
				}


			mysqli_close($conn);
		}
	}

	

//functionsssssssssss

function displayLoginPage(){
	?>
		<form action="" method="POST">
			<input type="text" name="uName" placeholder="Username">
			<input type="password" name="passwd" placeholder="Password">
			<input type="submit" name="sub" value="Login">
		</form>
	<?php
			if(isset($_POST['sub'])){
				$conn = mysqli_connect("localhost","root","","admindb");
				$usrN = $_POST['uName'];
				$pass = $_POST['passwd'];

				$selectusr = "select * from admin where username='$usrN' and password='$pass'";
				$selectusrqry = mysqli_query($conn,$selectusr);

				if(MYSQLI_NUM_ROWS($selectusrqry) > 0){
					$_SESSION['userN'] = "admin";
					header('location: /index.php');
					//echo "clicked!";
				}else{
					echo "Walang dito hinahanap mo! <br> pokinanginang nanggigigil ako sayo!!! <br> Try mo: username: admin password: admin";
				}
				mysqli_close($conn);
			}
}



function displaysessionDestroy(){
	?>
		<form action="" method="POST">
			<input type="submit" name="destroy" value="Logout">
		</form>
	<?php
			if(isset($_POST['destroy'])){
			session_destroy();	
			header('location: /index.php');
			}
}

?>
