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
    
    
}
