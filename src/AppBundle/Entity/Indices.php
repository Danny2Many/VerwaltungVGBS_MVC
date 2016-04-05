<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Indices")
 */
class Indices{
    
    
    
   /**
     * @ORM\Id
     * @ORM\Column(type="string") 
     * 
     */
    protected $tablename;
    
    
    
   /** 
    * @ORM\Column(type="integer", name="Index") 
    */
    protected $index;
    
    
    
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
     * Get index
     *
     * @return integer
     */
    public function getIndex()
    {
        return $this->Index;
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
    
    
}
