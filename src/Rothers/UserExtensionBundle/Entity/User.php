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

  /**
   * @var integer $customer
   *
   * @ORM\OneToOne(targetEntity="Rothers\UserExtensionBundle\Entity\Customer", mappedBy="user");
   */
  private $customer;

  /**
   * @var integer $agent
   *
   * @ORM\OneToOne(targetEntity="Rothers\UserExtensionBundle\Entity\Agent", mappedBy="user");
   */
  private $agent;

  /**
   * @var integer $admin
   *
   * @ORM\OneToOne(targetEntity="Rothers\UserExtensionBundle\Entity\Admin", mappedBy="user");
   */
  private $admin;

  /**
   * Set customer
   *
   * @param Rothers\UserExtensionBundle\Entity\Customer $customer
   */
  public function setCustomer(\Rothers\UserExtensionBundle\Entity\Customer $customer) {
    $this->customer = $customer;
  }

  /**
   * Get customer
   *
   * @return Rothers\UserExtensionBundle\Entity\Customer 
   */
  public function getCustomer() {
    return $this->customer;
  }

  /**
   * Set agent
   *
   * @param Rothers\UserExtensionBundle\Entity\Agent $agent
   */
  public function setAgent(\Rothers\UserExtensionBundle\Entity\Agent $agent) {
    $this->agent = $agent;
  }

  /**
   * Get agent
   *
   * @return Rothers\UserExtensionBundle\Entity\Agent 
   */
  public function getAgent() {
    return $this->agent;
  }

  /**
   * Set admin
   *
   * @param Rothers\UserExtensionBundle\Entity\Admin $admin
   */
  public function setAdmin(\Rothers\UserExtensionBundle\Entity\Admin $admin) {
    $this->admin = $admin;
  }

  /**
   * Get admin
   *
   * @return Rothers\UserExtensionBundle\Entity\Admin 
   */
  public function getAdmin() {
    return $this->admin;
  }
  
}