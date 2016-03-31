<?php


class IndexManager{
  
    protected $entityname;
    
    protected $em;
    
    public function __construct($entityname,$entityManager) {
      $this->entityname=$entityname;
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
    
    
    public function getIndexEntity(){
        $qb=  $this->em->createQueryBuilder();
        $qb ->select('ditto')
            ->from('AppBundle:Indices', 'ditto')
            ->where('index=:tablename')
            ->setParameter('tablename', $this->entityname);
        
        
        $index=$qb->getQuery()->getSingleResult();
        
        return $index;
    }
}
