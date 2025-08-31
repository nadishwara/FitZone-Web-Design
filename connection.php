<head> <title> Selecting MySQL Database </title> </head> <body>
<?php $dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';

$conn = mysqli_connect($dbhost,$dbuser,$dbpass); 

if(!$conn){
	die('Could not connect: ' .mysqli_connect_error($conn));}
	echo 'Connected successfully';
	
	echo '<br>'; //selecting database
	$db = mysqli_select_db($conn,'fitZone');
	
	if(!$db){
		echo 'Select Database First';
		} else {
		echo 'Database is selected';
    }
		//mysqli_close($conn);
	
?>
</body>
</html>