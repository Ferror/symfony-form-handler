<?php
declare(strict_types=1);

namespace Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SymfonyController extends AbstractController
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function getSwiftMailer() : \Swift_Mailer
    {
        return $this->mailer;
    }
}
