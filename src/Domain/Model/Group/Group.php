<?php

namespace App\Domain\Model\Group;

use App\Domain\Model\Groupuser\Groupuser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="groups", uniqueConstraints={@ORM\UniqueConstraint(name="groupname_UNIQUE", columns={"groupname"})})
 */
class Group {
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
     *
     */
    private $groupname;
    /**
     * @ORM\Column(type="smallint", length=1)
     * @Assert\NotBlank()
     */
    private $status;

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
     * @return string
     */
    public function getGroupname()
    {
        return $this->groupname;
    }

    /**
     * @param string $groupname
     */
    public function setGroupname($groupname)
    {
        if (\strlen($groupname) < 5) {
            throw new \InvalidArgumentException('Groupname needs to have more then 5 characters.');
        }

        if (\preg_match('/\s/',$groupname)) {
            throw new \InvalidArgumentException('Groupname no space.');
        }

        $this->groupname = $groupname;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    

}