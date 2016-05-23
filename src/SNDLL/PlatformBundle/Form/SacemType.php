<?php

namespace SNDLL\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SacemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('coordonnees',                new CoordonneesOGCType())
            ->add('codesacem',                  'text')
            ->add('libelle',                    'text')
            ->add('civilite',                   'entity', array(
                'class'    => 'SNDLLPlatformBundle:Civilite',
                'property' => 'libelle',
                'multiple' => false,
                'expanded' => false
            ))
            ->add('nomresponsable',             'text')
            ->add('prenomresponsable',          'text')
            ->add('enregistrer',                       'submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SNDLL\PlatformBundle\Entity\Sacem'
        ));
    }

    public function getName()
    {
        return 'sndll_platformbundle_sacem';
    }
}