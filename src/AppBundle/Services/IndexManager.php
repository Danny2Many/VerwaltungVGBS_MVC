<?php


class IndexManager{
  
    protected $entitypath;
    
    protected $em;
    
    public function __construct($entitypath,$entityManager) {
      $this->entitypath=$entitypath;
      $this->em=$entityManager;
    }
    
    public function add($number=1){
        $qb=  $this->em->createQueryBuilder();
        $qb ->select('ditto')
            ->from($this->entitypath, 'ditto')
            ->where('index=:tablename')
            ->setParameter('tablename', $this->getTableName());
        
        
        $index=$qb->getQuery()->getSingleResult();
        
        $index->setIndex($index->getIndex()+$number);
        
        $this->em->persist($index);
        $this->em->push($index);
        
    }
    
    public function getCurrentIndex(){
        $qb=  $this->em->createQueryBuilder();
        $qb->select('index')
                 ->from($this->entitypath)
                 ->where('index=:tablename')
                 ->setParameter('tablename', $this->getTableName());
        $index=$this->qb->getQuery()->getSingleResult();
        return $index->getIndex();
    }
    
    public function getTableName(){
        $splitpath=  explode("/", $this->entitypath);
          
        
        return end($splitpath);
    }
}
