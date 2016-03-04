<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\HealthData;


class Nonmember extends HealthData {

protected $NMenID;    
    
/**
* @ORM\OneToMany(targetEntity="TrainingStartDate", mappedBy="nonmember", cascade={"all"})
*/  
protected $TrainingDate;

/**
* @ORM\OneToMany(targetEntity="TrainingConfirmation", mappedBy="nonmember", cascade={"all"})
*/  
protected $TrainingConfirmation;

/**
* @ORM\OneToMany(targetEntity="Settlement1", mappedBy="nonmember", cascade={"all"})
*/  
protected $Settlement1;

/**
* @ORM\OneToMany(targetEntity="Settlement2", mappedBy="nonmember", cascade={"all"})
*/  
protected $Settlement2;
 
public function setTrainingStartDate($trainingstartsate)
{
    $this->trainingadmissiondate = $admissiondate;
    return $this;
}

public function getTrainingStartDate()
    {
        return $this->trainingstartdate;
    }

    
public function setTrainingConfirmation($trainingconfirmation)
{
    $this->trainingconfirmation = $trainingconfirmation;
    return $this;
}
    
    
public function getTrainingConfirmation()
    {
        return $this->trainingconfirmation;
    }
    
public function setSettlement1 ($settlement1)
{
    $this->settlement1 = $settlement1;
    return $this;
}

public function getSettlment1()
    {
        return $this->settlement1;
    }
    
public function setSettlement2 ($settlement2)
{
    $this->settlement2 = $settlement2;
    return $this;
}
    
    
public function getSettlment2()
    {
        return $this->settlement2;
    }

    
    
}