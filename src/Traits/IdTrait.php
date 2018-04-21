<?php
/**
 * Created by PhpStorm.
 * User: Morphinof
 * Date: 21/04/2018
 * Time: 09:16
 */

namespace BulkImports\Traits;

use BulkImports\Annotations\ExtractableProperty;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trait IdTrait
 * @package BulkImports\Traits
 */
trait IdTrait
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @ExtractableProperty(columnIndex="1", columnName="ID")
     */
    protected $id;

    public function getId(): int
    {
        return $this->id;
    }
}