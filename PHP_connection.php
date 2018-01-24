<?php

    $host = "localhost";
    $db_name = "waterquality";
    $username = "root";
    $password = "";
    $conn = null;

    try
	{
      $conn = new PDO("mysql:host=" . $host . ";dbname=" . $db_name, $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
		catch(PDOException $exception)
		{
            echo "Connection error: " . $exception->getMessage();
        }

	$stmt = $conn->prepare("SELECT * FROM location");
	$stmt->execute();

	$result = array();

	for($i=0;$i<$stmt->rowCount();$i++)
	{
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		array_push($result,
			array('idlocation'=>$row['idlocation'], 'location1'=>$row['location1'], 'location2'=>$row['location2'], 'location3'=>$row['location3']
		));
	}
	echo json_encode(array("result"=>$result));

?>
	
	
