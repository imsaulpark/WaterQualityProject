<?php

  require_once 'WaterQuality.php';
  $waterquality = new WaterQuality("");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>K water Manger</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="overall.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style>
  th { text-align: center;}
  ul { margin-bottom: 0;}
  img{ width:250px; margin-top:-10px;}
</style>
<body>
<br>
<div class="container" style="text-align: center;width:100%;padding:0">
  <a  href="allcontents.php"><img class="kwater" src="kwater.png" alt="kwater"></a>
  <br>
  <div>
<ul>
  <li><a href="location.php">Location</a></li>
  <li><a href="station.php">Station</a></li>
  <li><a href="datapoint.php">Datapoint</a></li>
  <li><a href="criteria.php">Criteria</a></li>
  <li><a class="active" href="allcontents.php">All Contents</a></li>
</ul>
<form action="location.php" method="post" class="form-style">
  <h2 class="h2-style">ALL CONTENTS</h2>
  <fieldset>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>idlocation</th>
          <th>location1</th>
          <th>location2</th>
          <th>location3</th>
          <th>location4</th>
          <th>idstation</th>
          <th>station desc</th>
          <th>iddatapoint</th>
          <th style="width:11%">timestamp</th>
          <th>value</th>
          <th>flag</th>
          <th>idcriteria</th>
          <th>value1</th>
          <th>value2</th>
          <th>criteria desc</th>
          <th>unit</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $stmt = $waterquality->joinAll();
        $stmt->execute();

        for($i=0;$i<$stmt->rowCount();$i++)
        {
          $row=$stmt->fetch(PDO::FETCH_ASSOC);
          $row=array_values($row);
          echo "<tr>";
          echo "<td><input class='edit' type='text' maxlength='11' name='entity".$row[0]."[]' value=$row[0]></td>";
          echo "<td><input class='edit' type='text' maxlength='45' name='entity".$row[0]."[]' value='$row[1]'></td>";
          echo "<td><input class='edit' type='text' maxlength='45' name='entity".$row[0]."[]' value='$row[2]'></td>";
          echo "<td><input class='edit' type='text' maxlength='45' name='entity".$row[0]."[]' value='$row[3]'></td>";
          echo "<td><input class='edit' type='text' maxlength='45' name='entity".$row[0]."[]' value='$row[4]'></td>";
          echo "<td><input class='edit' type='text' maxlength='11' name='entity".$row[0]."[]' value=$row[5]></td>";
          echo "<td><input class='edit' type='text' maxlength='45' name='entity".$row[0]."[]' value='$row[15]'></td>";
          echo "<td><input class='edit' type='text' maxlength='45' name='entity".$row[0]."[]' value='$row[7]'></td>";
          echo "<td><input class='edit' type='text' maxlength='45' name='entity".$row[0]."[]' value = ".date("Y-m-d-H:i", strtotime($row[8]))."></td>";
          echo "<td><input class='edit' type='text' maxlength='45' name='entity".$row[0]."[]' value='$row[9]'></td>";
          echo "<td><input class='edit' type='text' maxlength='45' name='entity".$row[0]."[]' value='$row[10]'></td>";
          echo "<td><input class='edit' type='text' maxlength='45' name='entity".$row[0]."[]' value='$row[11]'></td>";
          echo "<td><input class='edit' type='text' maxlength='45' name='entity".$row[0]."[]' value='$row[12]'></td>";
          echo "<td><input class='edit' type='text' maxlength='45' name='entity".$row[0]."[]' value='$row[13]'></td>";
          echo "<td><input class='edit' type='text' maxlength='45' name='entity".$row[0]."[]' value='$row[6]'></td>";
          echo "<td><input class='edit' type='text' maxlength='45' name='entity".$row[0]."[]' value='$row[14]'></td>";
          echo "</tr>";
        }
          ?>
      </tbody>
    </table>
  </fieldset>
</form>
 </div>
</div>

</body>
</html>
