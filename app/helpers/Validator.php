<?php

class Validator {
    private $errors = [];

    /**
     * Valide un tableau de données selon des règles de validation
     * @param array $data Les données à valider
     * @param array $rules Les règles de validation (ex: ['email' => 'required|email', 'password' => 'required|min:6'])
     * @return array|bool Retourne true si les données sont valides, sinon un tableau d'erreurs
     */
    public function validate(array $data, array $rules) {
        foreach ($rules as $field => $ruleString) {
            $rulesArray = explode('|', $ruleString);
            $value = isset($data[$field]) ? trim($data[$field]) : null;

            foreach ($rulesArray as $rule) {
                if ($rule === 'required' && (empty($value) && $value !== '0')) {
                    $this->errors[$field][] = "Le champ {$field} est obligatoire.";
                }

                if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->errors[$field][] = "L'adresse email n'est pas valide.";
                }

                if (strpos($rule, 'min:') === 0) {
                    $minLength = (int) substr($rule, 4);
                    if (!empty($value) && strlen($value) < $minLength) {
                        $this->errors[$field][] = "Le champ {$field} doit contenir au moins {$minLength} caractères.";
                    }
                }
            }
        }

        return empty($this->errors) ? true : $this->errors;
    }

    /**
     * Netoie les données d'entrée pour éviter les attaques XSS
     * @param string $data Les données à nettoyer
     * @return string Les données nettoyées
     */
    public static function sanitize($data) {
        if (is_array($data)) {
            return array_map([self::class, 'sanitize'], $data);
        }
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
}