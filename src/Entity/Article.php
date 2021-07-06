<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 *creation de la table article
 * @ORM\Entity()
 */
class Article extends AbstractController
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
}