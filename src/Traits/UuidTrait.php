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
use Ramsey\Uuid\UuidInterface;

/**
 * Trait UuidTrait
 * @package BulkImports\Traits
 */
trait UuidTrait
{
    /**
     * @var UuidInterface
     *
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @ExtractableProperty(columnIndex="2", columnName="UUID")
     */
    private $uuid;

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    /**
     * @param \Ramsey\Uuid\UuidInterface $uuid
     */
    public function setUuid(UuidInterface $uuid): void
    {
        $this->uuid = $uuid;
    }
}