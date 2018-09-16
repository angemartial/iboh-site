<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PasswordResetToken
 *
 * @ORM\Table(name="password_reset_token")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PasswordResetTokenRepository")
 */
class PasswordResetToken
{


    public function __construct(\Dup\UserBundle\Entity\User $user)
    {
        $this->user = $user;
        $this->date = new \DateTime();
        $this->token = hash ( 'sha512', uniqid($user->getUsernameCanonical()));
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255)
     */
    private $token;


    /**
     * @var \Dup\UserBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="Dup\UserBundle\Entity\User")
     */
    private $user;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return PasswordResetToken
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return PasswordResetToken
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return \Dup\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \Dup\UserBundle\Entity\User $user
     * @return PasswordResetToken
     */
    public function setUser(\Dup\UserBundle\Entity\User $user)
    {
        $this->user = $user;
        return $this;
    }


    public function __toString()
    {
        return $this->token;
    }

}

