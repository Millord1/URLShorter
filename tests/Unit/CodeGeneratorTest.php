<?php

namespace Tests\Unit\Services;

use App\Services\CodeGenerator;
use PHPUnit\Framework\TestCase;

class CodeGeneratorTest extends TestCase
{

    public function test_base62_encode()
    {
        $generator = new CodeGenerator();

        $this->assertIsString($generator->encode(1));
        
        $this->assertEquals($generator->encode(12345), $generator->encode(12345));
        $this->assertNotEquals($generator->encode(1), $generator->encode(2));
    }

    public function test_handle_zero()
    {
        $generator = new CodeGenerator();
        $this->assertEquals('4', $generator->encode(0));
    }
}