<?php

namespace SNDLL\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EtablissementEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->remove('adherent')
        ->remove('contacts')
        ->remove('sacem');
    }

    public function getName()
    {
        return 'sndll_platformbundle_etablissement_edit';
    }

    public function getParent()
    {
        return new EtablissementType();
    }
}
