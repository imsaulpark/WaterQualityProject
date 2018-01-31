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

	$stmt = $conn->prepare("SELECT * FROM datapoint");
	$stmt->execute();

	$result = array();

	for($i=0;$i<$stmt->rowCount();$i++)
	{
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		array_push($result,
			array('iddatapoint'=>$row['iddatapoint'], 'timestamp'=>$row['timestamp'], 'value'=>$row['value'], 'flag'=>$row['flag'],'idstation'=>$row['idstation'],'idcriteria'=>$row['idcriteria']
		));
	}
	echo json_encode(array("result"=>$result));

?>
