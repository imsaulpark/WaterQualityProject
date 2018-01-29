<?php
  require_once('dbconfig.php');
  require_once('waterquality.php');

  class Location extends WaterQuality
  {
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
