<?php
  require_once('dbconfig.php');

  class WaterQuality
  {
    protected $db;
    protected $className;

    //생성자로 db연동
    public function __construct($className)
    {
      $database = new Database();
      $conn = $database->dbConnection();
      $this->db = $conn;
      $this->className=$className;
    }

    //sql 부르는 함수
	  public function runQuery($sql)
		{
			$stmt = $this->db->prepare($sql);
			return $stmt;
		}

    //transaction 시작
    public function transactionStart()
    {
        $this->db->beginTransaction();
    }

    //transcation 성공
    public function transactionSuccess()
    {
        $this->db->commit();
    }

    //transcation 실패
    public function transactionFail()
    {
        $this->db->rollBack();
    }

    //모든 entity 불러오기
    public function getAll()
    {
      try
      {
        $stmt = $this->db->prepare("SELECT * FROM $this->className");
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
          $stmt = $this->db->prepare("SELECT * FROM $this->className WHERE ".'id'.$this->className."=:id");
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


    //해당 ID의 entity 삭제
    public function delete($id)
    {
      try
      {
        $stmt = $this->db->prepare("DELETE FROM $this->className WHERE ".'id'.$this->className."=:id");
        $stmt->bindparam(":id",$id);
        $stmt->execute();
      }
      catch(PDOException $e)
      {
        echo $e->getMessage();
      }
    }

    //해당 idlocation이 존재하는지
    public function particularExist($id,$particular)
    {
      try
      {
        $stmt = $this->db->prepare("SELECT * FROM $particular WHERE ".'id'.$particular."=:id");
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

  }

 ?>
