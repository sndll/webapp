<?php

namespace SNDLL\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CoordonneesOGCType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('telephonesecondaire')
            ->remove('autorisation');
    }

    public function getName()
    {
        return 'sndll_platformbundle_coordonnees_ogc_edit';
    }

    public function getParent()
    {
        return new CoordonneesType();
    }
}
