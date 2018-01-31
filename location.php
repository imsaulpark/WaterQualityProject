<?php

  require_once 'location_class.php';
  $location = new Location("location");

    if(isset($_POST['LocationAdd'])) {

      if($_POST['idlocation']==null)
      {
        echo "<!DOCTYPE html>";
        echo "<script>alert('idlocation을 입력하세요.');</script>";
      }
      else if($location->add($_POST['idlocation'],$_POST['location1'],$_POST['location2'],$_POST['location3'],$_POST['location4'])==false)
      {
        echo "<!DOCTYPE html>";
        echo "<script>alert('중복된 idlocation이 존재합니다.');</script>";
      }

    }

    if(isset($_POST['LocationEdit'])) {

      $stmt = $location->getAll();
      $flag=0;
      try{
        $location->transactionStart();
        for($i=0;$i<$stmt->rowCount();$i++)
        {
          $row=$stmt->fetch(PDO::FETCH_ASSOC);
          $row=array_values($row);

          if($_POST['entity'.$row[0]][0]==null)
          {
            echo "<!DOCTYPE html>";
            echo "<script>alert('idlocation을 입력하세요.');</script>";
            $location->transactionFail();
            $flag=1;
            break;
          }
          else if($location->edit($row[0],$_POST['entity'.$row[0]][0],$_POST['entity'.$row[0]][1],$_POST['entity'.$row[0]][2],$_POST['entity'.$row[0]][3],$_POST['entity'.$row[0]][4])==false)
          {
            echo "<!DOCTYPE html>";
            echo "<script>alert('중복된 idlocation이 존재합니다.');</script>";
            $location->transactionFail();
            $flag=1;
            break;
          }
        }
        if($flag==0)
          $location->transactionSuccess();
      }
      catch (Exception $e) {
        $location->transactionFail();
        echo "Failed: " . $e->getMessage();
      }
    }

    if(isset($_POST['LocationDelete'])) {
      foreach($_POST['id'] as $id)
      {
        $location->delete($id);
      }
    }
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
<div class="container" style="text-align: center">
  <a  href="location.php"><img class="kwater" src="kwater.png" alt="kwater"></a>
  <br>
  <div class="col-md-10 col-md-offset-1">
<ul>
  <li><a class="active" href="location.php">Location</a></li>
  <li><a href="station.php">Station</a></li>
  <li><a href="datapoint.php">Datapoint</a></li>
  <li><a href="criteria.php">Criteria</a></li>
  <li><a href="allcontents.php">All Contents</a></li>
</ul>
<form action="location.php" method="post" class="form-style">
  <h2 class="h2-style">LOCATION</h2>
  <fieldset>
    <table class="table table-striped">
      <thead>
        <tr>
          <th style="width:5%"></th>
          <th>idlocation</th>
          <th>location1</th>
          <th>location2</th>
          <th>location3</th>
          <th>location4</th>
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
          echo "<td><input class='edit' type='text' maxlength='11' name='entity".$row[0]."[]' value=$row[0]></td>";
          echo "<td><input class='edit' type='text' maxlength='45' name='entity".$row[0]."[]' value='$row[1]'></td>";
          echo "<td><input class='edit' type='text' maxlength='45' name='entity".$row[0]."[]' value='$row[2]'></td>";
          echo "<td><input class='edit' type='text' maxlength='45' name='entity".$row[0]."[]' value='$row[3]'></td>";
          echo "<td><input class='edit' type='text' maxlength='45' name='entity".$row[0]."[]' value='$row[4]'></td>";
          echo "</tr>";
        }
          ?>

          <tr>
            <td></td>
            <td class=td_input>
              <input class='input' maxlength='11' type='text' name='idlocation'>
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
            <td class=td_input>
              <input class='input' maxlength='45' type='text' name='location4'>
            </td>
          </tr>

        <tr>
          <td colspan="6">
            <br>
            <input type="submit" class="btn btn-primary" name="LocationAdd" value="추가">
            <input type="submit" class="btn btn-warning" name="LocationEdit" value="수정">
            <input type="submit" class="btn btn-danger" name="LocationDelete" value="삭제">
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
