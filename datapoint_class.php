<?php
  require_once('dbconfig.php');

  class Datapoint
  {
    private $db;

    //생성자로 db연동
    public function __construct()
    {
      $database = new Database();
      $conn = $database->dbConnection();
      $this->db = $conn;
    }

    //sql 부르는 함수
    public function runQuery($sql)
    {
      $stmt = $this->db->prepare($sql);
      return $stmt;
    }

    //모든 entity 불러오기
    public function getAll()
    {
      try
      {
        $stmt = $this->db->prepare("SELECT * FROM datapoint");
        $stmt->execute();
        return $stmt;
      }
      catch(PDOException $e)
      {
        echo $e->getMessage();
      }
    }

    //해당 ID의 entity가 존재하는지
    public function whetherExist($id)
    {
        try
        {
          $stmt = $this->db->prepare("SELECT * FROM datapoint WHERE iddatapoint=:id");
          $stmt->bindparam(":id",$id);
          $stmt->execute();

          if($stmt->rowCount()==0)
            return false;
          else
            return true;
        }
        catch(PDOException $e)
        {
          echo $e->getMessage();
        }
    }

    //해당 idstation이 존재하는지
    public function stationExist($id)
    {
      try
      {
        $stmt = $this->db->prepare("SELECT * FROM station WHERE idstation=:id");
        $stmt->bindparam(":id",$id);
        $stmt->execute();

        if($stmt->rowCount()==0)
          return false;
        else
          return true;
      }
      catch(PDOException $e)
      {
        echo $e->getMessage();
      }
    }

    //해당 idcriteria 존재하는지
    public function criteriaExist($id)
    {
      try
      {
        $stmt = $this->db->prepare("SELECT * FROM criteria WHERE idcriteria=:id");
        $stmt->bindparam(":id",$id);
        $stmt->execute();

        if($stmt->rowCount()==0)
          return false;
        else
          return true;
      }
      catch(PDOException $e)
      {
        echo $e->getMessage();
      }
    }

    //하나의 entity 삽입
    public function add($id,$timestamp,$value,$flag,$idstation,$idcriteria)
    {
      try
      {
        if(!$this->whetherExist($id) && $this->stationExist($idstation) && $this->criteriaExist($idcriteria))
        {
          $stmt = $this->db->prepare("ALTER TABLE datapoint AUTO_INCREMENT = 1");
          $stmt->execute();
          $stmt = $this->db->prepare("INSERT INTO datapoint VALUES (:id,:timestamp,:value,:flag,:idstation,:idcriteria)");
          $stmt->execute(array(':id'=>$id,':timestamp'=>$timestamp,':value'=>$value,':flag'=>$flag,':idstation'=>$idstation,':idcriteria'=>$idcriteria));
        }
        else {
          echo "<script>alert('중복된 iddatapoint가 존재하거나 해당 idstation 또는 idcriteria가 존재하지 않습니다.');</script>";
        }
      }
      catch(PDOException $e)
      {
        echo $e->getMessage();
      }
    }

    //지정한 entity의 내용 수정
    public function edit($prevId, $newId,$timestamp,$value,$flag,$idstation,$idcriteria)
    {
      try
      {
        if((!$this->whetherExist($newId) || $prevId==$newId) && $this->stationExist($idstation) && $this->criteriaExist($idcriteria))
        {
          $stmt = $this->db->prepare("UPDATE datapoint SET iddatapoint=:iddatapoint, `timestamp`=:timestamp, value=:value, flag=b'".$flag."', idstation=:idstation, idcriteria=:idcriteria WHERE iddatapoint=:prevId");
          $stmt->bindparam(":iddatapoint",$newId);
          $stmt->bindparam(":prevId",$prevId);
          $stmt->bindparam(":timestamp",$timestamp);
          $stmt->bindparam(":value",$value);
          $stmt->bindparam(":idstation",$idstation);
          $stmt->bindparam(":idcriteria",$idcriteria);
          $stmt->execute();
        }
        else {
          echo "<script>alert('중복된 iddatapoint가 존재하거나 해당 idstation 또는 idcriteria가 존재하지 않습니다.');</script>";
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
