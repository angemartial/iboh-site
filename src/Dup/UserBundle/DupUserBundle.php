<?php

namespace Dup\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DupUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
