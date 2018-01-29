<?php
  require_once('dbconfig.php');
  require_once('waterquality.php');

  class Criteria extends WaterQuality
  {

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
