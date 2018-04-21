<?php
/**
 * Created by PhpStorm.
 * User: Morphinof
 * Date: 21/04/2018
 * Time: 09:03
 */

namespace BulkImports\Entity;

use BulkImports\Traits\ContactTrait;
use BulkImports\Traits\CUDTrait;
use BulkImports\Traits\IdTrait;
use BulkImports\Traits\UuidTrait;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Contact
 *
 * @ORM\Entity(repositoryClass="BulkImports\Repository\ContactRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Contact
{
    const PREFIX = 'ct';

    use IdTrait;
    use UuidTrait;
    use ContactTrait;
    use CUDTrait;

    /**
     * @var User
     *
     * One Contact has One User.
     *
     * @ORM\OneToOne(targetEntity="BulkImports\Entity\User", inversedBy="contact", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @Assert\NotNull()
     */
    private $user;

    /**
     * @ORM\PrePersist
     */
    public function generateUuid()
    {
        $this->uuid = Uuid::uuid4();
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf('%s-%s', self::PREFIX, $this->uuid->toString());
    }
}