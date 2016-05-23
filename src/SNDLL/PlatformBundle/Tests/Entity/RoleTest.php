<?php

namespace SNDLL\PlatformBundle\Tests\Entity;

use SNDLL\PlatformBundle\Entity\Role;

class RoleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetterSetter()
    {
        $role = new Role();

        $role->setId('1');
        $this->assertEquals('1', $role->getId());

        $role->setLibelle('Directeur');
        $this->assertEquals('Directeur', $role->getLibelle());
    }
}