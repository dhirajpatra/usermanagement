<?php

namespace App\Domain\Model\User;

use App\Domain\Model\Groupuser\Groupuser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 * @ORM\Entity
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="username_UNIQUE", columns={"username"})})
 * @package App\Domain\Model\User
 */
class User {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $username;
    /**
     * @ORM\Column(type="smallint", length=1)
     * @Assert\NotBlank()
     */
    private $status;

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


}