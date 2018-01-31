      <?php

      require_once 'criteria_class.php';
      $criteria = new Criteria("criteria");

      if(isset($_POST['CriteriaAdd'])) {

        if($_POST['idcriteria']==null)
        {
          echo "<!DOCTYPE html>";
          echo "<script>alert('idcriteria 입력하세요.');</script>";
        }
        else if($criteria->add($_POST['idcriteria'],$_POST['value1'],$_POST['value2'],$_POST['description'],$_POST['unit'])==false)
        {
          echo "<!DOCTYPE html>";
          echo "<script>alert('중복된 idcriteria가 존재합니다.');</script>";
        }
      }


      if(isset($_POST['CriteriaEdit'])) {

        $stmt = $criteria->getAll();
        $flag=0;
        try{
          $criteria->transactionStart();
          for($i=0;$i<$stmt->rowCount();$i++)
          {
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $row=array_values($row);
            error_log($_POST['entity'.$row[0]][3]);
            if($_POST['entity'.$row[0]][0]==null)
            {
              echo "<!DOCTYPE html>";
              echo "<script>alert('idcriteria 입력하세요.');</script>";
              $criteria->transactionFail();
              $flag=1;
              break;
            }
            else if($criteria->edit($row[0],$_POST['entity'.$row[0]][0],$_POST['entity'.$row[0]][1],$_POST['entity'.$row[0]][2],$_POST['entity'.$row[0]][3],$_POST['entity'.$row[0]][4])==false)
            {
              echo "<!DOCTYPE html>";
              echo "<script>alert('중복된 idcriteria가 존재합니다.');</script>";
              $criteria->transactionFail();
              $flag=1;
              break;
            }
          }
          if($flag==0)
            $criteria->transactionSuccess();
        }
        catch (Exception $e) {
          $criteria->transactionFail();
          echo "Failed: " . $e->getMessage();
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
        <title>K water Manger</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="overall.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style>
          th { text-align: center;}
          ul { margin-bottom: 0;}
          img{ width:250px; margin-top:-10px;}
        </style>
      </head>
        <body>
        <br>
        <div class="container" style="text-align: center">
        <a  href="criteria.php"><img class="kwater" src="kwater.png" alt="kwater"></a>
        <br>
          <div class="col-md-10 col-md-offset-1">
            <ul>
              <li><a href="location.php">Location</a></li>
              <li><a href="station.php">Station</a></li>
              <li><a href="datapoint.php">Datapoint</a></li>
              <li><a class="active" href="criteria.php">Criteria</a></li>
              <li><a href="allcontents.php">All Contents</a></li>
            </ul>
            <form action="criteria.php" method="post" class="form-style">
              <h2 class="h2-style">CRITERIA</h2>
              <fieldset>
                <table class="table table-striped" >
                  <thead>
                    <tr>
                      <th style="width:5%"></th>
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
                      echo "<td><input class='edit' type='text' maxlength='11' name='entity".$row[0]."[]' value=$row[0]></td>";
                      echo "<td><input class='edit' type='number' step='any' name='entity".$row[0]."[]' value=$row[1]></td>";
                      echo "<td><input class='edit' type='number' step='any' name='entity".$row[0]."[]' value=$row[2]></td>";
                      echo "<td><input class='edit' type='text' maxlength='45' name='entity".$row[0]."[]' value='$row[3]'></td>";
                      echo "<td><input class='edit' type='text' maxlength='10' name='entity".$row[0]."[]' value='$row[4]'></td>";
                      echo "</tr>";
                    }
                    ?>
                    <tr>
                      <td></td>
                      <td class=td_input>
                        <input class='input'  maxlength='11' type='text' name='idcriteria'>
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
                        <input type="submit" class="btn btn-primary" name="CriteriaAdd" value="추가">
                        <input type="submit" class="btn btn-warning" name="CriteriaEdit" value="수정">
                        <input type="submit" class="btn btn-danger" name="CriteriaDelete" value="삭제">
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
