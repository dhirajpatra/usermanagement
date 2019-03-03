<?php

namespace App\Domain\Model\Groupuser;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
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
     *
     * @ORM\Column(type="integer", length=11)
     * @ORM\ManyToOne(targetEntity="App\Domain\Model\Group\Group", inversedBy="groupusers")
     * @Assert\NotBlank()
     *
     */
    private $groupid;
    /**
     * @ORM\Column(type="integer", length=11)
     * @ORM\ManyToOne(targetEntity="App\Domain\Model\User\User", inversedBy="groupusers")
     * @Assert\NotBlank()
     */
    private $userid;

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

    public function getGroup(): ?Group
    {
        return $this->groupid;
    }

    public function getUser(): ?User
    {
        return $this->userid;
    }

}