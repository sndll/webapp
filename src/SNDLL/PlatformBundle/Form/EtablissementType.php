<?php

namespace SNDLL\PlatformBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EtablissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adherent',                   new AdherentType())
            ->add('enseigne',                   'text')
            ->add('formejuridique',             'entity', array(
                'class'    => 'SNDLLPlatformBundle:FormeJuridique',
                'property' => 'libelle',
                'multiple' => false,
                'expanded' => false
            ))
            ->add('nomjuridique',               'text', array(
                'required' => false
            ))
            ->add('coordonnees',                new CoordonneesType())
            ->add('siteinternet',               'text', array(
                'required' => false
            ))
            ->add('codeape',                    'entity', array(
                'class'    => 'SNDLLPlatformBundle:CodeAPE',
                'property' => 'codeape',
                'multiple' => false,
                'expanded' => false,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('ca')
                        ->orderBy('ca.code_ape', 'DESC');
                }
            ))
            ->add('datecreation',               'birthday', array(
                'required'  => false
            ))
            ->add('capacite',                   'entity', array(
                'class'    => 'SNDLLPlatformBundle:Capacite',
                'property' => 'libelle',
                'multiple' => false,
                'expanded' => false
            ))
            ->add('codesiret',                  'text', array(
                'required' => false
            ))

            ->add('nombresalaries',             'text', array(
                'required' => false
            ))
            ->add('etatetablissement',          'entity', array(
                'class'    => 'SNDLLPlatformBundle:EtatEtablissement',
                'property' => 'libelle',
                'multiple' => false,
                'expanded' => false
            ))
            ->add('commentaires',               'textarea', array(
                'required' => false
            ))
            ->add('contacts',                   'collection', array(
                'type'         => new ContactAddType(),
                'allow_add'    => true,
                'allow_delete' => true
            ))
            ->add('sacem',          'entity', array(
                'class'    => 'SNDLLPlatformBundle:Sacem',
                'property' => 'libelle',
                'multiple' => false,
                'expanded' => false
            ))
            ->add('enregistrer',                       'submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SNDLL\PlatformBundle\Entity\Etablissement'
        ));
    }

    public function getName()
    {
        return 'sndll_platformbundle_etablissement';
    }
}