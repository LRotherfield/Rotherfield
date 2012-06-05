<?php

namespace Rothers\UserExtensionBundle\Entity;

use Rothers\UserBundle\Entity\User as BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Rothers\UserExtensionBundle\Entity\User
 * @ORM\Entity(repositoryClass="Rothers\UserBundle\Entity\UserRepository")
 * @ORM\Table(name="user")
 */
class User extends BaseEntity {

}