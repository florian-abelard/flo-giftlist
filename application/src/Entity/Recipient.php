<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecipientRepository")
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get"}
 * )
 */
class Recipient
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("idea")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Group", inversedBy="members")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     * @Groups("idea")
     */
    private $group;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getGroup(): ?Group
    {
        return $this->group;
    }

    public function setGroup(?Group $group): self
    {
        $this->group = $group;

        return $this;
    }
}
