<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Index(columns: ["key"])]
#[ORM\UniqueConstraint(columns: ["group_id", "key"])]
class Variable implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true, nullable: false)]
    private Uuid $id;

    #[ORM\ManyToOne(targetEntity: Space::class)]
    #[ORM\Column(name: "group_id", nullable: true)]
    private ?Space $space;

    #[ORM\Column(name: "key", type: Types::STRING, length: 255, nullable: false)]
    private string $key;

    #[ORM\Column(type: Types::STRING, length: 2048, nullable: false)]
    private string $value;

    public function __construct(string $key, string $value, ?Space $space = null)
    {
        $this->id = Uuid::v4();
        $this->key = $key;
        $this->value = $value;
        $this->space = $space;
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

    public function getSpace(): ?Space
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

