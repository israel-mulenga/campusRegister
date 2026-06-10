<?php

require_once __DIR__ . '/Model.php';

class ChatbotFaq extends Model {
    protected static $table = 'chatbot_faq';

    public static function getAllKeywords(): array {
        return self::findAll();
    }

    public static function save(string $mot_cle, string $reponse, string $categorie): bool {
        $db = self::getDb();
        $stmt = $db->prepare("INSERT INTO chatbot_faq (mot_cle, reponse, categorie) VALUES (?,?,?)");
        return $stmt->execute([$mot_cle, $reponse, $categorie]);
    }

    public static function update(int $id, string $mot_cle, string $reponse, string $categorie): bool {
        $db = self::getDb();
        $stmt = $db->prepare("UPDATE chatbot_faq SET mot_cle=?, reponse=?, categorie=? WHERE id=?");
        return $stmt->execute([$mot_cle, $reponse, $categorie, $id]);
    }

    public static function delete(int $id): bool {
        return self::deleteById($id);
    }

    public static function search(string $question): ?string {
        $question = strtolower(trim($question));
        $question = preg_replace('/[^a-zA-ZÀ-ÿ\s]/u', ' ', $question);
        $mots = array_filter(explode(' ', $question), fn($m) => strlen($m) > 2);
        if (empty($mots)) return null;

        $stopwords = ['les','des','une','que','qui','est','sur','par','pour','dans','avec','cette','sont','vous','nous','mais','aussi','plus','très','bien','tout','pas','oui','non'];
        $mots = array_values(array_diff($mots, $stopwords));
        if (empty($mots)) return null;

        $db = self::getDb();
        $rows = $db->query("SELECT * FROM chatbot_faq")->fetchAll(PDO::FETCH_ASSOC);
        $best = null; $bestScore = 0;

        foreach ($rows as $row) {
            $keywords = strtolower($row['mot_cle']);
            $score = 0;
            foreach ($mots as $mot) {
                if (str_contains($keywords, $mot)) $score++;
            }
            $ratio = count($mots) > 0 ? $score / count($mots) : 0;
            if ($ratio > $bestScore) { $bestScore = $ratio; $best = $row['reponse']; }
        }
        return $bestScore >= 0.3 ? $best : null;
    }
}
