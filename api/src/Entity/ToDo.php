<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ToDoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    collectionOperations: ["get", "post"],
    itemOperations: [
        "get",
        "put" => [
            "security_post_denormalize" => "object.creator == user",
            "security_post_denormalize_message" => "Sorry, but you are not the actual ToDo owner.",
        ],
        "delete" => [
            "security_post_denormalize" => "object.creator == user",
            "security_post_denormalize_message" => "Sorry, but you are not the actual ToDo owner.",
        ],
        "patch" => [
            "security_post_denormalize" => "object.creator == user",
            "security_post_denormalize_message" => "Sorry, but you are not the actual ToDo owner.",
        ]
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'exact', 'creator' => 'exact'])]
#[ORM\Entity(repositoryClass: ToDoRepository::class)]
class ToDo
{
    use TimestampableEntity;

    #[Groups(["read", "write"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(["read", "write"])]
    #[ORM\Column(type: 'string', length: 50)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'toDo', targetEntity: Task::class, orphanRemoval: true)]
    private $tasks;

    #[Groups(["read", "write"])]
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'toDos')]
    #[ORM\JoinColumn(nullable: false)]
    public $creator;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

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

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setToDo($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getToDo() === $this) {
                $task->setToDo(null);
            }
        }

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }
}
