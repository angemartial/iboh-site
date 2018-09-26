<?php
/**
 * Created by PhpStorm.
 * User: Stefann
 * Date: 01/09/2017
 * Time: 01:02
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Listener\SaveByInterface;

/**
 * @ORM\MappedSuperclass
 * @ORM\EntityListeners({"AppBundle\Listener\SaveByListener"})
 */
class SuperClass implements SaveByInterface
{
    use SaveByTrait;
}