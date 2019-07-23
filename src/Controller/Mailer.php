<?php


namespace App\Controller;
use App\Entity\User;
use Twig\Environment;
use Swift_Mailer;
use Swift_Message;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;


class Mailer 
{

    private $mailer;
    private $templating;
    private $fromEmail;


    public function __construct(Swift_Mailer $mailer,Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->fromEmail = 'plantify.it.donotreply@gmail.com';
    }


    /**
     * @param $template
     * @param array $option
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    protected function setTemplate($template, array $option)
    {
        return $this->templating->render($template, $option);

    }

    /**
     * @param array $infoUser
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function  sendResettingEmailMessage(array $infoUser)
    {
        $subject = '[plantify.com] Réinitialisation de votre mot de passe';
        $body = $this->setTemplate(
            'Mailer/reset_password.html.twig',
            ['username' => $infoUser['username'], 'confirmationLink' => $infoUser['confirmationLink'], 'newPassword' => $infoUser['newPassword']]);
        $this->sendEmailMessage($infoUser['email'], $subject, $body);
    }

    /**
     * @param array $infoUser
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendInscriptionEmailMessage(array $infoUser)
    {
        $subject = 'Bienvenue sur plantify.com !';
        $body = $this->setTemplate('Mailer/reset_password.html.twig',
            ['firstLogin' => true, 'identifier' => $infoUser['identifier'],
                'link' => $infoUser['link']]);
        $this->sendEmailMessage($infoUser['email'], $subject, $body);
    }


    /**
     * @param User $user
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendFirstLoginEmailMessage(User $user)
     {
         $subject = 'Bienvenue sur plantify.com !';
         $body = $this->setTemplate('Mailer/first_login.html.twig',
             ['identifier' => $user->getFirstName().' '.$user->getLastName()]);
         $this->sendEmailMessage($user->getEmail(), $subject, $body);
     }


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

