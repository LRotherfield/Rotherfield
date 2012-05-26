<?php

namespace Rothers\UserExtensionBundle\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserFilterType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        
        $builder
            ->add('id', 'filter_number')
            ->add('username', 'filter_text', array('condition_pattern' => '%%%s%%'))
            ->add('roles', new RoleFilterType());
    }

    public function getName()
    {
        return 'userextensionbundle_userfiltertype';
    }
}