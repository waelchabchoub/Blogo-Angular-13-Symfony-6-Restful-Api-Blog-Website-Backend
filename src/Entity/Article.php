<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ApiResource(
    attributes:["pagination_items_per_page"=>10],
    normalizationContext:['groups'=>['article.read']],
    denormalizationContext:['groups'=>['article.write']],
    itemOperations: [
        'get',
        'patch',
        'delete',
        'put' => [
            'denormalization_context' => ['groups' => ['article.put']],
        ],
    ],
),
ApiFilter(
    SearchFilter::class,
    properties:[
        'name' => SearchFilter::STRATEGY_PARTIAL,
    ]
    ),

]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['article.read','article.write','article.put'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['article.read','article.write','article.put'])]
    private $name;

    #[ORM\Column(type: 'text')]
    #[Groups(['article.read','article.write','article.put'])]
    private $content;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['article.read','article.write'])]
    private $author;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
