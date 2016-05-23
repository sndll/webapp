<?php

namespace SNDLL\PlatformBundle\Form;

use SNDLL\PlatformBundle\Entity\Spre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SpreEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('coordonnees',                new CoordonneesOGCType())
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
            'data_class' => 'SNDLL\PlatformBundle\Entity\Spre'
        ));
    }

    public function getName()
    {
        return 'sndll_platformbundle_spre_edit';
    }
}