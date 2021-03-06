<?php


namespace tests\unit;

use app\models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function setUp(): void
    {
        User::deleteAll();
        \Yii::$app->db->createCommand()->insert(User::tableName(), [
            'username' => 'user',
            'email' => 'user@email.ru'
        ])->execute();
    }

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

    public function testValidateExistedValues()
    {
        $user = new User([
            'username' => 'user',
            'email' => 'user@email.ru'
        ]);
        $this->assertFalse($user->validate(), 'model is not valid');
        $this->assertArrayHasKey('username', $user->getErrors(), 'check existed username error');
        $this->assertArrayHasKey('email', $user->getErrors(), 'check existed email error');
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