  <?php

  require_once 'station_class.php';
  $station = new Station("station");

  if(isset($_POST['StationAdd'])) {

    if($_POST['idstation']==null)
    {
      echo "<!DOCTYPE html>";
      echo "<script>alert('idstation 입력하세요.');</script>";
    }
    else if($station->add($_POST['idstation'],$_POST['description'],$_POST['idlocation'])==false)
    {
      echo "<!DOCTYPE html>";
      echo "<script>alert('중복된 idstation이 존재하거나 해당 idlocation이 존재하지 않습니다.');</script>";
    }
  }


  if(isset($_POST['StationEdit'])) {

    $stmt = $station->getAll();
    $flag=0;
    try{
      $station->transactionStart();
      for($i=0;$i<$stmt->rowCount();$i++)
      {
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        $row=array_values($row);
        if($_POST['entity'.$row[0]][0]==null)
        {
          echo "<!DOCTYPE html>";
          echo "<script>alert('idstation 입력하세요.');</script>";
          $station->transactionFail();
          $flag=1;
          break;
        }
        if($station->edit($row[0],$_POST['entity'.$row[0]][0],$_POST['entity'.$row[0]][1],$_POST['entity'.$row[0]][2])==false)
        {
          echo "<!DOCTYPE html>";
          echo "<script>alert('중복된 idstation이 존재하거나 해당 idlocation이 존재하지 않습니다.');</script>";
          $station->transactionFail();
          $flag=1;
          break;
        }
      }
      if($flag==0)
        $station->transactionSuccess();
    }
    catch (Exception $e) {
      $station->transactionFail();
      echo "Failed: " . $e->getMessage();
    }
  }

  if(isset($_POST['StationDelete'])) {
    foreach($_POST['id'] as $id)
    {
      $station->delete($id);
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
      <a  href="station.php"><img class="kwater" src="kwater.png" alt="kwater"></a>
      <br>
      <div class="col-md-10 col-md-offset-1">
        <ul>
          <li><a href="location.php">Location</a></li>
          <li><a class="active" href="station.php">Station</a></li>
          <li><a href="datapoint.php">Datapoint</a></li>
          <li><a href="criteria.php">Criteria</a></li>
          <li><a href="allcontents.php">All Contents</a></li>
        </ul>
        <form action="station.php" method="post"  class="form-style">
          <h2 class="h2-style">STATION</h2>
          <fieldset>
            <table class="table table-striped" >
              <thead>
                <tr>
                  <th style="width:5%"></th>
                  <th>idstation</th>
                  <th>description</th>
                  <th>idlocation</th>
                </tr>
              </thead>
              <tbody>
                <?php

                $stmt = $station->getAll();
                $stmt->execute();

                for($i=0;$i<$stmt->rowCount();$i++)
                {
                  $row=$stmt->fetch(PDO::FETCH_ASSOC);
                  $row=array_values($row);
                  echo "<tr>";
                  echo "<td><input type='checkbox' name='id[]' value=$row[0]></td>";
                  echo "<td><input class='edit' maxlength='11' type='text'name='entity".$row[0]."[]' value=$row[0]></td>";
                  echo "<td><input class='edit' style='width:100%'  maxlength='45' type='text' name='entity".$row[0]."[]' value='$row[1]'></td>";
                  echo "<td><input class='edit'maxlength='11' type='text' name='entity".$row[0]."[]' value=$row[2]></td>";
                  echo "</tr>";
                }
                ?>
                <tr>
                  <td></td>
                  <td class=td_input>
                    <input class='input' maxlength='11' type='text' name='idstation'>
                  </td>
                  <td class=td_input>
                    <input class='input' maxlength='45'  style='width:100%' type='text' name='description'>
                  </td>
                  <td class=td_input>
                    <input class='input' maxlength='11' type='text' name='idlocation'>
                  </td>
                </tr>
                <tr>
                  <td colspan="4">
                    <br>
                    <input type="submit" class="btn btn-primary" name="StationAdd" value="추가">
                    <input type="submit" class="btn btn-warning" name="StationEdit" value="수정">
                    <input type="submit" class="btn btn-danger" name="StationDelete" value="삭제">
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
