<?php

namespace SNDLL\PlatformBundle\Form;

use Doctrine\ORM\EntityRepository;
use SNDLL\PlatformBundle\Entity\TypeAdhesion;
use SNDLL\PlatformBundle\Entity\TypeAdhesionRepository;
use SNDLL\PlatformBundle\Entity\CotisationRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CotisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adherent',                   'entity', array(
                'class'    => 'SNDLLPlatformBundle:Adherent',
                'property' => 'code_adherent',
                'multiple' => false,
                'expanded' => false
            ))
            ->add('datedebut',                  'date')
            ->add('datefin',                    'date')
            ->add('prixcotisationttc',          'number')
            ->add('modereglement',              'entity', array(
                'class'    => 'SNDLLPlatformBundle:ModeReglement',
                'property' => 'libelle',
                'multiple' => false,
                'expanded' => false
            ))
            ->add('typeadhesion',               'entity', array(
                'class'    => 'SNDLLPlatformBundle:TypeAdhesion',
                'property' => 'libelle',
                'multiple' => false,
                'expanded' => false
            ))
            ->add('datereglement',              'date')
            ->add('enregistrer',                       'submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SNDLL\PlatformBundle\Entity\Cotisation'
        ));
    }

    public function getName()
    {
        return 'sndll_platformbundle_cotisation';
    }
}