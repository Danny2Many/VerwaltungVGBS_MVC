<?php



namespace AppBundle\Form\Type\Mitglieder;


use AppBundle\Form\Type\PersonalDataType;
use Symfony\Component\Form\FormBuilderInterface;



use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use AppBundle\Form\SanitizedTextType;
use AppBundle\Form\SanitizedTextareaType;
use AppBundle\Form\Type\RehabCertType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\Type\SportsgroupType;
use Symfony\Component\Validator\Constraints\Valid;

class BaseMemberType extends AbstractType{
  
    public function buildForm(FormBuilderInterface $builder, array $options)      
    {
        if($options['typeSymbol']=='m')
        {
            $beginDate='Eintrittsdatum:';
            $participationConfirmation='Aufnahmebest.:';
        }
        else
        {
            $beginDate='Teilnahmebeginn:';
            $participationConfirmation='Teilnahmebeginnbest.';
        }

        $builder
        ->add('personaldata', PersonalDataType::class, array(
        'data_class' => 'AppBundle\Entity\Mitglieder_NichtMitglieder\Member',
        'pn_data_class' => 'AppBundle\Entity\Mitglieder_NichtMitglieder\MemPhoneNumber'
        ))
                
        ->add('lagacymemid', SanitizedTextType::class, array('label' => 'Alte Nr.:', 'required' => false))
                
        ->add('admissiondate', DateType::class, array( 'label' => $beginDate, 'widget' => 'choice', 'format' => 'yyyy-MM-dd', 'placeholder' => array('year' => 'Jahr', 'month' => 'Monat', 'day' => 'Tag')))
                
        ->add('admissionconfirmation', DateType::class, array( 'label' => $participationConfirmation, 'widget' => 'choice', 'format' => 'yyyy-MM-dd', 'placeholder' => array('year' => 'Jahr', 'month' => 'Monat', 'day' => 'Tag'), 'required' => false))
                
        ->add('state', ChoiceType::class, array(
        'choices'  => array(
        'Fördernd' => 1,
        'Nicht fördernd' => 0,
        ),
        'choices_as_values' => true,
        'label' => 'Förderstatus:'
        ))
                
        ->add('newsletter', ChoiceType::class, array(
        'choices'  => array(
        'Ja' => 1,
        'Nein' => 0,
        ),
        'choices_as_values' => true,
        'label' => 'Erhält Newsletter:'
        ))

        ->add('rehabilitationcertificate', CollectionType::class, array('entry_type' => RehabCertType::class, 'entry_options' => array('data_class' => 'AppBundle\Entity\Mitglieder_NichtMitglieder\MemRehabilitationCertificate'), 'allow_add' => true, 'by_reference' => false, 'allow_delete' => true, 'constraints' => array(new Valid())))
                
        ->add('sportsgroup', CollectionType::class, array('entry_type' => SportsgroupType::class, 'entry_options' => array('data_class' => 'AppBundle\Entity\Mitglieder_NichtMitglieder\Member_Sportsgroup','typeSymbol'=>$options['typeSymbol']), 'allow_add' => true, 'by_reference' => false, 'allow_delete' => true, 'constraints' => array(new Valid())))
                
        ->add('healthinsurance', SanitizedTextType::class, array('label' => 'Krankenkasse:', 'required' => false))       

        ->add('additionalinfo', SanitizedTextareaType::class, array('label' => 'Zusatzinfo:', 'required' => false)) 

        ->add('workplaceposture', SanitizedTextareaType::class, array('label' => 'Arbeitsplatzhaltung:', 'required' => false))

        ->add('chronoccupationaldis', SanitizedTextareaType::class, array('label' => 'chron. Berufserkr:', 'required' => false))

        ->add('paincervicalspine', SanitizedTextType::class, array('label' => 'Schmerzen in HWS:', 'required' => false))

        ->add('painthoracicspine', SanitizedTextType::class, array('label' => 'Schmerzen in BWS:', 'required' => false))

        ->add('painlumbarspine', SanitizedTextType::class, array('label' => 'Schmerzen in LWS:', 'required' => false))

        ->add('upperlimbs', SanitizedTextType::class, array('label' => 'obere Extr.:', 'required' => false))

        ->add('lowerlimbs', SanitizedTextType::class, array('label' => 'untere Extr.:', 'required' => false))

        ->add('otherimpairments', SanitizedTextareaType::class, array('label' => 'sonst. Beeinträchtigungen:', 'required' => false))

        ->add('medication', SanitizedTextareaType::class, array('label' => 'Medikamente:', 'required' => false))

        ->add('additionalagilactivities', SanitizedTextareaType::class, array('label' => 'weit. bewegl. Aktivitäten:', 'required' => false))

        ->add('pulseatrest', NumberType::class, array( 'label' => 'Hf-Ruhe/Min:', 'scale' => 0, 'required' => false))

        ->add('save', SubmitType::class, array('attr' => array('class' => 'btn btn-primary'), 'label' => 'Speichern'))
        ->add('cancel', ButtonType::class, array('attr' => array('class' => 'btn btn-default'), 'label' => 'Abbrechen'))
        ->add('reset', ButtonType::class, array('attr' => array('class' => 'btn btn-warning'), 'label' => 'Zurücksetzen'));

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => "AppBundle\Entity\Mitglieder_NichtMitglieder\Member",
            'typeSymbol' => null
            
        ));
    }
    
}
