<?php
	$val = array("msg"=>"Hello World !");
	echo $_GET['callback'].'('.json_encode($val).')';
?>