<?php

namespace App\Controller;


use App\Entity\Classes;
use App\Entity\Cours;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/inscription")
     *
     */
    public function inscrire(Request $request, EntityManagerInterface $entityManager)
    {
        //On récupère les données envoyées par l'utilisateur
        $data = json_decode($request->getContent(), true);
        //On intègre les données dans des variables
        $nom = $data['user']['nom'];
        $email = $data['user']['email'];
        $prenom = $data['user']['prenom'];
        $password= $data['user']['password'];
        $classe= $data['user']['classe'];
        $statut= $data['user']['statut'];
        $matiere= $data['user']['matiere'];

        // On vérifie que les variables ne sont pas vides
        if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($password) && !empty($statut) ){
            //Si elles ne sont pas vide, on verifie que l'email n'est pas encore utilisé
            $repo = $entityManager->getRepository(User::class);
                if ($repo->findOneBy(['email' => $email])) {
                    $message = "L'email que vous avez renseigné est déja utilisé";
                    $etat = 'error';
                    $response = new JsonResponse(['message' => $message,'etat' => $etat ]);
                    return $response;
                }
                //Si l'email n'est pas utilisé on crée un new User
                $user = new User();
                $user->setNom($nom);
                $user->setPrenom($prenom);
                $user->setEmail($email);
                $user->setPassword($password);
                if(!empty($classe) && empty($matiere)){
                    $classeF = $entityManager->getRepository(Classes::class)->find($classe);
                    $user->setClasses($classeF);
                }
                if(!empty($matiere) && empty($classe)){
                    $cour = new Cours();
                    $cour->setLibelle($matiere);
                    $entityManager->persist($cour);
                    $entityManager->flush();
                    $user->setCours($cour);
                }
                    $user->setStatut($statut);


                    $entityManager->persist($user);
                    $entityManager->flush();

                    $message= 'Votre inscription a été prise en compte. Vous allez être redirigé vers la page de connexion.';
                    $etat= 'success';
                    $response = new JsonResponse(['message' => $message,'etat' => $etat ]);
                    return $response;

        }
        // Sinon
        else {
            $message = "L'un des champs est vide ! L'inscription ne peut pas être réalisée";
            $etat = 'error';
            $response = new JsonResponse(['message' => $message,'etat' => $etat ]);
            return $response;
        }

    }


    /**
     * @Route("/api/addclasse")
     *
     */
    public function addClasses(Request $request, EntityManagerInterface $entityManager)
    {

        //On récupère les données envoyées par l'utilisateur
        $data = json_decode($request->getContent(), true);
        $libelle = $data['classe']['libelle'];
        if (!empty($libelle)){
            $classe = new Classes();
            $classe->setLibelle($libelle);
            $entityManager->persist($classe);
            $entityManager->flush();

            $message= 'La classe '.$classe->getLibelle().' à été créée';
            $etat= 'success';
            $response = new JsonResponse(['message' => $message,'etat' => $etat ]);
            return $response;
        }
        else {
            $message = "Le champs libelle est vide ! L'ajout ne peut pas être fait";
            $etat = 'error';
            $response = new JsonResponse(['message' => $message,'etat' => $etat ]);
            return $response;
        }


    }

    /**
     * @Route("/api/getclasses")
     *
     */
    public function getClasses(EntityManagerInterface $entityManager)
    {
        $classes = $entityManager->getRepository(Classes::class)->findAll();
        $data = array();
        foreach ($classes as $key=> $value){
            $data[$key]['libelle'] = $value->getLibelle();
            $data[$key]['id'] = $value->getId();
        }

        $response = new JsonResponse($data);
        return $response;
    }

    /**
     * @Route("/api/deleteclasse/{id}")
     */
    public function deleteClasses($id, EntityManagerInterface $entityManager){
        $classe = $entityManager->getRepository(Classes::class)->find($id);
        $entityManager->remove($classe);
        $entityManager->flush();
        $message= 'La classe '.$classe->getLibelle().' à été supprimée';
        $etat= 'success';
        $response = new JsonResponse(['message' => $message,'etat' => $etat ]);
        return $response;
    }

    /**
     * @Route("/api/modifierclasse/{id}")
     */
    public function modifierclasse($id, EntityManagerInterface $entityManager, Request $request){
        $data = json_decode($request->getContent(), true);
        $libelle = $data['classe']['libelle'];
        $classe = $entityManager->getRepository(Classes::class)->find($id);

        if (!$classe) {
            $message = "La classe avec cet id n'a pas été trouvée";
            $etat = 'error';
            $response = new JsonResponse(['message' => $message,'etat' => $etat ]);
            return $response;
        }
        $classe->setLibelle($libelle);
        $entityManager->flush();
        $message = "La classe a été modifiée";
        $etat = 'success';
        $response = new JsonResponse(['message' => $message,'etat' => $etat ]);
        return $response;
    }

    /**
     * @Route("/api/modifiereleve/{id}")
     */
    public function modifiereleve($id, EntityManagerInterface $entityManager, Request $request){
        $data = json_decode($request->getContent(), true);
        $email = $data['eleve']['email'];
        $eleve = $entityManager->getRepository(User::class)->find($id);
        if (!empty($email)){$eleve->setEmail($email);}
        $entityManager->flush();
        $message = "L'eleve a été modifiée";
        $etat = 'success';
        $response = new JsonResponse(['message' => $message,'etat' => $etat ]);
        return $response;
    }

    /**
     * @Route("/api/geteleves/classe/{id}")
     */
    public function getElevesClasse($id, EntityManagerInterface $entityManager){

        $listeEleves = $entityManager->getRepository(User::class)->findBy(array('classes' => $id));

        $data = array();
        foreach ($listeEleves as $key=> $value){
            $data[$key]['nom'] = $value->getNom();
            $data[$key]['prenom'] = $value->getPrenom();
            $data[$key]['id'] = $value->getId();
            $data[$key]['email'] = $value->getEmail();
            $data[$key]['classes'] = $value->getClasses()->getLibelle();
        }

        $response = new JsonResponse($data);
        return $response;
    }




}
