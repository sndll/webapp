<?php

namespace SNDLL\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civilite',                           'entity', array(
                'class'    => 'SNDLLPlatformBundle:Civilite',
                'property' => 'libelle',
                'multiple' => false,
                'expanded' => false
            ))
            ->add('nom',                                'text')
            ->add('prenom',                             'text', array(
                'required' => false
            ))
            ->add('coordonnees',                        new CoordonneesType(), array(
                'required' => false
            ))
            ->add('role',                               'entity', array(
                'class'    => 'SNDLLPlatformBundle:Role',
                'property' => 'libelle',
                'multiple' => false,
                'expanded' => false
            ))
            ->add('etatcontact',                        'entity', array(
                'class'    => 'SNDLLPlatformBundle:EtatContact',
                'property' => 'libelle',
                'multiple' => false,
                'expanded' => false
            ))
            ->add('commentaires',                       'textarea', array(
                'required' => false
            ))
            ->add('idutilisateurwp',                    'number')
            ->add('datedernieremodification',           'date')
            ->add('enregistrer',                       'submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SNDLL\PlatformBundle\Entity\Contact'
        ));
    }

    public function getName()
    {
        return 'sndll_platformbundle_contact';
    }
}