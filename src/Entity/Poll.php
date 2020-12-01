<?php

namespace App\Entity;

use App\Repository\PollRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass=PollRepository::class)
 */
class Poll
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @Groups("poll")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=2, minMessage="Au moin 2 caractère", max=100, maxMessage="Veuillez reformuler votre question, 100 caractère maximum")
     * @Groups("poll")
     */
    private string $title;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("poll")
     */
    private \DateTime $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=PollResponse::class, mappedBy="poll", orphanRemoval=true, cascade={"persist"})
     * @Groups("poll")
     */
    private $pollResponse;

    
    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->createdAt = new \DateTime();
        $this->pollResponse = new ArrayCollection();
    }

    public function getId(): ?string
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

    /**
     * @return Collection|PollResponse[]
     */
    public function getPollResponse(): ?Collection
    {
        return $this->pollResponse;
    }

    public function addPollResponse(PollResponse $pollResponse): self
    {
        if (!$this->pollResponse->contains($pollResponse)) {
            $this->pollResponse[] = $pollResponse;
            $pollResponse->setPoll($this);
        }

        return $this;
    }

    public function removePollResponse(PollResponse $pollResponse): self
    {
        if ($this->pollResponse->removeElement($pollResponse)) {
            // set the owning side to null (unless already changed)
            if ($pollResponse->getPoll() === $this) {
                $pollResponse->setPoll(null);
            }
        }

        return $this;
    }
}
