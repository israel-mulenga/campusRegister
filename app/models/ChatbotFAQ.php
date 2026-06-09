<?php

require_once __DIR__ . '/Model.php';

class ChatbotFAQ extends Model {
    protected static $table = 'chatbot_faq';

    public function getAllKeywords() {
        return $this->findAll();
    }

    public function save(string $mot_cle, string $reponse, string $categorie): bool {
        $query = "INSERT INTO " . $this->table . " (mot_cle, reponse, categorie) VALUES (:mot_cle, :reponse, :categorie)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'mot_cle' => $data['mot_cle'] ?? '',
            'reponse' => $data['reponse'] ?? '',
            'categorie' => $data['categorie'] ?? null,
        ]);
    }

    public function update(int $id, string $mot_cle, string $reponse, string $categorie): bool {
        $query = "UPDATE " . $this->table . " SET mot_cle = :mot_cle, reponse = :reponse, categorie = :categorie WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'id' => $id,
            'mot_cle' => $data['mot_cle'] ?? '',
            'reponse' => $data['reponse'] ?? '',
            'categorie' => $data['categorie'] ?? null,
        ]);
    }

    public function search(string $question): ?string {
        $question = strtolower(trim($question));
        $question = preg_replace('/[^a-zA-ZÀ-ÿ\s]/u', ' ', $question);
        $mots     = array_filter(explode(' ', $question), fn($m) => strlen($m) > 2);

        if (empty($mots)) {
            return null;
        }

        $stopwords = ['les','des','une','que','qui','est','sur','par','pour','dans','avec','cette','sont','vous','nous','mais','aussi','plus','très','bien','tout','pas','oui','non','mon','ton','son','mes','tes','ses'];
        $mots = array_diff($mots, $stopwords);

        if (empty($mots)) {
            return null;
        }

        $rows     = $this->db->query("SELECT * FROM chatbot_faq")->fetchAll();
        $best     = null;
        $bestScore = 0;

        foreach ($rows as $row) {
            $keywords = strtolower($row['mot_cle']);
            $score    = 0;
            foreach ($mots as $mot) {
                if (str_contains($keywords, $mot)) {
                    $score++;
                }
            }
            $ratio = count($mots) > 0 ? $score / count($mots) : 0;
            if ($ratio > $bestScore) {
                $bestScore = $ratio;
                $best      = $row['reponse'];
            }
        }

        return $bestScore >= 0.3 ? $best : null;
    }
}
