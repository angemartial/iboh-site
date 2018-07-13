<?php
/**
 * Created by PhpStorm.
 * User: Eliket-Grp
 * Date: 22/06/2018
 * Time: 15:02
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Location
 * @package Iboh\Model
 *
 * @ORM\Table(name="location")
 * @ORM\Entity()
 */
class Location
{
    /**
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
     * @return Location
     */
    public function setId(int $id): Location
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
     * @return Location
     */
    public function setTitle(string $title): Location
    {
        $this->title = $title;
        return $this;
    }


}
