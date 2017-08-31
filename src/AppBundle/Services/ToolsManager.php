<?php



namespace AppBundle\Services;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;


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
    
    //Builds the Flashtext for the search which is displayed on the main page
    //Parameters:
    //  $introText: The Text that is preceding the displayed searchparameters
    //  $parameterArray: The array containing the searchparameters
    public function buildFlashtext($introText, array $parameterArray)
    {
        //Till php version 7 you cannot fix the type of the parameter $introText to string
        if(!is_string($introText))
        {
            throw new Exception('The first parameter must be of type string.');
        }
        
        //The flashtext to build and  which is counted during the loop
        $flashText='';
        //The number of nested array to decide whether the method needs to set a comma behind a set of parameters
        $nestedArrayCount=0;        
        foreach ($parameterArray as $nestedParameterArray)
        {
            $nestedArrayCount++;
            
            //The number of parameter per nested array to decide whether the method needs to set a comma behind a parameter
            $parameterCount=0;
            //Text of the parameters of one nested array
            $parameterText='';
            
            //The first element of each nested array is the name the parameters belong to
            $nameOfNestedArray = $nestedParameterArray[0];
            //unset the name to not further process it as a parameter
            unset($nestedParameterArray[0]);
            
            foreach ($nestedParameterArray as $parameterName => $parameterValue)
            {
                $parameterCount++;
                //If the number of parameter exceeds 2 set a comma between each parameter
                if($parameterCount>=2)
                {
                    $parameterText=$parameterText.', ';
                }

                $parameterText.= $parameterName.': '.$parameterValue;
                
            }
            //If the number of nested arrays exceeds 2 set a comma between each nested arrays
            if($nestedArrayCount>=2)
            {
                $flashText=$flashText.', ';
            }
            $flashText.=$nameOfNestedArray.'[ '.$parameterText.' ]';
        }
        
        return $introText.$flashText;
    }
        
    
}
