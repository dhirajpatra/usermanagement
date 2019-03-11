<?php

use GuzzleHttp\Client;
use App\Domain\Model\Group\Group;
use App\Application\Service\GroupService;

class GroupControllerTest extends PHPUnit\Framework\TestCase
{

    private $http;
    private $groupMock;
    private $id = 2;  // kindly change the groupid from your groups db table
    private $groupName;


    public function setUp()
    {
        $this->http = new Client([
            'base_uri' => 'http://localhost:8000/api/',
            'http_errors' => false,
            'content-type' => 'application/json'
        ]);

        $this->groupMock = $this->getMockBuilder(GroupService::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function tearDown() {
        $this->http = null;
        $this->groupMock = null;
    }

    /**
     * @param int $l
     * @return string
     */
    private function uniqueWord($l = 8) {
        return substr(md5(uniqid(mt_rand(), true)), 0, $l);
    }

    /**
     * this will test group creation method
     */
    public function testAddAction()
    {
        $this->groupName = $this->uniqueWord();
         $data = array(
            "groupname" => $this->groupName
        );

        $response = $this->http->request(
            'POST',
            'group',
            [
                'json' => $data
            ]
        );

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * This will test getGroupByName service method
     */
    public function testGetGroupByName()
    {
        $result = $this->groupMock
            ->expects($this->any())
            ->method('getGroupByName')
            ->with($this->groupName)
            ->willReturn(Group::class);
        $this->assertInternalType('object', $result);
    }

    /**
     * This will test getGroup service method
     */
    public function testGetGroup()
    {
        $result = $this->groupMock
            ->expects($this->any())
            ->method('getGroup')
            ->with($this->id)
            ->willReturn(Group::class);
        $this->assertInternalType('object', $result);
    }

    /**
     * delete action including check that any user associated with this group
     */
    public function testDeleteAction()
    {
//        global $argv, $argc;
//        $this->assertGreaterThan(2, $argc, 'No groupid passed');
//        $this->id = $argv[2];

        $data = array(
            "groupid" => $this->id
        );

        $response = $this->http->request(
            'DELETE',
            'group',
            [
                'json' => $data
            ]
        );

        $this->assertEquals(200, $response->getStatusCode());
    }

}