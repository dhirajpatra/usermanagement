<?php

use GuzzleHttp\Client;
use App\Domain\Model\Groupuser\Groupuser;
use App\Application\Service\GroupuserService;

class GroupuserControllerTest extends PHPUnit\Framework\TestCase
{

    private $http;
    private $groupuserMock;
    private $userid = 1;  // as per ORM fixture values
    private $groupid = 1;  // as per ORM fixture values


    public function setUp()
    {
        $this->http = new Client([
            'base_uri' => 'http://localhost:8000/api/',
            'http_errors' => false,
            'content-type' => 'application/json'
        ]);

        $this->groupuserMock = $this->getMockBuilder(GroupuserService::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function tearDown() {
        $this->http = null;
        $this->groupuserMock = null;
    }

    /**
     * this will test groupuser [user assigning to a group]
     */
    public function testAddAction()
    {

        $data = array(
            "userid" => $this->userid,
            "groupid" => $this->groupid
        );

        $response = $this->http->request(
            'POST',
            'groupuser',
            [
                'json' => $data
            ]
        );

        $this->assertEquals(200, $response->getStatusCode());
    }


    /**
     * This will test getGroupuserByGroup service method
     */
    public function testGetGroupuserByGroup()
    {
        $result = $this->groupuserMock
            ->expects($this->any())
            ->method('getGroupuserByGroup')
            ->with($this->groupid)
            ->willReturn(Groupuser::class);
        $this->assertInternalType('object', $result);
    }

    /**
     * This will test getGroupuserByGroup service method
     */
    public function testGetGroupuserByUser()
    {
        $result = $this->groupuserMock
            ->expects($this->any())
            ->method('getGroupuserByUser')
            ->with($this->userid)
            ->willReturn(Groupuser::class);
        $this->assertInternalType('object', $result);
    }

    /**
     * delete action
     */
    public function testDeleteAction()
    {

        $data = array(
            "userid" => $this->userid
        );

        $response = $this->http->request(
            'DELETE',
            'groupuser',
            [
                'json' => $data
            ]
        );

        $this->assertEquals(200, $response->getStatusCode());
    }

}