<?php

namespace App\Controller;

use App\Entity\Joueurs;
use App\Form\JoueurType;
use App\Repository\JeuxRepository;
use App\Repository\JoueursRepository;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class JeuxController extends AbstractController
{
    #[Route('/jeux', name: 'app_jeux')]
    public function index(JeuxRepository $jeuxRepository): Response
    {

        $jeux = $jeuxRepository->findAll();
        // dd($jeux);

        return $this->render('jeux/index.html.twig', [
            "jeux" => $jeux
        ]);
    }
    #[Route('/joueurs', name: 'joueurs')]
    public function ajoutJoueur(Request $requete, ManagerRegistry $manager)
    {
        $joueurs = new Joueurs();

        $formulaire = $this->createForm(JoueurType::class, $joueurs);
        $formulaire->handleRequest($requete);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {

            $imageFile = $formulaire->get('avatar')->getData();
            if ($imageFile) {
                // $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // dd($originalFilename);
                // $safeFileName = $slugger->slug($originalFilename);
                $newFilename = "avatar" . uniqid() . "." . $imageFile->guessExtension();

                try {
                    $imageFile->move($this->getParameter('dossierJeu'), $newFilename);
                } catch (FileException $e) {
                    $e->getMessage();
                }
            }

            $joueurs->setAvatar($newFilename);
            $OM = $manager->getManager();
            $OM->persist($joueurs);
            $OM->flush();
            return $this->redirectToRoute('afficherjoueur');
        }

        return $this->render('jeux/ajoutjour.html.twig', [
            "formulaire" => $formulaire->createView()
        ]);
    }

    #[Route('/afficherjoueur', name: "afficherjoueur")]
    public function afficherJoueur(JoueursRepository $joueursRepository)
    {

        $joueurs = $joueursRepository->findAll();
        return $this->render("jeux/afficherjoueur.html.twig", [
            "joueurs" => $joueurs
        ]);
    }
}
