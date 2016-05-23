<?php

namespace SNDLL\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TypeAdhesionAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

    }

    public function getName()
    {
        return 'sndll_platformbundle_type_adhesion_add';
    }

    public function getParent()
    {
        return new TypeAdhesionType();
    }
}
