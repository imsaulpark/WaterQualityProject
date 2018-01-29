<?php
  require_once('dbconfig.php');
  require_once('waterquality.php');

  class Datapoint extends WaterQuality
  {

    public function calculateFlag($value,$idcriteria)
    {
      try
      {
        $stmt = $this->db->prepare("SELECT * FROM criteria WHERE idcriteria=:idcriteria");
        $stmt->bindparam(":idcriteria",$idcriteria);
        $stmt->execute();
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        if($row['value1']<=$value && $value <=$row['value2'] )
        {
          return true;
        }
        else
        {
            return false;
        }
      }
      catch(PDOException $e)
      {
        echo $e->getMessage();
      }
    }

    //하나의 entity 삽입
    public function add($id,$timestamp,$value,$idstation,$idcriteria)
    {
      try
      {
        if(!$this->whetherExist($id) && $this->particularExist($idstation,"station") && $this->particularExist($idcriteria,"criteria"))
        {
          $flag=$this->calculateFlag($value,$idcriteria);
          $stmt = $this->db->prepare("ALTER TABLE datapoint AUTO_INCREMENT = 1");
          $stmt->execute();
          $stmt = $this->db->prepare("INSERT INTO datapoint VALUES (:id,:timestamp,:value,:flag,:idstation,:idcriteria)");
          $stmt->execute(array(':id'=>$id,':timestamp'=>$timestamp,':value'=>$value,':flag'=>$flag,':idstation'=>$idstation,':idcriteria'=>$idcriteria));
          return true;
        }
        else {
          return false;
        }
      }
      catch(PDOException $e)
      {
        echo $e->getMessage();
      }
    }

    //지정한 entity의 내용 수정
    public function edit($prevId, $newId,$timestamp,$value,$idstation,$idcriteria)
    {
      try
      {
        if((!$this->whetherExist($newId) || $prevId==$newId) && $this->particularExist($idstation,"station") && $this->particularExist($idcriteria,"criteria"))
        {
          $stmt = $this->db->prepare("UPDATE datapoint SET iddatapoint=:iddatapoint, `timestamp`=:timestamp, value=:value, idstation=:idstation, idcriteria=:idcriteria WHERE iddatapoint=:prevId");
          $stmt->bindparam(":iddatapoint",$newId);
          $stmt->bindparam(":prevId",$prevId);
          $stmt->bindparam(":timestamp",$timestamp);
          $stmt->bindparam(":value",$value);
          $stmt->bindparam(":idstation",$idstation);
          $stmt->bindparam(":idcriteria",$idcriteria);
          $stmt->execute();
          return true;
        }
        else {
          return false;
        }
      }
      catch(PDOException $e)
      {
        echo $e->getMessage();
      }
    }

    //해당 ID의 entity 삭제
    public function delete($id)
    {
      try
      {
        $stmt = $this->db->prepare("DELETE FROM datapoint WHERE iddatapoint=:id");
        $stmt->bindparam(":id",$id);
        $stmt->execute();
      }
      catch(PDOException $e)
      {
        echo $e->getMessage();
      }
    }

  }

 ?>
