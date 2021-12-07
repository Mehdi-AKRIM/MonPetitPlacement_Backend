<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    collectionOperations: ["get","post"],
    itemOperations: [
        "get",
        "put" => [
            "security_post_denormalize" => "object.toDo.creator == user",
            "security_post_denormalize_message" => "Sorry, but you are not the actual Task owner.",
        ],
        "delete" => [
            "security_post_denormalize" => "object.toDo.creator == user",
            "security_post_denormalize_message" => "Sorry, but you are not the actual Task owner.",
        ],
        "patch" => [
            "security_post_denormalize" => "object.toDo.creator == user",
            "security_post_denormalize_message" => "Sorry, but you are not the actual Task owner.",
        ]
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['status' => 'exact', 'name' => 'exact'])]
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

    #[Groups(["read", "write"])]
    #[ORM\ManyToOne(targetEntity: ToDo::class, inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false)]
    public $toDo;

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
