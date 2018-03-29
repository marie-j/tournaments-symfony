<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TournamentRepository")
 * @ApiResource()
 */
class Tournament
{

    public function __construct()
    {
        $this->matches= new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string")
     */
    public $name;

    /**
     * @ORM\Column(type="datetime")
     */
    public $date;

    /**
     * @ORM\Column(type="string")
     */
    public $type;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Participant",cascade={"persist"})
     */
    public $participants;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Participant", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    public $winner;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Match",cascade={"remove"}, mappedBy="tournament")
     */
    public $matches;
}
