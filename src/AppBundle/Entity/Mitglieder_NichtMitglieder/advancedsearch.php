<?php


namespace AppBundle\Entity\Mitglieder_NichtMitglieder;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;





class advancedsearch
{

    /**
     * @Assert\Type("int")
     * @Assert\Range(
     *      min = 0,
     *      minMessage = "Bitte geben sie eine Zahl größer-gleich {{ limit }} ein.",
     * )
     */
    protected $rehabunits;
    

    /**
    *
    * @Assert\Date(message ="Bitte geben Sie ein gültiges Datum an.")
    */
    public $terminationdate;
    
    
    
    public $terminationdatecompoperators;
    public $rehabunitscompoperators;
    
    
    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload=null)
    {
        if($this->allFieldsAreEmpty())
        {
            $context->buildViolation('Sie haben keine Such-Parameter angegeben.')
                    ->atPath('form')
                    ->addViolation();
        }
        else
        {
            if($this->getTerminationdatecompoperators()!='' && $this->getTerminationdate()=='')
            {
                switch ($this->getTerminationdatecompoperators())
                {
                    case '=': $time = 'An';
                    break;
                    case '<': $time = 'Vor';
                    break;
                    case '>': $time = 'Nach';
                    break;

                }
                $context->buildViolation($time.' welchem Datum läuft der Rehaschein ab?')
                        ->atPath('terminationdate')
                        ->addViolation();
            }
            else if ($this->getTerminationdate()!='' && $this->getTerminationdatecompoperators()=='')
            {
                $context->buildViolation('Bitte geben Sie einen Zeitraum an.')
                        ->atPath('terminationdatecompoperators')
                        ->addViolation();
            }

            
            if ($this->getRehabunitscompoperators()!='' && $this->getRehabunits()=='')
            {
                $context->buildViolation('Bitte geben Sie die Anzahl der Einheiten an.')
                        ->atPath('rehabunits')
                        ->addViolation();
            }
            else if ($this->getRehabunits()!='' && $this->getRehabunitscompoperators()=='')
            {
                $context->buildViolation('Bitte geben Sie einen Vergleichsoperator an.')
                        ->atPath('rehabunitscompoperators')
                        ->addViolation();
            }
        }
    }
    
    function allFieldsAreEmpty()
    {
        $properties = array_filter(get_object_vars($this));
        return empty($properties);

    }
    
    function getRehabunits() {
        return $this->rehabunits;
    }

    function getTerminationdate() {
        return $this->terminationdate;
    }

    function setRehabunits($rehabunits) {
        $this->rehabunits = $rehabunits;
    }

    function setTerminationdate($terminationdate) {
        $this->terminationdate = $terminationdate;
    }

    function getTerminationdatecompoperators() {
        return $this->terminationdatecompoperators;
    }

    function getRehabunitscompoperators() {
        return $this->rehabunitscompoperators;
    }

    function setTerminationdatecompoperators($terminationdatecompoperators) {
        $this->terminationdatecompoperators = $terminationdatecompoperators;
    }

    function setRehabunitscompoperators($rehabunitscompoperators) {
        $this->rehabunitscompoperators = $rehabunitscompoperators;
    }


     
}
