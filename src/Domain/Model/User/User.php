<?php

namespace App\Domain\Model\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @package App\Domain\Model\User
 */
class User {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank()
     *
     */
    private $username;
    /**
     * @ORM\Column(type="smallint", length=1)
     * @Assert\NotBlank()
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="App\Domain\Model\Groupuser\Groupuser", mappedBy="groups")
     */
    private $groupuser;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->groupuser = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername() : string
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername(string $username) : void
    {
        if (\strlen($username) < 5) {
            throw new \InvalidArgumentException('Username needs to have more then 5 characters.');
        }

        if (\preg_match('/\s/',$username)) {
            throw new \InvalidArgumentException('Username no space.');
        }

        $this->username = $username;
    }

    /**
     * @return int
     */
    public function getStatus() : int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status) : void
    {
        $this->status = $status;
    }

    /**
     * @return Collection
     */
    public function getGroupuser(): Collection
    {
        return $this->groupuser;
    }
}