<?php

namespace App\Controller;

use App\DTO\ContactMail;
use App\Form\ContactType;
use Exception;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name:'contact')]
    public function contact(Request $request, MailerInterface $mailer ): Response
    {
        $data = new ContactMail();
        
        $data->name= "shahin";
        $data->email= "shahin@gmail.com";
        $data->message= "super site";
      
        $form = $this->createForm(ContactType::class,$data);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
          
           try{

            $mail = (new TemplatedEmail())
            ->from($data->email)
            ->to($data->service)
            ->subject('Demand de contact')
            ->htmlTemplate('emails/contact.html.twig')
            ->context(['data'=>$data]);
            
               $mailer->send($mail);
               $this->addFlash('success','Email bien ete envoyer!!');
               return $this->redirectToRoute('contact');
            
           }catch(Exception $e){
                
               $this->addFlash('danger','Imposible  d\'envoyer Votre email' );
            }
           
        }
        
        return $this->render('contact/contact.html.twig', [
            'form'=>$form,
        ]);
    }
}
