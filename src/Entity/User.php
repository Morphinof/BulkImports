<?php
/**
 * Created by PhpStorm.
 * User: Morphinof
 * Date: 21/04/2018
 * Time: 09:03
 */

namespace BulkImports\Entity;

use BulkImports\Annotations\ExtractableAnnotation;
use BulkImports\Traits\CUDTrait;
use BulkImports\Traits\IdTrait;
use BulkImports\Traits\UuidTrait;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * Class user
 *
 * @ORM\Entity(repositoryClass="BulkImports\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User
{
    const PREFIX = 'usr';

    use IdTrait;
    use UuidTrait;
    use CUDTrait;

    /**
     * One Customer has One Cart.
     *
     * @ExtractableAnnotation(columnIndex="3", columnName="Contact")
     * @ORM\OneToOne(targetEntity="BulkImports\Entity\Contact", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $contact;

    /**
     * @ORM\PrePersist
     */
    public function generateUuid()
    {
        $this->uuid = Uuid::uuid4();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf('%s-%s', self::PREFIX, $this->uuid->toString());
    }
}