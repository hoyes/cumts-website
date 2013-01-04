<?php

namespace Cumts\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\True;

class ContactController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('CumtsMainBundle:Contact:index.html.twig', array(
            'form' => $this->getForm()->createView()
        ));
    }

    public function contactAction()
    {
        $form = $this->getForm();
        $form->bind($this->getRequest());
        if ($form->isValid()) {
            $data = $form->getData();
            $to_email = $this->container->getParameter('contact_form_email');

            $message = \Swift_Message::newInstance()
                ->setSubject($data['subject'])
                ->setFrom($data['email'])
                ->setTo($to_email)
                ->setBody($data['body'])
            ;
            $this->get('mailer')->send($message);
            return $this->render('CumtsMainBundle:Contact:complete.html.twig', array());
        }
        else {
            return $this->render('CumtsMainBundle:Contact:index.html.twig', array(
                'form' => $form->createView()
            ));
        }
    }

    private function getForm()
    {
        return $this->createFormBuilder()
            ->add('name', 'text', array('label' => 'Your name', 'constraints' => array(new NotBlank())))
            ->add('email', 'email', array('label' => 'Your email address', 'constraints' => array(new Email(array('checkMX' => true)))))
            ->add('subject', 'text', array('label' => 'Subject', 'constraints' => array(new NotBlank())))
            ->add('body', 'textarea', array('label' => 'Message', 'constraints' => array(new NotBlank())))
            ->add('captcha', 'ewz_recaptcha', array(
                'label' => 'Please type the letters shown',
                'constraints'   => array(
                    new True()
                )
            ))
            ->getForm();
    }
}
