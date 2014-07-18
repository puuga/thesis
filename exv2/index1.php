<h1>HTML message</h1>
hello html<br/>
<h1>PHP message</h1>
<?php
	echo "My first step on amazon web service<br>";
	echo "upload from ftps<br>";
?>
<br/><br/><br/>
<h1>MySQL connect</h1>
<?php

	//$con=mysqli_connect("ec2-46-51-221-77.ap-southeast-1.compute.amazonaws.com","root","1234567890","web_test");
	$con=mysqli_connect("127.0.0.1","root","1234567890","web_test");
	// Check connection
	
	if (mysqli_connect_errno($con)) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	} else {
		echo "Connection was OK!\n";
	}
	
	$sql = "SELECT * FROM new_table_1";
	$result = mysqli_query($con, $sql);
	
	echo "<table border='1'>
		<tr>
			<th>id</th>
			<th>name</th>
		</tr>";
		
	while($row = mysqli_fetch_array($result)) {
		echo "<tr>";
		echo "<td>" . $row['id'] . "</td>";
		echo "<td>" . $row['name'] . "</td>";
		echo "</tr>";
	}
	
	echo "</table>";

?>