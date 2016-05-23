<?php

namespace SNDLL\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EtablissementAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('adherent')
            ->remove('contacts')
            ->remove('etatcontact')
            ->remove('sacem')
            ->remove('etatetablissement');
    }

    public function getName()
    {
        return 'sndll_platformbundle_etablissement_add';
    }

    public function getParent()
    {
        return new EtablissementType();
    }
}
