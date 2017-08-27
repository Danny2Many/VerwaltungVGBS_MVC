<?php



namespace AppBundle\Services;
use Doctrine\Common\Collections\ArrayCollection;


//Manages all written functions
class ToolsManager {

    //the entitymanager to persist and delete object to and from the database
    public $entitymanager;
    
    public function __construct($entitymanager) {
        $this->entitymanager=$entitymanager;
    }
   
    //Deletes objects of the $origenalArrayColl from the database which arent in the $submittedArrayColl
    public function sortOutRemoved($origenalArrayColl, $submittedArrayColl){
        foreach ($origenalArrayColl as $o) 
            {
            if (false === $submittedArrayColl->contains($o)) {
                $this->entitymanager->remove($o);
            }
        } 
    }
    
    //Copies all elements of the ArrayCollection $arrayCollToCopy to $copiedArrayColl and returns it
    public function copyArrayCollection($arrayCollToCopy){
        $copiedArrayColl = new ArrayCollection();
        foreach ($arrayCollToCopy as $element) {
            $copiedArrayColl->add($element);
        }
        return $copiedArrayColl;
    }
}
