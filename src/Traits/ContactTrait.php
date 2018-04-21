<?php
/**
 * Created by PhpStorm.
 * User: Morphinof
 * Date: 21/04/2018
 * Time: 09:16
 */

namespace BulkImports\Traits;

use BulkImports\Annotations\ExtractableAnnotation;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trait ContactTrait
 * @package BulkImports\Traits
 */
trait ContactTrait
{
    /**
     * Gender
     *
     * @var string $gender
     *
     * @ORM\Column(type="string", length=24, nullable=true)
     * @ExtractableAnnotation(columnIndex="4", columnName="Gender")
     */
    protected $gender;

    /**
     * First name
     *
     * @var string $firstName
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @ExtractableAnnotation(columnIndex="5", columnName="First name")
     */
    protected $firstName;
    /**
     * First name
     *
     * @var string $firstName
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @ExtractableAnnotation(columnIndex="6", columnName="Last name")
     */
    protected $lastName;

    /**
     * Email
     *
     * @var string $email
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     * @ExtractableAnnotation(columnIndex="7", columnName="Email")
     */
    protected $email;

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}