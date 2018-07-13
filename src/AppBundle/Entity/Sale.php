<?php
/**
 * Created by PhpStorm.
 * User: Eliket-Grp
 * Date: 24/06/2018
 * Time: 12:41
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Sale
 * @package Iboh\Model
 *
 * @ORM\Table(name="sale")
 * @ORM\Entity()
 */


class Sale
{
    /**
     * @var int Primary key of table
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue()
     *
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var boolean
     *
     * @ORM\Column(name="debate", type="boolean")
     */
    private $debate;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Sale
     */
    public function setId(int $id): Sale
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     * @return Sale
     */
    public function setPrice(int $price): Sale
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDebate(): bool
    {
        return $this->debate;
    }

    /**
     * @param bool $debate
     * @return Sale
     */
    public function setDebate(bool $debate): Sale
    {
        $this->debate = $debate;
        return $this;
    }


}