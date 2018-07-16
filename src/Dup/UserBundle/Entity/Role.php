<?php

namespace Dup\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Role
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Dup\UserBundle\Entity\RoleRepository")
 */
class Role
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Dup\UserBundle\Entity\Privilege", inversedBy="roles")
     */
    protected $privileges;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Dup\UserBundle\Entity\Role")
     */
    protected $subRoles;

    public function __construct(){
        $this->privileges = new ArrayCollection();
        $this->subRoles = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Role
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Role
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }


    /**
     * Add privilege
     *
     * @param \Dup\UserBundle\Entity\Privilege $privilege
     *
     * @return Role
     */
    public function addPrivilege(\Dup\UserBundle\Entity\Privilege $privilege)
    {
        $this->privileges[] = $privilege;

        return $this;
    }

    /**
     * Remove privilege
     *
     * @param \Dup\UserBundle\Entity\Privilege $privilege
     */
    public function removePrivilege(\Dup\UserBundle\Entity\Privilege $privilege)
    {
        $this->privileges->removeElement($privilege);
    }

    /**
     * Get privileges
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPrivileges()
    {
        return $this->privileges;
    }

    /**
     * Add subRole
     *
     * @param \Dup\UserBundle\Entity\Role $subRole
     *
     * @return Role
     */
    public function addSubRole(\Dup\UserBundle\Entity\Role $subRole)
    {
        $this->subRoles[] = $subRole;

        return $this;
    }

    /**
     * Remove subRole
     *
     * @param \Dup\UserBundle\Entity\Role $subRole
     */
    public function removeSubRole(\Dup\UserBundle\Entity\Role $subRole)
    {
        $this->subRoles->removeElement($subRole);
    }

    /**
     * Get subRoles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubRoles()
    {
        return $this->subRoles;
    }

    public function __toString(){
        return $this->code;
    }
}
