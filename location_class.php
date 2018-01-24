<?php
  require_once('dbconfig.php');

  class Location
  {
    private $db;

    //생성자로 db연동
    public function __construct()
    {
      $database = new Database();
      $conn = $database->dbConnection();
      $this->db = $conn;
    }

    public function nothing(){echo "GG";}

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
        $stmt = $this->db->prepare("SELECT * FROM location");
        $stmt->execute();
        return $stmt;
      }
      catch(PDOException $e)
      {
        echo $e->getMessage();
      }
    }

    //해당 ID의 entity가 존재하는지
    public function whetherExist($idlocation)
    {
        try
        {
          $stmt = $this->db->prepare("SELECT * FROM location WHERE idlocation=:idlocation");
          $stmt->bindparam(":idlocation",$idlocation);
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
    public function add($idlocation,$location1,$location2,$location3)
  	{
      try
      {
        if(!$this->whetherExist($idlocation))
        {
          $stmt = $this->db->prepare("ALTER TABLE location AUTO_INCREMENT = 1");
          $stmt->execute();
          $stmt = $this->db->prepare("INSERT INTO location (idlocation,location1,location2,location3) VALUES (:id,:loc1,:loc2,:loc3)");
          $stmt->execute(array(':id'=>$idlocation,':loc1'=>$location1,':loc2'=>$location2,':loc3'=>$location3));
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
    public function edit($prevId, $newId,$location1,$location2,$location3)
  	{

      try
      {
        if(!$this->whetherExist($newId) || $prevId==$newId)
        {
          $stmt = $this->db->prepare("UPDATE location SET idlocation=:idlocation, location1=:location1, location2=:location2, location3=:location3 WHERE idlocation=:prevId");
          $stmt->bindparam(":prevId",$prevId);
          $stmt->bindparam(":idlocation",$newId);
          $stmt->bindparam(":location1",$location1);
          $stmt->bindparam(":location2",$location2);
          $stmt->bindparam(":location3",$location3);
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
    public function delete($idlocation)
    {
      try
      {
        $stmt = $this->db->prepare("DELETE FROM location WHERE idlocation=:idlocation");
        $stmt->bindparam(":idlocation",$idlocation);
        $stmt->execute();
      }
      catch(PDOException $e)
      {
        echo $e->getMessage();
      }
    }

  }

 ?>
