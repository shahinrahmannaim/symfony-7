<?php 
namespace App\Controller\API;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
// use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RecipesController extends AbstractController{

    


    #[Route('/api/recette',methods:['GET','POST'])]
    public function index(Request $request, RecipeRepository $repository): JsonResponse
    {
        $recipes = $repository->findAll();
        $data = [];

        foreach ($recipes as $recipe) {
            $data[] = [
                'id' => $recipe->getId(),
                'title' => $recipe->getTitle(),
                'createdAt' => $recipe->getCreatedAt(),
                'updatedAt' => $recipe->getUpdatedAt(),
                'duration' => $recipe->getDuration(),
                'content' => $recipe->getContent()
            ];
        }
        
        
       
        
        return $this->json($data);
        
        
    }

    
    
    #[Route('/api/recette/create', methods:['GET','POST'])]

    public function create(Request $request, EntityManagerInterface  $em):JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
            $recipe = new Recipe();
            $recipe->setTitle($data['title']);
            
            $recipe->setDuration($data['duration']);
            $recipe->setContent($data['content']);
            
            // $form = $this->createForm(RecipeType::class,$recipe);
            // $form->handleRequest($request);  
            
            // if($form->isSubmitted() && $form->isValid()){
              $em->persist($recipe);
              $em->flush();
              
              
            // }
            
            return new JsonResponse("success");
    }




}