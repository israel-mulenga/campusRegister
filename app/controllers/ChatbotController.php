<?php

require_once __DIR__ . '/../models/ChatbotFAQ.php';

class ChatbotController {
    private $faqModel;

    public function __construct() {
        $this->faqModel = new ChatbotFAQ();
    }

    public function handleRequest() {
        header('Content-Type: application/json; charset=utf-8');

        $question = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['question'])) {
                $question = trim($_POST['question']);
            } else {
                $input = json_decode(file_get_contents('php://input'), true);
                if (isset($input['question'])) {
                    $question = trim($input['question']);
                }
            }
        }

        if ($question === '') {
            echo json_encode([
                'success' => false,
                'message' => 'Question vide ou format invalide. Veuillez saisir une question.'
            ]);
            return;
        }

        $answer = $this->analyzeQuestion($question);

        echo json_encode([
            'success' => true,
            'question' => $question,
            'answer' => $answer,
        ]);
    }

    private function analyzeQuestion($question) {
        $question = mb_strtolower($question, 'UTF-8');
        $entries = $this->faqModel->getAllKeywords();

        if (empty($entries)) {
            return 'Le chatbot n\'a pas encore de données de FAQ. Veuillez réessayer plus tard.';
        }

        $questionTokens = $this->tokenize($question);
        $best = null;
        $bestScore = 0;

        foreach ($entries as $entry) {
            $keywords = mb_strtolower($entry['motCle'], 'UTF-8');
            $score = $this->scoreMatch($questionTokens, $keywords);

            if ($score > $bestScore) {
                $bestScore = $score;
                $best = $entry;
            }
        }

        if ($bestScore === 0 || !$best) {
            return 'Désolé, je n\'ai pas trouvé de réponse correspondante. Reformulez votre question ou contactez l\'administration.';
        }

        return $best['reponse'];
    }

    private function tokenize($text) {
        $text = preg_replace('/[^\p{L}\p{N}\s]+/u', ' ', $text);
        $tokens = preg_split('/\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY);
        return $tokens ?: [];
    }

    private function scoreMatch(array $tokens, $keywordString) {
        $keywords = $this->tokenize($keywordString);
        $score = 0;

        foreach ($tokens as $token) {
            if (in_array($token, $keywords, true)) {
                $score++;
            }
        }

        return $score;
    }
}
