<?php

require_once 'datapoint_class.php';
$datapoint = new Datapoint();

if(isset($_POST['DatapointAdd'])) {

  $datapoint->add($_POST['iddatapoint'],$_POST['timestamp'],$_POST['value'],$_POST['flag'],$_POST['idstation'],$_POST['idcriteria']);
}


if(isset($_POST['DatapointEdit'])) {

  $stmt = $datapoint->getAll();
  for($i=0;$i<$stmt->rowCount();$i++)
  {
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    $row=array_values($row);
    $datapoint->edit($row[0],$_POST['entity'.$row[0]][0],$_POST['entity'.$row[0]][1],$_POST['entity'.$row[0]][2],$_POST['entity'.$row[0]][3],$_POST['entity'.$row[0]][4],$_POST['entity'.$row[0]][5]);
  }
}

if(isset($_POST['DatapointDelete'])) {
  foreach($_POST['id'] as $id)
  {
    $datapoint->delete($id);
  }
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
        <li><a href="location.php">Location</a></li>
        <li><a href="station.php">Station</a></li>
        <li><a class="active" href="datapoint.php">Datapoint</a></li>
        <li><a href="criteria.php">Criteria</a></li>
      </ul>

      <form action="datapoint.php" method="post"  class="form-style">
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

              $stmt = $datapoint->getAll();
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
    </div>
  </div>

</body>
</html>
