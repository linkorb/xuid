<?php

namespace Xuid;

use PHPUnit_Framework_TestCase;

class XuidTest extends PHPUnit_Framework_TestCase
{
    public function testValidUuid()
    {
        $xuid = new Xuid();
        
        $this->assertTrue($xuid->isValidUuid('d8f8b62c-2fe2-4ac7-8a1e-211e01f1834a'));
        $this->assertTrue($xuid->isValidUuid('df49441e-ef4d-4886-90e2-c0b46d00df7c'));

        // add's a 'g'
        $this->assertFalse($xuid->isValidUuid('df49441e-ef4d-4886-90e2-c0b46d00df7g'));
        
        // too long
        $this->assertFalse($xuid->isValidUuid('df49441e-ef4d-4886-90e2-c0b46d00df7cc'));

        // misplaced dash
        $this->assertFalse($xuid->isValidUuid('df49441e-ef4d-4886-90e2c-0b46d00df7c'));
    }

    public function testEncode()
    {
        $xuid = new Xuid();
        $in = 'df49441e-ef4d-4886-90e2-c0b46d00df7c';
        $in = 'ffe25f31-907e-46c0-b2f8-8bbfedb9082b';
        //$uuid = $xuid->getUuid();
        $tmp = $xuid->encode($in);
        $out = $xuid->decode($tmp);
        
        $this->assertEquals($in, $out);
        //echo "$in->$tmp->$out";
    }

    public function testStatic()
    {
        $xuid = Xuid::getXuid();
        $this->assertTrue(Xuid::isValidXuid($xuid));
    }

    public function testFuzz()
    {
        $xuid = new Xuid();
        for ($i=0; $i<1000; $i++) {
            $in = Xuid::getUuid();
            $tmp = $xuid->encode($in);
            $out = $xuid->decode($tmp);
            $this->assertEquals($in, $out);
        }
    }

}
