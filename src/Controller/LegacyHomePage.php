<?php

//± use 'strict'
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route("/")
 */
// $f = new HomePage()
class LegacyHomePage
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    // $f() -> "Hello world"
    public function __invoke(): Response
    {
        return new Response($this->twig->render('homepage.html.twig'));
    }
}