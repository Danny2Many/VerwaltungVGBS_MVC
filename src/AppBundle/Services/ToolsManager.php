<?php



namespace AppBundle\Services;
use Doctrine\Common\Collections\ArrayCollection;



class ToolsManager {

    public $manager;
    
    public function __construct($manager) {
        $this->manager=$manager;
    }
   
    public function sortOutRemoved($origenalArrayColl, $submittedArrayColl){
        foreach ($origenalArrayColl as $o) 
            {
            if (false === $submittedArrayColl->contains($o)) {
                $this->manager->remove($o);
            }
        } 
    }
    
    public function copyArrayCollection($arrayCollToCopy){
        $copiedArrayColl = new ArrayCollection();
        foreach ($arrayCollToCopy as $element) {
            $copiedArrayColl->add($element);
        }
        return $copiedArrayColl;
    }
}
