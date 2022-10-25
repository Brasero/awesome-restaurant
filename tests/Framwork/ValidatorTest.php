<?php

namespace Framwork;

use Framework\Validator\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{

    public function testRequireIfFailed()
    {
        $validator = new Validator([
            'name' => 'toto'
        ]);

        $validator->required('name', 'content');
        $this->assertCount(1, $validator->getErrors());
    }

    public function testRequireIfSuccess()
    {
        $validator = new Validator([
            'name' => 'toto'
        ]);

        $validator->required('name');
        $this->assertNull($validator->getErrors());
    }

    public function testLenghtIfFailed()
    {
        $validator = new Validator([
            'name' => 'toto'
        ]);

        $validator->lenght('name', 5, 10);
        $this->assertCount(1, $validator->getErrors());
    }

    public function testLenghtIfSuccess()
    {
        $validator = new Validator([
            'name' => 'toto'
        ]);

        $validator->lenght('name', 2, 10);
        $this->assertNull($validator->getErrors());
    }

    public function testLenghtIfSuccess2()
    {
        $validator = new Validator([
            'name' => 'toto'
        ]);

        $validator->lenght('name', 2, 4);
        $this->assertNull($validator->getErrors());
    }
}
