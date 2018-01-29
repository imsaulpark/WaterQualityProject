  <?php
    require_once('dbconfig.php');
    require_once('waterquality.php');

    class Station extends WaterQuality
    {

      //하나의 entity 삽입
      public function add($id,$desc,$idlocation)
    	{
        try
        {
          if(!$this->whetherExist($id) && $this->particularExist($idlocation,"location"))
          {
            $stmt = $this->db->prepare("ALTER TABLE station AUTO_INCREMENT = 1");
            $stmt->execute();
            $stmt = $this->db->prepare("INSERT INTO station VALUES (:id,:description,:idloc)");
            $stmt->execute(array(':id'=>$id,':description'=>$desc,':idloc'=>$idlocation));
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
      public function edit($prevId, $newId,$desc,$idlocation)
    	{
        try
        {
          if((!$this->whetherExist($newId) || $prevId==$newId) &&$this->particularExist($idlocation,"location"))
          {
            $stmt = $this->db->prepare("UPDATE station SET idstation=:idstation, `desc`=:description, idlocation=:idlocation WHERE idstation=:prevId");
            $stmt->bindparam(":prevId",$prevId);
            $stmt->bindparam(":idstation",$newId);
            $stmt->bindparam(":description",$desc);
            $stmt->bindparam(":idlocation",$idlocation);
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
