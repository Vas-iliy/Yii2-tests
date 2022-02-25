<?php

namespace tests;

use app\models\User;

require(__DIR__ . '/_bootstrap.php');

class UserTest extends TestCase
{
    public function testValidateEmptyValues()
    {
        $user = new User();
        $this->assertFalse($user->validate(), 'model is not valid');
        $this->assertArrayHasKey('username', $user->getErrors(), 'check username error');
        $this->assertArrayHasKey('email', $user->getErrors(), 'check email error');
    }

    public function testValidateWrongValues()
    {
        $user = new User([
            'username' => 'username :(',
            'email' => 'email',
        ]);
        $this->assertFalse($user->validate(), 'validate incorrect username and email');
        $this->assertArrayHasKey('username', $user->getErrors(), 'check incorrect username error');
        $this->assertArrayHasKey('email', $user->getErrors(), 'check incorrect email error');
    }

    public function testValidateCorrectValues()
    {
        $user = new User([
            'username' => 'username',
            'email' => 'email@email.ru',
        ]);
        $this->assertTrue($user->validate(), 'correct model is valid');
    }

    public function testSaveIntoDatabase()
    {
        $user = new User([
            'username' => 'username',
            'email' => 'email@email.ru'
        ]);

        $this->assertTrue($user->save(), 'model is saved');
    }
}

$class = new \ReflectionClass('\tests\UserTest');
foreach ($class->getMethods() as $method) {
    if (substr($method->name, 0, 4) == 'test') {
        echo 'Test ' . $method->class . '::' . $method->name . PHP_EOL . PHP_EOL;
        $test = new $method->class;
        $test->{$method->name}();
        echo PHP_EOL;
    }
}