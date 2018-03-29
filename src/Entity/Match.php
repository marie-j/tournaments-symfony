<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MatchRepository")
 * @ApiResource()
 */
class Match
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="integer")
     */
    public $number;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Participant",cascade={"persist"})
     */
    public $participant1;

    /**
     * @ORM\Column(type="integer")
     */
    public $score1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Participant",cascade={"persist"})
     */
    public $participant2;

    /**
     * @ORM\Column(type="integer")
     */
    public $score2;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tournament",cascade={"persist"}, inversedBy="matches")
     */
    public $tournament;
}