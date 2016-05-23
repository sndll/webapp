<?php

namespace SNDLL\PlatformBundle\Form;

use Doctrine\ORM\EntityRepository;
use SNDLL\PlatformBundle\Entity\TypeAdhesion;
use SNDLL\PlatformBundle\Entity\TypeAdhesionRepository;
use SNDLL\PlatformBundle\Entity\CotisationRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datedebut',                  'date')
            ->add('datefin',                    'date')
            ->add('exporter',                   'submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SNDLL\PlatformBundle\Entity\Export'
        ));
    }

    public function getName()
    {
        return 'sndll_platformbundle_export';
    }
}