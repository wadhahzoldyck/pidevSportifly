<?php

namespace App\Controller;

use App\Entity\User;
use http\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class ChatbotController extends AbstractController
{
    #[Route('/chatbot', name: 'app_chatbot')]
    public function chat(Request $request): Response
    {
        // Get the user ID from the request
        $userId = $request->get('user_id');

        // Get the user object from the database
        $user = $this->getDoctrine()->getRepository(User::class)->find($userId);

        // Create a new message for the chatbot
        $message = new Message($request->get('text'), $user);

        // Send the message to the chatbot service
        $this->get('app.chatbot')->sendMessage($message);

        // Return a JSON response indicating that the message has been sent
        return $this->json([
            'success' => true,
            'message' => 'Message sent'
        ]);
    }

}
