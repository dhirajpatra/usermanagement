<?php

namespace App\Domain\Model\Groupuser;

use App\Domain\Model\Group\Group;
use App\Domain\Model\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="groupusers")
 */
class Groupuser {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="integer", length=11)
     * @Assert\NotBlank()
     *
     */
    private $groupid;
    /**
     * @ORM\Column(type="integer", length=11)
     * @Assert\NotBlank()
     */
    private $userid;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="App\Domain\Model\Group\Group", inversedBy="groupusers")
     * @JoinColumn(name="groupid", referencedColumnName="id")
     *
     */
    private $groups;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="App\Domain\Model\User\User", inversedBy="groupusers")
     * @JoinColumn(name="userid", referencedColumnName="id")
     */
    private $users;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
        $this->users = new ArrayCollection();
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getGroupid()
    {
        return $this->groupid;
    }

    /**
     * @param int $groupid
     */
    public function setGroupid($groupid)
    {
        $this->groupid = $groupid;
    }

    /**
     * @return int
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param int $userid
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    }

    public function getGroup()
    {
        return $this->groups;
    }

    public function getUser()
    {
        return $this->users;
    }
}
