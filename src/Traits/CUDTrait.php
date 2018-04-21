<?php
/**
 * Created by PhpStorm.
 * User: Morphinof
 * Date: 16/12/2017
 * Time: 14:28
 */
declare(strict_types=1);

namespace BulkImports\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait CUDTrait (Aka Create Update Delete Trait)
 * @package BulkImports\Traits
 */
trait CUDTrait
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $updatedAt;

    /**
     * @var null|\DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $deletedAt;

    /**
     * Auto-update createdAt and updatedAt automatically
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function autoUpdate(): void
    {
        $this->setUpdatedAt(new \DateTime('now'));

        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return null|\DateTime
     */
    public function getDeletedAt(): ?\DateTime
    {
        return $this->deletedAt;
    }

    /**
     * @param mixed $deletedAt
     */
    public function setDeletedAt($deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }
}