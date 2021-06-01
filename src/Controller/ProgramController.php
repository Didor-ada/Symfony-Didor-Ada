<?php

// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProgramController
 * @Route("/program" , name="program_")
 */
class ProgramController extends AbstractController
{
    /**
     * Show all rows from Program’s entity
     *
     * @Route("/", name="index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        return $this->render(
            'program/index.html.twig',
            ['programs' => $programs]
        );
    }

    /**
     * @Route("/{id}", requirements={"id"="\d+"}, methods={"GET"}, name="program_show")
     */
    public function show(Program $program, Season $season): Response
    {

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }
        $seasons = $program->getSeasons();
        return $this->render('program/show.html.twig', ['program'=>$program, 'seasons'=>$seasons]);
    }

    /**
     * @Route ("/{program}/season/{season}", name="season_show", methods={"GET"})
     */

    public function showSeason(Program $program, Season $season)
    {
        $seasons = $program->getSeasons();
        $episodes = $season->getEpisodes();
        return $this->render('Program/season_show.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
            'episodes' => $episodes
        ]);
    }

    /**
     * @param Program $program
     * @param Season $season
     * @param Episode $episode
     * @return Response
     * @Route ("/{program}/season/{season}/episode/{episode}", name="episode_show", methods={"GET"})
     */
    public function showEpisode (Program $program, Season $season, Episode $episode)
    {
        $seasons = $program->getSeasons();
        return $this->render('episodes/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
            'episodes' => $episode
        ]);
    }
}