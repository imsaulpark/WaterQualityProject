<?php

require_once 'datapoint_class.php';
$datapoint = new Datapoint("datapoint");

if(isset($_POST['DatapointAdd'])) {

  if($_POST['timestamp']==null)
    $_POST['timestamp']=date('Y/m/d H:i:s');

  if($_POST['iddatapoint']==null)
  {
    echo "<!DOCTYPE html>";
    echo "<script>alert('iddatapoint를 입력하세요.');</script>";
  }
  else if($datapoint->add($_POST['iddatapoint'],$_POST['timestamp'],$_POST['value'],$_POST['idstation'],$_POST['idcriteria'])==false)
  {
    echo "<!DOCTYPE html>";
    echo "<script>alert('중복된 iddatapoint가 존재하거나 해당 idstation 또는 idcriteria가 존재하지 않습니다.');</script>";
  }
}


if(isset($_POST['DatapointEdit'])) {

  $stmt = $datapoint->getAll();
  $flag=0;
  try{
    $datapoint->transactionStart();
    for($i=0;$i<$stmt->rowCount();$i++)
    {
      $row=$stmt->fetch(PDO::FETCH_ASSOC);
      $row=array_values($row);
      if($_POST['entity'.$row[0]][0]==null)
      {
        echo "<!DOCTYPE html>";
        echo "<script>alert('iddatapoint를 입력하세요.');</script>";
        $datapoint->transactionFail();
        $flag=1;
        break;
      }
      else if($datapoint->edit($row[0],$_POST['entity'.$row[0]][0],$_POST['entity'.$row[0]][1],$_POST['entity'.$row[0]][2],$_POST['entity'.$row[0]][4],$_POST['entity'.$row[0]][5])==false)
      {
        echo "<!DOCTYPE html>";
        echo "<script>alert('중복된 iddatapoint가 존재하거나 해당 idstation 또는 idcriteria가 존재하지 않습니다.');</script>";
        $datapoint->transactionFail();
        $flag=1;
        break;
      }
    }
    if($flag==0)
      $datapoint->transactionSuccess();
  }
  catch (Exception $e) {
    $datapoint->transactionFail();
    echo "Failed: " . $e->getMessage();
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
  td.timestamp{width:200px}
</style>
<body>
  <br>
  <div class="container" style="text-align: center">
    <a  href="datapoint.php"><img class="kwater" src="kwater.png" alt="kwater"></a>
    <br>
    <div class="col-md-10 col-md-offset-1">
      <ul>
        <li><a href="location.php">Location</a></li>
        <li><a href="station.php">Station</a></li>
        <li><a class="active" href="datapoint.php">Datapoint</a></li>
        <li><a href="criteria.php">Criteria</a></li>
        <li><a href="allcontents.php">All Contents</a></li>
      </ul>

      <form action="datapoint.php" method="post"  class="form-style">
        <h2 class="h2-style">DATA POINT</h2>
        <fieldset>
          <table class="table table-striped" >
            <thead>
              <tr>
                <th style="width:5%"></th>
                <th>iddatapoint</th>
                <th style='width:30%'>timestamp</th>
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
                echo "<td><input class='edit' type='text' maxlength='11' name='entity".$row[0]."[]' value=$row[0]></td>";
                echo "<td><input class='edit' type='datetime-local' name='entity".$row[0]."[]' value = ".date("Y-m-d\TH:i", strtotime($row[1]))."></td>";
                echo "<td><input class='edit' type='number'  step='any' name='entity".$row[0]."[]' value=$row[2]></td>";
                echo "<td><input class='edit' type='number' READONLY name='entity".$row[0]."[]' value=$row[3]></td>";
                echo "<td><input class='edit' type='text' maxlength='11' name='entity".$row[0]."[]' value=$row[4]></td>";
                echo "<td><input class='edit' type='text' maxlength='11' name='entity".$row[0]."[]' value=$row[5]></td>";
                echo "</tr>";
              }
              ?>
              <tr>
                <td></td>
                <td class=td_input>
                  <input class='input' maxlength='11' type='text' name='iddatapoint'>
                </td>
                <td class=td_input>
                  <input class='input' style='width:100%' type='datetime-local' name='timestamp'>
                </td>
                <td class=td_input>
                  <input class='input' type='number' step='any' name='value'>
                </td>
                <td class=td_input>
                  <input class='input' type='number' name='flag' READONLY style="border-bottom:0px">
                </td>
                <td class=td_input>
                  <input class='input'  maxlength='11' type='text' name='idstation'>
                </td>
                <td class=td_input>
                  <input class='input'  maxlength='11' type='text' name='idcriteria'>
                </td>
              </tr>
              <tr>
                <td colspan="7">
                  <br>
                  <input type="submit" class="btn btn-primary" name="DatapointAdd" value="추가">
                  <input type="submit" class="btn btn-warning" name="DatapointEdit" value="수정">
                  <input type="submit" class="btn btn-danger" name="DatapointDelete" value="삭제">
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
