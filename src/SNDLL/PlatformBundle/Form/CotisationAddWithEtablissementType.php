<?php

namespace SNDLL\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CotisationAddWithEtablissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('adherent');
    }

    public function getName()
    {
        return 'sndll_platformbundle_cotisation_add_etablissement';
    }

    public function getParent()
    {
        return new CotisationType();
    }
}
