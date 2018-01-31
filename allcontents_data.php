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

        $stmt = $conn->prepare("SELECT *, station.desc as station_desc, criteria.desc as criteria_desc FROM location JOIN station ON location.idlocation = station.idlocation JOIN datapoint ON datapoint.idstation = station.idstation JOIN criteria ON criteria.idcriteria= datapoint.idcriteria ORDER BY location.idlocation");
        $stmt->execute();

	$result = array();

	for($i=0;$i<$stmt->rowCount();$i++)
	{
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		array_push($result,
			array('idlocation'=>$row['idlocation'], 'location1'=>$row['location1'], 'location2'=>$row['location2'], 'location3'=>$row['location3'],
        'location4'=>$row['location4'], 'idstation'=>$row['idstation'], 'station_desc'=>$row['station_desc'], 'iddatapoint'=>$row['iddatapoint'],
        'timestamp'=>$row['timestamp'], 'value'=>$row['value'], 'flag'=>$row['flag'], 'idcriteria'=>$row['idcriteria'], 'value1'=>$row['value1'],
        'value2'=>$row['value2'], 'criteria_desc'=>$row['criteria_desc'], 'unit'=>$row['unit']
		));
	}
	echo json_encode(array("result"=>$result));

?>
