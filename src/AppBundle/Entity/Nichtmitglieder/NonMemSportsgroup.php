<?php


namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Table(name="NonMemSportsgroup")
 */
class NonMemSportsgroup {
    

    /**
     * @ORM\Id
     * @ORM\Column(type="integer") 
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $sgid;
    
    /**
     * @ORM\Column(type="string")
        * @Assert\NotBlank()
     * @Assert\Choice(choices = {"Mitglieder", "Nichtmitglieder"}, message = "Bitte wählen Sie eine gültige Kategorie.")
     */
    protected $category;
    
    /**
     * @ORM\Column(type="string")
        * @Assert\NotBlank()
     * @Assert\Choice(choices = {"Mitglieder", "Nichtmitglieder"}, message = "Bitte wählen Sie eine gültige Kategorie.")
     */
    protected $type;
    
    /**
     * @ORM\Column(type="string")
        * @Assert\NotBlank()
     * 
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string")
        * @Assert\NotBlank()
     * 
     */
    protected $day;
    
    /**
     * @ORM\Column(type="time")
        * @Assert\NotBlank()
     * 
     */
    protected $time;
    
    /**
     * @ORM\Column(type="string")
        * @Assert\NotBlank()
     * 
     */
    protected $info;
    
    /**
     * @ORM\Column(type="integer")
        * 
     * 
     */
    protected $roomid;
    
    /**
     * @ORM\Column(type="integer")
        
     */
    protected $trainerid;
    
    /**
     * @ORM\Column(type="string")
        * @Assert\NotBlank()
     * 
     */
    protected $token;
    
    
