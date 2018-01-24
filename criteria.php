<?php

require_once 'criteria_class.php';
$criteria = new Criteria();

if(isset($_POST['CriteriaAdd'])) {

  $criteria->add($_POST['idcriteria'],$_POST['value1'],$_POST['value2'],$_POST['description'],$_POST['unit']);
}


if(isset($_POST['CriteriaEdit'])) {

  $stmt = $criteria->getAll();
  for($i=0;$i<$stmt->rowCount();$i++)
  {
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    $row=array_values($row);
    $criteria->edit($row[0],$_POST['entity'.$row[0]][0],$_POST['entity'.$row[0]][1],$_POST['entity'.$row[0]][2],$_POST['entity'.$row[0]][3],$_POST['entity'.$row[0]][4]);
  }
}

if(isset($_POST['CriteriaDelete'])) {
  foreach($_POST['id'] as $id)
  {
    $criteria->delete($id);
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
        <li><a href="datapoint.php">Datapoint</a></li>
        <li><a class="active" href="criteria.php">Criteria</a></li>
      </ul>
      <form action="criteria.php" method="post" class="form-style">
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

              $stmt = $criteria->getAll();
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
