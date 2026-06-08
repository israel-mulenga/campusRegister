<?php

require_once __DIR__ . '/Model.php';

class ChatbotFAQ extends Model {
    protected $table = 'chatbot_faq';

    public function getAllKeywords() {
        return $this->findAll();
    }

    public function save(array $data) {
        $query = "INSERT INTO " . $this->table . " (motCle, reponse, categorie, dateCreation) VALUES (:motCle, :reponse, :categorie, NOW())";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'motCle' => $data['motCle'] ?? '',
            'reponse' => $data['reponse'] ?? '',
            'categorie' => $data['categorie'] ?? null,
        ]);
    }

    public function update($id, array $data) {
        $query = "UPDATE " . $this->table . " SET motCle = :motCle, reponse = :reponse, categorie = :categorie WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'id' => $id,
            'motCle' => $data['motCle'] ?? '',
            'reponse' => $data['reponse'] ?? '',
            'categorie' => $data['categorie'] ?? null,
        ]);
    }
}
