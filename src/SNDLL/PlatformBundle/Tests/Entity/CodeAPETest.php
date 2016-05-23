<?php

namespace SNDLL\PlatformBundle\Tests\Entity;

use SNDLL\PlatformBundle\Entity\CodeAPE;

class CodeAPETest extends \PHPUnit_Framework_TestCase
{
    public function testGetterSetter()
    {
        $codeape = new CodeAPE();

        $codeape->setCodeAPE('9329Z');
        $this->assertEquals('9329Z', $codeape->getCodeAPE());

        $codeape->setLibelle('Activités récréatives et de loisirs - Discothèque');
        $this->assertEquals('Activités récréatives et de loisirs - Discothèque', $codeape->getLibelle());
    }
}