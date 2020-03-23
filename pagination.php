<?php

if(!$conn = mysqli_connect('localhost','root','','testdb')){
	echo mysqli_errno();
}else{
	
echo '<a href="?page=1">Products</a>';

if(isset($_GET['page'])){	
			echo '<br>';
			echo '<br>';
			$var = $_GET['page']-1;
			$var2 = $var*5;
			
			$sql='select * from testtbl order by id asc limit '.$var2.',5';
			$sql2='select * from testtbl';
			
			$res2=$conn->query($sql2);
			$res=$conn->query($sql);
			$divided = mysqli_num_rows($res2)/5;
			echo '<br>';
			while ($row=mysqli_fetch_array($res)) {
				echo '<br><a href="/?id='.$row[0].'">'.$row[1].'</a>';
			}

			echo '<br>';
			echo '<br>';

			$a = 0 + $_GET['page'];
			$b = 2 + $_GET['page'];


				if ($b >= ceil($divided)) {
					$c = $b - ceil($divided);
					$d = $b - $c;
						if($_GET['page']>1){
							$prev = $_GET['page'] - 1;
							echo '<a href="/?page='.$prev.'">'.'Prev '.'</a>';
						}
					for ($i=$a; $i <= $d; $i++) { 
						if($_GET['page'] <= ceil($divided)){
						echo '<a href="/?page='.$i.'">'.$i.'   '.'</a>';
						}	
				}
				
				}else{
					if($_GET['page']>1){
							$prev2 = $_GET['page'] - 1;
							echo '<a href="/?page='.$prev2.'">'.'Prev '.'</a>';
						}
					for ($i=$a; $i <= $b ; $i++) { 
						if($_GET['page'] <= ceil($divided)){
						echo '<a href="/?page='.$i.'">'.$i.'   '.'</a>';
						}
					}
						if($_GET['page']<ceil($divided)){
							$next = $_GET['page'] + 1;
							echo '<a href="/?page='.$next.'">'.' Next'.'</a>';
						}

				}


}elseif(isset($_GET['id'])) {
			$sql3="select * from testtbl where id=$_GET[id]";
			$res3=$conn->query($sql3);
				while ($row1=mysqli_fetch_array($res3)) {
					echo '<br><br>'.$row1[1];
				}
			}
}

?>
