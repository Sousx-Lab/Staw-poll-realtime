<?php

namespace App\Entity;

use Ramsey\Uuid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PollResponseRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PollResponseRepository::class)
 */
class PollResponse
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @Groups("poll_response")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=2, minMessage="Veuillez reformulez vos réponses , {{ limit }} caractères minimum", 
     *                max=50, maxMessage="Veuillez reformulez vos réponses, {{ limit }} caractères maximum")
     * @Groups("poll_response")
     */
    private $content;

    /**
     * @ORM\Column(type="integer")
     * @Groups("poll_response")
     */
    private $score = 0;

    /**
     * @ORM\ManyToOne(targetEntity=Poll::class, inversedBy="pollResponse")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("poll_target")
     */
    private $poll;

    public function __construct()
    {
        $this->id = Uuid::uuid4();

    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }
    
    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function incrementScore(): void
    {
        $this->score = $this->getScore() + 1;   
    }

    public function getPoll(): ?Poll
    {
        return $this->poll;
    }

    public function setPoll(?Poll $poll): self
    {
        $this->poll = $poll;

        return $this;
    }
}
