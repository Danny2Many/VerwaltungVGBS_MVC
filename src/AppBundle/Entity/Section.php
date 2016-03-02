<?php



namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="Section")
 */
class Section {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer") 
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $secid;
    
    /**
     * @ORM\Column(type="string")
        * @Assert\NotBlank()
     * 
     */
    protected $sectionname;

    

    /**
     * Get secid
     *
     * @return integer
     */
    public function getSecid()
    {
        return $this->secid;
    }

    /**
     * Set sectionname
     *
     * @param string $sectionname
     *
     * @return Section
     */
    public function setSectionname($sectionname)
    {
        $this->sectionname = $sectionname;

        return $this;
    }

    /**
     * Get sectionname
     *
     * @return string
     */
    public function getSectionname()
    {
        return $this->sectionname;
    }
}
