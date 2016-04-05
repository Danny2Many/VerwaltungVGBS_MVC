<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;




/**
 * @ORM\Entity
 * @ORM\Table(name="Indices")
 */
class Indices {
   /** 
    * @ORM\Id
    * @ORM\Column(type="string") 
    */
   protected $tablename;
   /** 
    * @ORM\Column(type="integer") 
    */
   protected $index;
    
   



    /**
     * Set tablename
     *
     * @param string $tablename
     *
     * @return Indices
     */
    public function setTablename($tablename)
    {
        $this->tablename = $tablename;

        return $this;
    }

    /**
     * Get tablename
     *
     * @return string
     */
    public function getTablename()
    {
        return $this->tablename;
    }

    /**
     * Set index
     *
     * @param integer $index
     *
     * @return Indices
     */
    public function setIndex($index)
    {
        $this->index = $index;

        return $this;
    }

    /**
     * Get index
     *
     * @return integer
     */
    public function getIndex()
    {
        return $this->index;
    }
}
