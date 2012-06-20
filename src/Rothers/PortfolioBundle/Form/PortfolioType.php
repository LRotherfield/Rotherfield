<?php

namespace Rothers\PortfolioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PortfolioType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('link')
            ->add('title')
            ->add('colour')
            ->add('border')
            ->add('reference')
            ->add('description')
            ->add('excerpt')
            ->add('partial')
            ->add('created')
            ->add('updated')
        ;
    }

    public function getName()
    {
        return 'portfoliotype';
    }
}
