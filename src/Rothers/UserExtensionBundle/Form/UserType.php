<?php

namespace Rothers\UserExtensionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserType extends AbstractType
{
  
    private $roles;
  
    public function __construct($roles = false){
      $this->roles = $roles;
    }
  
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('username', 'email', array(
                'label' => 'Email'
            ))
            ->add('password', 'repeated', array(
                'type' => 'password',
                'first_name' => 'Password',
                'second_name' => 'Repeat Password',
                'invalid_message' => 'The passwords do not match'
            ));
        
        
        if($this->roles){
          $builder
            ->add('role_objects', 'entity', array(
                'class' => 'Rothers\UserBundle\Entity\Role',
                'multiple' => true,
                'expanded' => true
            ));
        }
        
    }

    public function getName()
    {
        return 'userextensionbundle_usertype';
    }
}
