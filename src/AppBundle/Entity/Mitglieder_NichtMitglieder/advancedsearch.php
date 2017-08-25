<?php


namespace AppBundle\Entity\Mitglieder_NichtMitglieder;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;





class advancedsearch
{
    
    public $isQuitted = false;
    
    public function __construct($relation)
    {
        if ($relation == 'ausgetreten')
        {
            $this->setIsQuitted(true);
        
        }
    }

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
    
    public $sportsgroup;
    public $membersportsgroupstate;
    
    
    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload=null)
    {
        if($this->allFieldsAreEmpty())
        {
            $context->buildViolation('Um eine Suche durchführen zu können, werden Suchkriterien benötigt.')
                    ->atPath('form')
                    ->addViolation();
        }
        else
        {
        
            $terminationdatecompoperator=$this->getTerminationdatecompoperators();
            $tdcompoperatormapping = array(''=> null, '=' => 'Zu', '<' => 'Vor', '>' => 'Nach');
            $terminationdate = $this->getTerminationdate();
            $rehabunitscompoperator = $this->getRehabunitscompoperators();
            $rehabunits = $this->getRehabunits();
            $membersportsgroupstate = $this->getMembersportsgroupstate();
            $sportsgroupstateMapping = array(''=> null, 'is' => array('in', 'eingeschrieben'), 'is not' => array('aus', 'ausgetreten'));
            $sportsgroup = $this->getSportsgroup();
            
            $this->buildBothFieldsAreNotFilledViolation($terminationdatecompoperator, $terminationdate, $tdcompoperatormapping[$terminationdatecompoperator].' welchem Datum läuft der Rehaschein ab?', 'terminationdate', $context);
            $this->buildBothFieldsAreNotFilledViolation($terminationdate, $terminationdatecompoperator, 'Bitte geben Sie einen Zeitraum an.', 'terminationdatecompoperators', $context);

            $this->buildBothFieldsAreNotFilledViolation($rehabunitscompoperator, $rehabunits, 'Bitte geben Sie die Anzahl der Einheiten an.', 'rehabunits', $context);
            $this->buildBothFieldsAreNotFilledViolation($rehabunits, $rehabunitscompoperator, 'Bitte geben Sie einen Vergleichsoperator an.', 'rehabunitscompoperators', $context);
            
            if(!$this->isQuitted)
            {
                $this->buildBothFieldsAreNotFilledViolation($membersportsgroupstate, $sportsgroup, 'Bitte wählen Sie eine Sportgruppe, '.$sportsgroupstateMapping[$membersportsgroupstate][0].' welche die gesuchten Personen '.$sportsgroupstateMapping[$membersportsgroupstate][1].' sein sollen.', 'sportsgroup', $context);
                $this->buildBothFieldsAreNotFilledViolation($sportsgroup, $membersportsgroupstate, 'Bitte geben Sie ein Teilnahmeverhältnis an.', 'membersportsgroupstate', $context);
            }
        }
    }
    
    private function buildBothFieldsAreNotFilledViolation($notEmptyVar, $emptyVar, $violationText, $path, $context)
    {
        if(!empty($notEmptyVar) && empty($emptyVar))
        {
            $context->buildViolation($violationText)
                    ->atPath($path)
                    ->addViolation();
        }
    }
    
    function allFieldsAreEmpty()
    {
        $properties = get_object_vars($this);
        $properties['isQuitted']='';
        $filteredProperties = array_filter($properties);
        return empty($filteredProperties);

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


    function getSportsgroup() {
        return $this->sportsgroup;
    }

    function setSportsgroup($sportsgroup) {
        $this->sportsgroup = $sportsgroup;
    }


    function getMembersportsgroupstate() {
        return $this->membersportsgroupstate;
    }

    function setMembersportsgroupstate($membersportsgroupstate) {

        $this->membersportsgroupstate = $membersportsgroupstate;

    }

    function getIsQuitted() {
        
        return $this->isQuitted;
    }

    function setIsQuitted($isQuitted) {
        $this->isQuitted = $isQuitted;
    }



}
