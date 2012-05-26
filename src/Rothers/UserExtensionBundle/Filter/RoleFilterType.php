<?php

namespace Rothers\UserExtensionBundle\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class RoleFilterType extends AbstractType implements \Lexik\Bundle\FormFilterBundle\Filter\Extension\EmbeddedFilterInterface
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        
        $builder
            ->add('id', 'filter_entity', array(
                'class' => 'Rothers\UserBundle\Entity\Role',
                'label' => ' ' 
            ));
    }

    public function getName()
    {
        return 'userextensionbundle_rolefiltertype';
    }
}