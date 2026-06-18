<?php

require_once __DIR__ . '/../models/ChatbotFAQ.php';

class ChatbotController {
   public function respond(): void {
        header('Content-Type: application/json; charset=utf-8');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['response' => 'Méthode non autorisée.']);
            return;
        }

        $raw  = file_get_contents('php://input');
        $body = json_decode($raw, true);

        if (!is_array($body)) {
            http_response_code(400);
            echo json_encode(['response' => 'Requête invalide : corps JSON malformé.']);
            return;
        }

        $question = trim($body['question'] ?? '');

        if (strlen($question) < 2) {
            echo json_encode(['response' => 'Veuillez poser une question.']);
            return;
        }

        try {
            $chatbotFaq = new ChatbotFAQ();
            $response   = $chatbotFaq->search($question);
        } catch (\Throwable $e) {
            error_log('Chatbot search error: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['response' => 'Une erreur interne est survenue. Veuillez réessayer.']);
            return;
        }

        if (!$response) {
            $response = "Je n'ai pas trouvé de réponse à votre question. 🤔\n\nPour une aide personnalisée, contactez-nous :\n📧 info@udbl.ac.cd\n📞 +243 810 000 000\n🕐 Lun-Ven 8h-16h | Sam 8h-12h";
        }

        echo json_encode(['response' => $response]);
    }
}
