<?php

namespace Dup\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Dup\UserBundle\Entity\Role;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Dup\UserBundle\Entity\User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Dup\UserBundle\Entity\UserRepository")
 * @UniqueEntity(fields="email", message="Cette email existe déjà, choisissez une autre et rééssayez.")
 * @UniqueEntity(fields="username", message="Ce pseudo existe déjà, choisissez un autre et rééssayez.")
 * @ORM\EntityListeners({"Dup\UserBundle\Service\UserParamSetterListener"})
 */
class User extends BaseUser
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=50)
     */
    private $lastname = "";


    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname = "";


    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=50)
     */
    private $phone = "";

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=255, nullable=true)
     */
    private $statut = "";

    /**
     * @var boolean
     *
     * @ORM\Column(name="newsletter", type="boolean")
     */
    private $newsletter = false;
    
    /**
     * @var \DateTime $birthdate
     *
     * @ORM\Column(name="birthdate", type="datetime", nullable=true)
     */
    private $birthdate;
    
    /**
     * @var boolean $genre
     *
     * @ORM\Column(name="genre", type="boolean", nullable=true)
     */
    private $genre;
    
    
    /**
     * @var string $adresse
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    private $adresse;
    
    /**
     * @var \DateTime $lastActionDate
     *
     * @ORM\Column(name="lastactiondate", type="datetime", nullable=true)
     */
    protected $lastActionDate;
    
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Dup\UserBundle\Entity\Role")
     */
    protected $entityRoles;
    
    /**
     * Get id
     *
     * @return integer
     */
    public function getId ()
    {
        return $this -> id;
    }
    
    
    /**
     * Constructor
     */
    public function __construct ()
    {
        $this -> salt           = base_convert ( sha1 ( uniqid ( mt_rand (), true ) ), 16, 36 );
        $this -> enabled        = false;
        $this -> roles          = [];
        $this -> lastActionDate = new \DateTime();
    }
    
    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return User
     */
    public function setBirthdate ( $birthdate )
    {
        $this -> birthdate = $birthdate;
        
        return $this;
    }
    
    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate ()
    {
        return $this -> birthdate;
    }
    
    /**
     * Set genre
     *
     * @param boolean $genre
     *
     * @return User
     */
    public function setGenre ( $genre )
    {
        $this -> genre = $genre;
        
        return $this;
    }
    
    /**
     * Get genre
     *
     * @return boolean
     */
    public function getGenre ()
    {
        return $this -> genre;
    }
    
    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return User
     */
    public function setAdresse ( $adresse )
    {
        $this -> adresse = $adresse;
        
        return $this;
    }
    
    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse ()
    {
        return $this -> adresse;
    }
    
    /**
     * Set lastActionDate
     *
     * @param \DateTime $lastActionDate
     *
     * @return User
     */
    public function setLastActionDate ( $lastActionDate )
    {
        $this -> lastActionDate = $lastActionDate;
        
        return $this;
    }
    
    /**
     * Get lastActionDate
     *
     * @return \DateTime
     */
    public function getLastActionDate ()
    {
        return $this -> lastActionDate;
    }
    
    public function getDateWitness ()
    {
        $interval = new \DateInterval( 'PT' . UserRepository::MIN_UNACTIVE_PERIOD . 'S' );
        $now      = new \DateTime();
        
        return $now -> sub ( $interval );
    }
    
    public function isOffline ()
    {
        return $this -> getLastActionDate () <= $this -> getDateWitness ();
    }
    
    public function isOnline ()
    {
        return $this -> getLastActionDate () > $this -> getDateWitness ();
    }
    
    /**
     * Add entityRole
     *
     * @param Role $entityRole
     *
     * @return User
     */
    public function addEntityRole ( Role $entityRole )
    {
        $this -> entityRoles[] = $entityRole;
        
        return $this;
    }
    
    /**
     * Remove entityRole
     *
     * @param Role $entityRole
     */
    public function removeEntityRole ( Role $entityRole )
    {
        $this -> entityRoles -> removeElement ( $entityRole );
    }
    
    /**
     * Get entityRoles
     *
     * @return ArrayCollection
     */
    public function getEntityRoles ()
    {
        return $this -> entityRoles;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return User
     */
    public function setLastname(string $lastname): User
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return User
     */
    public function setFirstname(string $firstname): User
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return User
     */
    public function setPhone(string $phone): User
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return bool
     */
    public function isNewsletter(): bool
    {
        return $this->newsletter;
    }

    /**
     * @param bool $newsletter
     * @return User
     */
    public function setNewsletter(bool $newsletter): User
    {
        $this->newsletter = $newsletter;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * @param string $statut
     * @return User
     */
    public function setStatut(string $statut): User
    {
        $this->statut = $statut;
        return $this;
    }


}
