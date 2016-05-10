<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

/**
 * @ORM\Entity
 * @ORM\Table(name="Member_Sportsgroup")
 * 
 */
class Member_Sportsgroup {
    
    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $sgid;
    
    /**
     * @ORM\Column(type="integer")
     * 
     */
    protected $memid;
    
    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $validfrom;
    
    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $validto;
    
    
    function getSgid() {
        return $this->sgid;
    }

    function getMemid() {
        return $this->memid;
    }

    function getValidfrom() {
        return $this->validfrom;
    }

    function getValidto() {
        return $this->validto;
    }

    function setSgid($sgid) {
        $this->sgid = $sgid;
        return $this;
    }

    function setMemid($memid) {
        $this->memid = $memid;
        return $this;
    }

    function setValidfrom($validfrom) {
        $this->validfrom = $validfrom;
        return $this;
    }

    function setValidto($validto) {
        $this->validto = $validto;
        return $this;
    }


}
