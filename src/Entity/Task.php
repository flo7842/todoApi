<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @ApiResource(
 *   attributes={
 *     "pagination_items_per_page"=10
 *   },
 *   normalizationContext={"groups"={"task_read"}},

 * )
 * @ApiFilter(BooleanFilter::class, properties={"status"})
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Your name cannot contain a number"
     * )
     * @Assert\Length( 
     *      min = 3,
     *      max = 50,
     *      minMessage = "Le titre de la tâche doit faire plus de 3 caractères",
     *      maxMessage = "Le titre de la tâche ne doit pas faire plus de 50 caractères"
     * )
     * @Groups({"user_read"})
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"user_read"})
     */
    private $status = false;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastModified;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tasks", cascade={"persist"})
     */
    private $userTask;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function prePersist(){
        if(empty($this->createdAt)){
            $this->createdAt = new \DateTime();
        }
    }

    public function getLastModified(): ?\DateTimeInterface
    {
        return $this->lastModified;
    }

    public function setLastModified(?\DateTimeInterface $lastModified): self
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    public function getUserTask(): ?User
    {
        return $this->userTask;
    }

    public function setUserTask(?User $userTask): self
    {
        $this->userTask = $userTask;

        return $this;
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}
