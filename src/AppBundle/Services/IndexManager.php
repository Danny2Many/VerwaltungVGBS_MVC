<?php

namespace AppBundle\Services;


class IndexManager{
  
    protected $entityname;
    
    protected $em;
    
    public function __construct($entityManager) {
      $this->em=$entityManager;
    }
    
    public function add($number=1){
        
        
        $index=getIndexEntity()->setIndex($index->getCurrentIndex()+$number);
        
        $this->em->persist($index);
        $this->em->push($index);
        
        
    }
    
    
    public function remove($number=1){
        
        
        $index=getIndexEntity()->setIndex($index->getCurrentIndex()-$number);
        
        $this->em->persist($index);
        $this->em->push($index);
        
    }
    
    
    public function getCurrentIndex(){
        
        return $this->getIndexEntity()->getIndex();
    }
    
    
    
    public function getTableName(){
        
          
        
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
            ->where('tablename=:tablename')
            ->setParameter('tablename', $this->entityname);
        
        
        $index=$qb->getQuery()->getSingleResult();
        
        return $index;
    }
}
