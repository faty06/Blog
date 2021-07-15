<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArticleRepository;


/**
 *creation de la table article
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    //Je cree le champ id il faut de tjr declarer la variable
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     * Declaration id en auto increment (unique) et null
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * Methode
     * @ORM\Column(type="boolean")
     */
    private $isPulished;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="articles") //inverseBy =>
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tag", inversedBy="articles") //inverseBy =>
     */
    private $tag;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * @param mixed $createAt
     */
    public function setCreateAt($createAt): void
    {
        $this->createAt = $createAt;
    }

    /**
     * @return mixed
     */
    public function getIsPulished()
    {
        return $this->isPulished;
    }

    /**
     * @param mixed $isPulished
     */
    public function setIsPulished($isPulished): void
    {
        $this->isPulished = $isPulished;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $Category
     */
    public function setCategory($Category): void
    {
        $this->Category = $Category;
    }

    /**
     * @return mixed
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param mixed $tag
     */
    public function setTag($tag): void
    {
        $this->tag = $tag;
    }



}