<?php 
	session_start();
	ob_start();
	require "config.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		Home - <?php echo $tagline  ?>
	</title>
	<link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>
	<div id="header">
		<h1 id="logo">Logo</h1>
		<nav>
			<ul id="menu">
				<li><a href="index.php">Home</a></li>
				<li><a href="products.php">Products</a></li>
				<li><a href="contact.php">Contact</a></li>
			</ul>
		</nav>
</div>