<?php

namespace SNDLL\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->remove('idutilisateurwp')
        ->remove('etatcontact')
        ->remove('datedernieremodification');
    }

    public function getName()
    {
        return 'sndll_platformbundle_contact_add';
    }

    public function getParent()
    {
        return new ContactType();
    }
}
