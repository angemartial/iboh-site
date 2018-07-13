<?php
/**
 * Created by PhpStorm.
 * User: Eliket-Grp
 * Date: 24/06/2018
 * Time: 12:32
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Rental
 * @package Iboh\Model
 *
 * @ORM\Table(name="rental")
 * @ORM\Entity()
 */
class Rental
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
     * @var integer
     *
     * @ORM\Column(name="deposit", type="integer")
     */
    private $deposit;

    /**
     * @var integer
     *
     * @ORM\Column(name="advance", type="integer")
     */
    private $advance;

    /**
     * @var integer
     *
     * @ORM\Column(name="monthly", type="integer")
     */
    private $monthly;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Rental
     */
    public function setId(int $id): Rental
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getDeposit(): int
    {
        return $this->deposit;
    }

    /**
     * @param int $deposit
     * @return Rental
     */
    public function setDeposit(int $deposit): Rental
    {
        $this->deposit = $deposit;
        return $this;
    }

    /**
     * @return int
     */
    public function getAdvance(): int
    {
        return $this->advance;
    }

    /**
     * @param int $advance
     * @return Rental
     */
    public function setAdvance(int $advance): Rental
    {
        $this->advance = $advance;
        return $this;
    }

    /**
     * @return int
     */
    public function getMonthly(): int
    {
        return $this->monthly;
    }

    /**
     * @param int $monthly
     * @return Rental
     */
    public function setMonthly(int $monthly): Rental
    {
        $this->monthly = $monthly;
        return $this;
    }


}