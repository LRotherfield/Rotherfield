<?php

namespace Rothers\UserExtensionBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class UserExtensionBundle extends Bundle
{
  public function getParent(){
    return 'RothersUserBundle';
  }

}
