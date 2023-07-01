<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\PostTranslation;
use App\Repository\PostRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(ManagerRegistry $managerRegistry): Response
    {
        /** @var PostRepository $repository */
        $repository = $managerRegistry->getRepository(Post::class);

        $query = $repository
            ->createQueryBuilder('p')
            ->select('p', 'pt')
            ->join(PostTranslation::class, 'pt', Join::WITH, 'p.id = pt.post');

        $results = $query->setFirstResult(0)->setMaxResults(4)->getQuery()->getResult();

        return $this->render('base.html.twig', [
            'results' => $results
        ]);
    }
}
