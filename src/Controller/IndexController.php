<?php
namespace App\Controller;
use App\Entity\Stage;
use App\Repository\StageRepository;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class IndexController extends AbstractController
{
    private $repository;
    public function __construct(StageRepository $repository)
    {
        $this->repository=$repository;
    }
    /**
     * @Route("/", name="home")
     */
    public function index(PaginatorInterface $paginator , Request $request)
    {
        $stages=$paginator->paginate(
            $this->repository->findAllVisible(),
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('home.html.twig', array('stages' => $stages)) ; 

        
    }

    /**
     * @Route("/show/{id}", name="showstage")
     */
    public function show($id) {
        $stage = $this->getDoctrine()->getRepository(Stage::class)->find($id);
        return $this->render('show.html.twig', array('stage' => $stage)) ;
    }



}
