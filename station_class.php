<?php
  require_once('dbconfig.php');

  class Station
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
        $stmt = $this->db->prepare("SELECT * FROM station");
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
          $stmt = $this->db->prepare("SELECT * FROM station WHERE idlocation=:id");
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
    public function add($id,$)
  	{
      try
      {
        if(!$this->whetherExist($id,$desc,$idlocation))
        {
          $stmt = $this->db->prepare("ALTER TABLE station AUTO_INCREMENT = 1");
          $stmt->execute();
          $stmt = $this->db->prepare("INSERT INTO station VALUES (:id,:desc,:idloc)");
          $stmt->execute(array(':id'=>$id,':desc'=>$desc,':idloc'=>$idlocation));
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
    public function edit($prevId, $newId,$desc,$idlocation)
  	{
      try
      {
        if(!$this->whetherExist($newId) || $prevId==$newId)
        {
          $stmt = $this->db->prepare("UPDATE station SET idstation=:idstation, `desc`=:description, idlocation=:idlocation WHERE idstation=:prevId");
          $stmt->bindparam(":prevId",$prevId);
          $stmt->bindparam(":idstation",$newId);
          $stmt2->bindparam(":description",$desc);
          $stmt2->bindparam(":idlocation",$idlocation);
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
        $stmt = $this->db->prepare("DELETE FROM station WHERE idstation=:id");
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
