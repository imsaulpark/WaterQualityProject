<?php

  require_once 'location_class.php';
  $location = new Location();

    if(isset($_POST['LocationAdd'])) {

      $location->add($_POST['idlocation'],$_POST['location1'],$_POST['location2'],$_POST['location3']);
    }

    if(isset($_POST['LocationEdit'])) {

      $stmt = $location->getAll();
      for($i=0;$i<$stmt->rowCount();$i++)
      {
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        $row=array_values($row);
        $location->edit($row[0],$_POST['entity'.$row[0]][0],$_POST['entity'.$row[0]][1],$_POST['entity'.$row[0]][2],$_POST['entity'.$row[0]][3]);
      }
    }

    if(isset($_POST['LocationDelete'])) {
      foreach($_POST['id'] as $id)
      {
        $location->delete($id);
      }
    }

    if(isset($_POST['StationDelete'])) {
      foreach($_POST['id'] as $id)
      {
        $stmt = $conn->prepare("DELETE FROM station WHERE idstation=$id");
        $stmt->execute();
      }
    }

    if(isset($_POST['StationEdit'])) {

      $stmt = $conn->prepare("SELECT * FROM station");
      $stmt->execute();

      for($i=0;$i<$stmt->rowCount();$i++)
      {
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        $row=array_values($row);

        $stmt2 = $conn->prepare("UPDATE station SET idstation=:idstation, `desc`=:description, idlocation=:idlocation WHERE idstation=$row[0]");
        $stmt2->bindparam(":idstation",$_POST['entity'.$row[0]][0]);
        $stmt2->bindparam(":description",$_POST['entity'.$row[0]][1]);
        $stmt2->bindparam(":idlocation",$_POST['entity'.$row[0]][2]);
        $stmt2->execute();
      }

    }

    if(isset($_POST['StationAdd'])) {

      $stmt = $conn->prepare("ALTER TABLE station AUTO_INCREMENT = 1");
      $stmt->execute();

      $stmt = $conn->prepare("INSERT INTO station VALUES (:id,:desc,:idloc)");
      $stmt->execute(array(':id'=>$_POST['idstation'],':desc'=>$_POST['description'],':idloc'=>$_POST['idlocation']));
    }

    if(isset($_POST['DatapointDelete'])) {
      foreach($_POST['id'] as $id)
      {
        $stmt = $conn->prepare("DELETE FROM datapoint WHERE iddatapoint=$id");
        $stmt->execute();
      }
    }

    if(isset($_POST['DatapointEdit'])) {

      $stmt = $conn->prepare("SELECT * FROM datapoint");
      $stmt->execute();

      for($i=0;$i<$stmt->rowCount();$i++)
      {
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        $row=array_values($row);
        $stmt2 = $conn->prepare("UPDATE datapoint SET iddatapoint=:iddatapoint, `timestamp`=:timestamp, value=:value, flag=b'".$_POST['entity'.$row[0]][3]."', idstation=:idstation, idcriteria=:idcriteria WHERE iddatapoint=$row[0]");
        $stmt2->bindparam(":iddatapoint",$_POST['entity'.$row[0]][0]);
        $stmt2->bindparam(":timestamp",$_POST['entity'.$row[0]][1]);
        $stmt2->bindparam(":value",$_POST['entity'.$row[0]][2]);
        $stmt2->bindparam(":idstation",$_POST['entity'.$row[0]][4]);
        $stmt2->bindparam(":idcriteria",$_POST['entity'.$row[0]][5]);
        $stmt2->execute();
      }

    }

    if(isset($_POST['DatapointAdd'])) {

      $stmt = $conn->prepare("ALTER TABLE datapoint AUTO_INCREMENT = 1");
      $stmt->execute();

      $stmt = $conn->prepare("INSERT INTO datapoint VALUES (:id,:timestamp,:value,:flag,:idstation,:idcriteria)");
      $stmt->execute(array(':id'=>$_POST['iddatapoint'],':timestamp'=>$_POST['timestamp'],':value'=>$_POST['value'],'flag'=>$_POST['flag'],'idstation'=>$_POST['idstation'],'idcriteria'=>$_POST['idcriteria']));
    }

    if(isset($_POST['CriteriaDelete'])) {
      foreach($_POST['id'] as $id)
      {
        $stmt = $conn->prepare("DELETE FROM criteria WHERE idcriteria=$id");
        $stmt->execute();
      }
    }

    if(isset($_POST['CriteriaEdit'])) {

      $stmt = $conn->prepare("SELECT * FROM criteria");
      $stmt->execute();

      for($i=0;$i<$stmt->rowCount();$i++)
      {
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        $row=array_values($row);

        $stmt2 = $conn->prepare("UPDATE criteria SET idcriteria=:idcriteria, value1=:value1, value2=:value2, `desc`=:desc, unit=:unit WHERE idcriteria=$row[0]");
        $stmt2->bindparam(":idcriteria",$_POST['entity'.$row[0]][0]);
        $stmt2->bindparam(":value1",$_POST['entity'.$row[0]][1]);
        $stmt2->bindparam(":value2",$_POST['entity'.$row[0]][2]);
        $stmt2->bindparam(":desc",$_POST['entity'.$row[0]][3]);
        $stmt2->bindparam(":unit",$_POST['entity'.$row[0]][4]);
        $stmt2->execute();
      }

    }

    if(isset($_POST['CriteriaAdd'])) {

      $stmt = $conn->prepare("ALTER TABLE criteria AUTO_INCREMENT = 1");
      $stmt->execute();

      $stmt = $conn->prepare("INSERT INTO criteria VALUES (:id,:value1,:value2,:desc,:unit)");
      $stmt->execute(array(':id'=>$_POST['idcriteria'],':value1'=>$_POST['value1'],':value2'=>$_POST['value2'],':desc'=>$_POST['description'],':unit'=>$_POST['unit']));
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>

    th
    {
       text-align: center;
    }

    .td_btn
    {
      background-color: white;
      border-top: 1px solid #ffffff !important;
    }

    .input
    {
      background: transparent;
      border: none;
      border-bottom: 1px dashed #83A4C5;
      outline: none;
      padding: 0px 0px 0px 0px;
      text-align : center;
      width:100px;
    }

    .edit
    {
      border:none;
      width:100px;
      border-top:0px;
      background-color: inherit;
      text-align: center;
    }

    .form-style{
        padding: 20px;
        padding-bottom: 0px;
        margin: 10px auto;
        margin-bottom: 50px;
        background: #F5F5F5;
        border-radius: 8px;
        margin-top : 0px;
    }

  .h2-style{
    background: #808080;
    text-transform: uppercase;
    font-family: 'Open Sans Condensed', sans-serif;
    color: #FFFFFF;
    font-size: 18px;
    font-weight: 100;
    margin: -20px;
    padding:15px;
    margin-bottom: 10px;
  }

    ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
    }

    li {
        float: left;
    }

    li a {
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

    li a:hover {
        background-color: #111;
    }

    .active {
    background-color: #4CAF50;
}

  </style>
</head>
<body>
<br>
<div class="container" style="text-align: center">
  <h2>Water Quality Management</h2>
  <p>This page is for water quality management.</p>
  <br>
  <div class="col-md-10 col-md-offset-1">
<ul>
  <li><a class="active" href="location.php">Location</a></li>
  <li><a href="station.php">Station</a></li>
  <li><a href="datapoint.php">Datapoint</a></li>
  <li><a href="criteria.php">Criteria</a></li>
</ul>
<form action="manager.php" method="post" class="form-style">
  <h2 class="h2-style">LOCATION</h2>
  <fieldset>
    <table class="table table-striped">
      <thead>
        <tr>
          <th></th>
          <th >idlocation</th>
          <th>location1</th>
          <th>location2</th>
          <th>location3</th>
        </tr>
      </thead>
      <tbody>
        <?php

        $stmt = $location->getAll();
        $stmt->execute();

        for($i=0;$i<$stmt->rowCount();$i++)
        {
          $row=$stmt->fetch(PDO::FETCH_ASSOC);
          $row=array_values($row);
          echo "<tr>";
          echo "<td><input type='checkbox' name='id[]' value=$row[0]></td>";
          echo "<td><input class='edit' type='number' max='99999999999' name='entity".$row[0]."[]' value=$row[0]></td>";
          echo "<td><input class='edit' type='text' maxlength='45' name='entity".$row[0]."[]' value=$row[1]></td>";
          echo "<td><input class='edit' type='text' maxlength='45' name='entity".$row[0]."[]' value=$row[2]></td>";
          echo "<td><input class='edit' type='text' maxlength='45' name='entity".$row[0]."[]' value=$row[3]></td>";
          echo "</tr>";
        }
          ?>

          <tr>
            <td></td>
            <td class=td_input>
              <input class='input'  max='99999999999' type='number' name='idlocation'>
            </td>
            <td class=td_input>
              <input class='input' maxlength='45' type='text' name='location1'>
            </td>
            <td class=td_input>
              <input class='input' maxlength='45' type='text' name='location2'>
            </td>
            <td class=td_input>
              <input class='input' maxlength='45' type='text' name='location3'>
            </td>
          </tr>

        <tr>
          <td colspan="5">
            <br>
            <input type="submit" class="btn btn-primary" name="LocationAdd" value="Add">
            <input type="submit" class="btn btn-warning" name="LocationEdit" value="Edit">
            <input type="submit" class="btn btn-danger" name="LocationDelete" value="Delete">
          </td>
        </tr>
      </tbody>
    </table>
  </fieldset>
</form>
<form action="manager.php" method="post"  class="form-style">
  <h2 class="h2-style">STATION</h2>
   <fieldset>
    <table class="table table-striped" >
    <thead>
      <tr>
        <th></th>
        <th>idstation</th>
        <th>description</th>
        <th>idlocation</th>
      </tr>
    </thead>
    <tbody>
      <?php

      $stmt = $conn->prepare("SELECT * FROM station");
      $stmt->execute();

      for($i=0;$i<$stmt->rowCount();$i++)
      {
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        $row=array_values($row);
        echo "<tr>";
        echo "<td><input type='checkbox' name='id[]' value=$row[0]></td>";
        echo "<td><input class='edit' max='99999999999' type='number' name='entity".$row[0]."[]' value=$row[0]></td>";
        echo "<td><input class='edit' maxlength='45' type='text' name='entity".$row[0]."[]' value=$row[1]></td>";
        echo "<td><input class='edit' max='99999999999' type='number' name='entity".$row[0]."[]' value=$row[2]></td>";
        echo "</tr>";
      }
      ?>
      <tr>
        <td></td>
        <td class=td_input>
          <input class='input' max='99999999999' type='number' name='idstation'>
        </td>
        <td class=td_input>
          <input class='input' maxlength='45' type='text' name='description'>
        </td>
        <td class=td_input>
          <input class='input' max='99999999999' type='number' name='idlocation'>
        </td>
      </tr>
      <tr>
        <td colspan="4">
          <br>
          <input type="submit" class="btn btn-primary" name="StationAdd" value="Add">
          <input type="submit" class="btn btn-warning" name="StationEdit" value="Edit">
          <input type="submit" class="btn btn-danger" name="StationDelete" value="Delete">
        </td>
      </tr>
    </tbody>
  </table>
 </fieldset>
</form>
  <form action="manager.php" method="post"  class="form-style">
    <h2 class="h2-style">DATA POINT</h2>
    <fieldset>
  <table class="table table-striped" >
    <thead>
      <tr>
        <th></th>
        <th>iddatapoint</th>
        <th>timestamp</th>
        <th>value</th>
        <th>flag</th>
        <th>idstation</th>
        <th>idcriteria</th>
      </tr>
    </thead>
    <tbody>
      <?php

      $stmt = $conn->prepare("SELECT * FROM datapoint");
      $stmt->execute();

      for($i=0;$i<$stmt->rowCount();$i++)
      {
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        $row=array_values($row);
        echo "<tr>";
        echo "<td><input type='checkbox' name='id[]' value=$row[0]></td>";
        echo "<td><input class='edit' type='number' max='99999999999' name='entity".$row[0]."[]' value=$row[0]></td>";
        echo "<td><input style='width:230px' class='edit' type='datetime-local' name='entity".$row[0]."[]' value = ".date("Y-m-d\TH:i:s", strtotime($row[1]))."></td>";
        echo "<td><input class='edit' type='number'  step='any' name='entity".$row[0]."[]' value=$row[2]></td>";
        echo "<td><input class='edit' type='number' name='entity".$row[0]."[]' value=$row[3]></td>";
        echo "<td><input class='edit' type='number' max='99999999999' name='entity".$row[0]."[]' value=$row[4]></td>";
        echo "<td><input class='edit' type='number' max='99999999999' name='entity".$row[0]."[]' value=$row[5]></td>";
        echo "</tr>";
      }
      ?>
      <tr>
        <td></td>
        <td class=td_input>
          <input class='input' type='number' max='99999999999' name='iddatapoint'>
        </td>
        <td class=td_input>
          <input style='width:230px' class='input' type='datetime-local' name='timestamp'>
        </td>
        <td class=td_input>
          <input class='input' type='number' step='any' name='value'>
        </td>
        <td class=td_input>
          <input class='input' type='number' name='flag'>
        </td>
      <td class=td_input>
        <input class='input' type='number' max='99999999999' name='idstation'>
      </td>
      <td class=td_input>
        <input class='input' type='number' max='99999999999' name='idcriteria'>
      </td>
      </tr>
      <tr>
        <td colspan="7">
          <br>
          <input type="submit" class="btn btn-primary" name="DatapointAdd" value="Add">
          <input type="submit" class="btn btn-warning" name="DatapointEdit" value="Edit">
          <input type="submit" class="btn btn-danger" name="DatapointDelete" value="Delete">
        </td>
      </tr>
    </tbody>
  </table>
</fieldset>
</form>
  <form action="manager.php" method="post" class="form-style">
   <h2 class="h2-style">CRITERIA</h2>
    <fieldset>
  <table class="table table-striped" >
    <thead>
      <tr>
        <th></th>
        <th>idcriteria</th>
        <th>value1</th>
        <th>value2</th>
        <th>description</th>
        <th>unit</th>
      </tr>
    </thead>
    <tbody>
      <?php

      $stmt = $conn->prepare("SELECT * FROM criteria");
      $stmt->execute();

      for($i=0;$i<$stmt->rowCount();$i++)
      {
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        $row=array_values($row);
        echo "<tr>";
        echo "<td><input type='checkbox' name='id[]' value=$row[0]></td>";
        echo "<td><input class='edit' type='number' max='99999999999' name='entity".$row[0]."[]' value=$row[0]></td>";
        echo "<td><input class='edit' type='number' step='any' name='entity".$row[0]."[]' value=$row[1]></td>";
        echo "<td><input class='edit' type='number' step='any' name='entity".$row[0]."[]' value=$row[2]></td>";
        echo "<td><input class='edit' type='text' maxlength='45' name='entity".$row[0]."[]' value=$row[3]></td>";
        echo "<td><input class='edit' type='text' maxlength='10' name='entity".$row[0]."[]' value=$row[4]></td>";
        echo "</tr>";
      }
      ?>
      <tr>
        <td></td>
        <td class=td_input>
          <input class='input' type='number' max='99999999999' name='idcriteria'>
        </td>
        <td class=td_input>
          <input class='input' type='number' step='any' name='value1'>
        </td>
        <td class=td_input>
          <input class='input' type='number' step='any' name='value2'>
        </td>
        <td class=td_input>
          <input class='input' type='text' maxlength='45' name='description'>
        </td>
        <td class=td_input>
          <input class='input' type='text' maxlength='10' name='unit'>
        </td>
      </tr>
      <tr>
        <td colspan="6">
          <br>
          <input type="submit" class="btn btn-primary" name="CriteriaAdd" value="Add">
          <input type="submit" class="btn btn-warning" name="CriteriaEdit" value="Edit">
          <input type="submit" class="btn btn-danger" name="CriteriaDelete" value="Delete">
        </td>
      </tr>
    </tbody>
  </table>
</fieldset>
</form>

 </div>
</div>

</body>
</html>
