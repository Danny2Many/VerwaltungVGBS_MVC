<?php

namespace AppBundle\Services;


class SearchManager {
    
    protected $qb;
    protected $searchval;
    protected $searchcol;

    
    public function __construct($qb,$searchval,$searchcol) {
        $this->qb=$qb;
        $this->searchval=$searchval;
        $this->searchcol=$searchcol;

    } 
    
    public function Many2OneSearch($searchentity,$idprefix) {
        $searchqb = clone $searchentity;
        $searchqb->andWhere($searchqb->expr()->like('ditto.'.  $this->searchcol,':type'))
        ->setParameter('type','%'.  $this->searchval.'%');

            $searchlist=$searchqb->getQuery()->getResult();
            
            if($searchlist){          
                foreach ($searchlist as $sc){         
                $idarray[]=  call_user_func('get'.$idprefix.'id',$sc);     
                }                
            }else{
                $idarray=array(null);
            }
            
            $this->qb->andWhere($this->qb->expr()->in('ditto.'.$idprefix.'id', $idarray));       
        
    }
    
}