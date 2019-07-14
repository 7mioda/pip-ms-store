<?php


namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Swift_Mailer;
use Swift_Message;


class Mailer 
{

    private $mailer;
    private $templating;
    private $fromEmail;


    public function __construct(Swift_Mailer $mailer, \Twig_Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->fromEmail = 'plantify.it.donotreply@gmail.com';
    }


    protected function setTemplate($template, array $option)
    {

        return $this->templating->render($template, $option);
    }

    public function sendResettingEmailMessage(array $infoUser)
    {
        $subject = '[plantify.com] Réinitialisation de votre mot de passe';
        $body = $this->setTemplate('Mailer/reset_password.html.twig', array('username' => 'amed eddaly', 'confirmationLink' => 'this is test below', 'isfirstLogin' => false));
        $this->sendEmailMessage('mmekni.a.amine@gmail.com', $subject, $body);
    }


    // public function sendFirstLoginEmailMessage(array $infoUser)
    // {
    //     $subject = 'Bienvenue sur plantify.com !';
    //     $body = $this->setTemplate('Mailer/reset_password.html.twig', array('isfirstLogin' => true, 'identifiant' => $infoUser['identifiant'],'link' => $infoUser['link']));
    //     $this->sendEmailMessage('mmekni.a.amine@gmail.com', $subject, $body);
    // }


    protected function sendEmailMessage($toEmail, $subject, $body)
    {
        $message = (new Swift_Message('Hello Email'))
            ->setSubject($subject)
            ->setFrom($this->fromEmail)
            ->setTo($toEmail)
            ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }

}

