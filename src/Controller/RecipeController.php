<?php

namespace App\Controller;
// use\App\Entity\Recipe;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\Json;

class RecipeController extends AbstractController
{
   
    #[Route('/recette', name: 'recipe.index')]
    public function index(Request $request, RecipeRepository $repository, EntityManagerInterface $em): Response
    {
      // dd($em->getRepository(Recipe::class));
       $recipes = $repository ->findWithDuration(20);
    //    dd($recipes);
    // $recipes[0]->setTitle('Pâtes bolognaise');
    // $em->flush();
    
    // pour ansere de donnees
    $recipe = new Recipe();
    // $recipe->setTitle('Barbe papa')
    //         ->setContent('Mettez du sucre')
    //         ->setDuration(2)
    //         ->setCreatedAt(new \DateTimeImmutable())
    //         ->setUpdatedAt(new \DateTimeImmutable());
    // $em->persist($recipe);
    

    // supprimer de base de donnees
    
    // $em->remove($recipes[0]);
    // $em->flush();
    
    

    
      return $this->render('recipe/index.html.twig',[
        'recipes'=>$recipes
      ]); 
        
    }
   
   
    #[Route('/recette/{slug}-{id}', name: 'recipe.show',requirements:['id'=>'\d+','slug'=>'[a-z0-9-]+'])]
    public function show(Request $request, string $slug, int $id, RecipeRepository $repository ): Response
    {
 Branche_collegue
        return $this->render('recipe/show.html.twig',[
        'slug'=>$slug,
        'id'=>$id,
        'person'=>[
            'firstame'=>'Mickael',
            'lastname'=>'shohag',
            'id'=>11,
            'formation'=>'Symfony',
          'conflict'=>'resolved'
        ]
       $recipe = $repository->find($id);
       if($recipe->getId() !== $id){
        return $this->redirectToRoute('recipe.show',['id'=>$recipe->getId()]); 
        
       }
       
        return $this->render('recipe/show.html.twig',[
        'recipe'=>$recipe
 main
        
        ]);
    }

    #[Route('/recette/{id}/edit', name:'recipe.edit')]
    
    public function edit(Recipe $recipe){
      $form = $this->createForm(RecipeType::class);
      
      return $this->render('recipe/index.html.twig',[
        'recipe'=>$recipe
      ]);
    }

    
}
