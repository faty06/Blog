<?php


namespace App\Controller;

use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\throwException;

class TagController extends AbstractController
{
    /**
     * @Route("/tags", name="tags")
     */
    public function TagsBlog(TagRepository $tagRepository)
    {
        // récupérer tous les tags depuis la bdd
        $tags = $tagRepository->findAll();

        //dump('test'); die; => ici je test la function et Route
        return $this->render('tag/tagList.html.twig', [
            'tags' => $tags
        ]);
    }


    /**
     * @Route("/tags/{id}", name="tagShow")
     */
    public function Tagid($id, TagRepository $tagRepository) //l'autowire permet d'instancier (tipier = va recuperer l'intancier)
    {
        // récupérer tous les id dns la table tags depuis la bdd
        $tag = $tagRepository->find($id);

        //Si le tag n'existe pas => renvoie une error exception en affichant erreur 404
        if (is_null($tag)) {
            throw new NotFoundHttpException();
        };

        //dump('test'); die; => ici je test la function et Route
        return $this->render('tag/tagShow.html.twig', [
            'tag' => $tag
        ]);
    }
}