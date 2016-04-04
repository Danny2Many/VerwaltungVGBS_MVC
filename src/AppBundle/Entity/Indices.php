<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;




/**
 * @ORM\Entity
 * @ORM\Table(name="Indices")
 */
class Indices {
   /* 
    * @ORM\Id
    * @ORM\Column(type="string") 
    */
   protected $tablename;
   /* 
    * @ORM\Column(type="integer") 
    */
   protected $index;
    
   function getTablename() {
       return $this->tablename;
   }

   function getIndex() {
       return $this->index;
   }

   function setTablename($tablename) {
       $this->tablename = $tablename;
   }

   function setIndex($index) {
       $this->index = $index;
   }


}
