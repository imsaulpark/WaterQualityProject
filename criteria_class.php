<?php
  require_once('dbconfig.php');

  class Criteria
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
        $stmt = $this->db->prepare("SELECT * FROM criteria");
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
    public function add($id,$value1,$value2,$description,$unit)
    {
      try
      {
        if(!$this->whetherExist($id))
        {
          $stmt = $this->db->prepare("ALTER TABLE criteria AUTO_INCREMENT = 1");
          $stmt->execute();
          $stmt = $this->db->prepare("INSERT INTO criteria VALUES (:id,:value1,:value2,:desc,:unit)");
          $stmt->execute(array(':id'=>$id,':value1'=>$value1,':value2'=>$value2,':desc'=>$description,':unit'=>$unit));
        }
        else {
          echo "<script>alert('중복된 ID가 존재합니다.');</script>";
        }
      }
      catch(PDOException $e)
      {
        echo $e->getMessage();
      }
    }

    //지정한 entity의 내용 수정
    public function edit($prevId, $newId,$value1,$value2,$description,$unit)
    {
      try
      {
        if(!$this->whetherExist($newId) || $prevId==$newId)
        {
          $stmt = $this->db->prepare("UPDATE criteria SET idcriteria=:idcriteria, value1=:value1, value2=:value2, `desc`=:desc, unit=:unit WHERE idcriteria=:prevId");
          $stmt->bindparam(":idcriteria",$newId);
          $stmt->bindparam(":prevId",$prevId);
          $stmt->bindparam(":value1",$value1);
          $stmt->bindparam(":value2",$value2);
          $stmt->bindparam(":desc",$description);
          $stmt->bindparam(":unit",$unit);
          $stmt->execute();

        }
        else {
          echo "<script>alert('중복된 ID가 존재합니다.');</script>";
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
        $stmt = $this->db->prepare("DELETE FROM criteria WHERE idcriteria=:id");
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
