<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
)]
#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    const STATE_CREATED = 'CREATED';
    const STATE_INPROGRESS = 'INPROGRESS';
    const STATE_CLOSED = 'CLOSED';

    use TimestampableEntity;

    #[Groups(["read", "write"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(["read", "write"])]
    #[ORM\Column(type: 'string', length: 50)]
    private $name;

    #[Groups(["read", "write"])]
    #[ORM\Column(type: 'string', length: 20)]
    private $status;

    #[ORM\ManyToOne(targetEntity: ToDo::class, inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false)]
    private $toDo;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getToDo(): ?ToDo
    {
        return $this->toDo;
    }

    public function setToDo(?ToDo $toDo): self
    {
        $this->toDo = $toDo;

        return $this;
    }
}
