<?php

namespace App\Entity;

use App\Repository\ScoreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ScoreRepository::class)
 */
class Score
{

    /**
     * @ORM\Column(type="float")
     */
    private $score;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Student::class, inversedBy="scores")
     */
    private $student;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Subject::class, inversedBy="scores")
     */
    private $subject;


    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(float $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getSubject(): ?Subject
    {
        return $this->subject;
    }

    public function setSubject(?Subject $subject): self
    {
        $this->subject = $subject;

        return $this;
    }
}
