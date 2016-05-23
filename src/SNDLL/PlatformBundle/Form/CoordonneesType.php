<?php

namespace SNDLL\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CoordonneesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adresse',                        'text')
            ->add('codepostal',                     'text')
            ->add('ville',                          'text')
            ->add('informationscomplementaires',    'textarea', array(
                'required' => false
            ))
            ->add('telephoneprincipal',             'text', array(
                'required' => false
            ))
            ->add('telephonesecondaire',            'text', array(
                'required' => false
            ))
            ->add('fax',                            'text', array(
                'required' => false
            ))
            ->add('email',                          'text', array(
                'required' => false
            ))
            ->add('autorisation',                   'entity', array(
                'class'    => 'SNDLLPlatformBundle:Autorisation',
                'property' => 'libelle',
                'multiple' => false,
                'expanded' => false
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SNDLL\PlatformBundle\Entity\Coordonnees'
        ));
    }

    public function getName()
    {
        return 'sndll_platformbundle_coordonnees';
    }
}
