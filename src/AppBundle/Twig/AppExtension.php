<?php



namespace AppBundle\Twig;


class AppExtension extends \Twig_Extension {
    
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('age', array($this, 'ageFilter')),
        );
    }

    public function ageFilter($date)
    {
        $now = new \DateTime(date('Y-m-d'));

          $difference = $date->diff($now);
 
  return $difference->format('%y');
    }

    public function getName()
    {
        return 'app_extension';
    }
}
