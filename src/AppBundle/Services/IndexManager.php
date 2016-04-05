<?php

namespace AppBundle\Services;


class IndexManager{
  
    protected $entityname;
    
    protected $em;
    
    public function __construct($entityManager) {

      $this->em=$entityManager;
    }
    
    public function add($number=1){
                
        $index=$this->getIndexEntity()->setIndex($this->getCurrentIndex()+$number);
        
        $this->em->persist($index);
        $this->em->push($index);
        
        return $this;
    }
    
    
    public function remove($number=1){        
        
        $index=$this->getIndexEntity()->setIndex($index->getCurrentIndex()-$number);
        
        $this->em->persist($index);
        $this->em->push($index);
        
    }
    
    
    public function getCurrentIndex(){
        
        return $this->getIndexEntity()->getIndex();
    }
    
    
    
    
    function setEntityName($entityname) {
        $this->entityname = $entityname;
    }

        
    public function getEntityName(){
        
        return $this->entityname;
    }
    
    public function setEntityname($entityname)
    {
        $this->entityname = $entityname;

        return $this;
    }
    
     
    
    
    public function getIndexEntity(){
        $qb=  $this->em->createQueryBuilder();
        $qb ->select('ditto')
            ->from('AppBundle:Indices', 'ditto')
            ->where('ditto.tablename=:tablename')
            ->setParameter('tablename', $this->getEntityName());
        
        
        $index=$qb->getQuery()->getSingleResult();
        
        if($index){
        return $index;
        }
        else{
            throw new Exception('Division durch Null.');
        }
    }
}
