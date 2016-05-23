<?php

namespace SNDLL\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CotisationEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('adherent');
    }

    public function getName()
    {
        return 'sndll_platformbundle_cotisation_edit';
    }

    public function getParent()
    {
        return new CotisationType();
    }
}
