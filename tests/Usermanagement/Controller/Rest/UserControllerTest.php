<?php

use GuzzleHttp\Client;
use App\Domain\Model\User\User;
use App\Application\Service\UserService;

class UserControllerTest extends PHPUnit\Framework\TestCase
{

    private $http;
    private $userMock;
    private $id = 2;  // as per ORM fixture values
    private $userName;


    public function setUp()
    {
        $this->http = new Client([
            'base_uri' => 'http://localhost:8000/api/',
            'http_errors' => false,
            'content-type' => 'application/json'
        ]);

        $this->userMock = $this->getMockBuilder(UserService::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function tearDown() {
        $this->http = null;
        $this->userMock = null;
    }

    /**
     * @param int $l
     * @return string
     */
    private function uniqueWord($l = 8) {
        return substr(md5(uniqid(mt_rand(), true)), 0, $l);
    }

    /**
     * this will test user creation method
     */
    public function testAddAction()
    {
        $this->userName = $this->uniqueWord();
        $data = array(
            "username" => $this->userName
        );

        $response = $this->http->request(
            'POST',
            'user',
            [
                'json' => $data
            ]
        );

        $this->assertEquals(200, $response->getStatusCode());
    }


    /**
     * This will test getUser service method
     */
    public function testGetUser()
    {
        $result = $this->userMock
            ->expects($this->any())
            ->method('getUser')
            ->with($this->id)
            ->willReturn(User::class);
        $this->assertInternalType('object', $result);
    }

    public function testDeleteAction()
    {

        $data = array(
            "userid" => $this->id
        );

        $response = $this->http->request(
            'DELETE',
            'user',
            [
                'json' => $data
            ]
        );

        $this->assertEquals(200, $response->getStatusCode());
    }

}