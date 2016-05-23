<?php

namespace SNDLL\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SacemEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('codesacem');
    }

    public function getName()
    {
        return 'sndll_platformbundle_sacem_edit';
    }

    public function getParent()
    {
        return new SacemType();
    }
}
