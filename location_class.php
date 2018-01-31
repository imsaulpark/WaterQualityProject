<?php
  require_once('dbconfig.php');
  require_once('waterquality.php');

  class Location extends WaterQuality
  {
    //하나의 entity 삽입
    public function add($idlocation,$location1,$location2,$location3,$location4)
  	{
      try
      {
        if(!$this->whetherExist($idlocation))
        {
          $stmt = $this->db->prepare("ALTER TABLE location AUTO_INCREMENT = 1");
          $stmt->execute();
          $stmt = $this->db->prepare("INSERT INTO location (idlocation,location1,location2,location3,location4) VALUES (:id,:loc1,:loc2,:loc3,:loc4)");
          $stmt->execute(array(':id'=>$idlocation,':loc1'=>$location1,':loc2'=>$location2,':loc3'=>$location3,':loc4'=>$location4));
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
    public function edit($prevId, $newId,$location1,$location2,$location3,$location4)
  	{

      try
      {
        if(!$this->whetherExist($newId) || $prevId==$newId)
        {
          $stmt = $this->db->prepare("UPDATE location SET idlocation=:idlocation, location1=:location1, location2=:location2, location3=:location3, location4=:location4 WHERE idlocation=:prevId");
          $stmt->bindparam(":prevId",$prevId);
          $stmt->bindparam(":idlocation",$newId);
          $stmt->bindparam(":location1",$location1);
          $stmt->bindparam(":location2",$location2);
          $stmt->bindparam(":location3",$location3);
          $stmt->bindparam(":location4",$location4);
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
  }

 ?>
