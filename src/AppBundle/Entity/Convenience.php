<?php
/**
 * Created by PhpStorm.
 * User: Eliket-Grp
 * Date: 24/06/2018
 * Time: 11:18
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Convenience
 * @package Iboh\Model
 *
 * @ORM\Table(name="convenience")
 * @ORM\Entity()
 */
class Convenience
{
    /**
     * @var int Primary key of the table
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
     * @return Convenience
     */
    public function setId(int $id): Convenience
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
     * @return Convenience
     */
    public function setTitle(string $title): Convenience
    {
        $this->title = $title;
        return $this;
    }

}