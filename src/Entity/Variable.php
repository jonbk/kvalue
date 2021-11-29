<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Index(columns: ["key"])]
#[ORM\UniqueConstraint(columns: ["space_id", "key"])]
class Variable implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true, nullable: false)]
    private Uuid $id;

    #[ORM\ManyToOne(targetEntity: Space::class)]
    #[ORM\JoinColumn(name: "space_id", nullable: false)]
    private Space $space;

    #[ORM\Column(name: "key", type: Types::STRING, length: 255, nullable: false)]
    private string $key;

    #[ORM\Column(type: Types::STRING, length: 4096, nullable: false)]
    private string $value;

    public function __construct(Space $space, string $key, string $value)
    {
        $this->id = Uuid::v4();
        $this->space = $space;
        $this->key = $key;
        $this->value = $value;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getSpace(): Space
    {
        return $this->space;
    }

    public function setKey(string $key): Variable
    {
        $this->key = $key;

        return $this;
    }

    public function setValue(string $value): Variable
    {
        $this->value = $value;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'key' => $this->key,
            'value' => $this->value,
        ];
    }
}

