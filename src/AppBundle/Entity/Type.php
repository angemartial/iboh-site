<?php
/**
 * Created by PhpStorm.
 * User: Eliket-Grp
 * Date: 24/06/2018
 * Time: 11:32
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Type
 * @package Iboh\Model
 *
 *  @ORM\Table(name="type")
 * @ORM\Entity()
 */
class Type
{
    /**
     * /**
     * @var int Primary key of the table
     *
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Type
     */
    public function setId(int $id): Type
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Type
     */
    public function setTitle(string $title): Type
    {
        $this->title = $title;
        return $this;
    }


}