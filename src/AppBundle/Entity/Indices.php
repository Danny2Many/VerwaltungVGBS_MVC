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
    * @ORM\Column(type="integer", name="CurrentIndex") 
    */
    protected $currentindex;
    

    

    
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
     * Get currentindex
     *
     * @return integer
     */
    public function getCurrentindex()
    {
        return $this->currentindex;

    }
   

    /**
     * Set currentindex
     *
     * @param integer $currentindex
     *
     * @return Indices
     */
    public function setIndex($currentindex)
    {
        $this->currentindex = $currentindex;

        return $this;
    }
}
