<?php

namespace App\Entity;

use App\Repository\LolRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LolRepository::class)]
class Lol
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Space::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $lol;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLol(): ?Space
    {
        return $this->lol;
    }

    public function setLol(?Space $lol): self
    {
        $this->lol = $lol;

        return $this;
    }
}
