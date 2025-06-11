<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    private Uuid $id;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $title;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $deadline = null;

    #[ORM\Column(length: 20)]
    #[Assert\Choice(['Oczekujący', 'Wykonany', 'Odrzucony'])]
    private string $status = 'Oczekujący';

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'subTasks')]
    private ?Task $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: Task::class, cascade: ['persist', 'remove'])]
    private Collection $subTasks;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->id = Uuid::v4();
        $this->subTasks = new ArrayCollection();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getDeadline(): ?\DateTimeInterface
    {
        return $this->deadline;
    }

    public function setDeadline(?\DateTimeInterface $deadline): self
    {
        $this->deadline = $deadline;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getSubTasks(): Collection
    {
        return $this->subTasks;
    }

    public function addSubTask(Task $subTask): self
    {
        if (!$this->subTasks->contains($subTask)) {
            $this->subTasks[] = $subTask;
            $subTask->setParent($this);
        }

        return $this;
    }

    public function removeSubTask(Task $subTask): self
    {
        if ($this->subTasks->removeElement($subTask)) {
            if ($subTask->getParent() === $this) {
                $subTask->setParent(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }
}
