<?php

namespace App\Framework\Validator;

class Validator
{

    /**
     * @var array
     */
    private array $params;

    /**
     * @var array
     */
    private array $errors;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Assure qu'un champ a été rempli
     * @param string ...$keys clés du tableau
     * @return $this
     */
    public function required(string ...$keys): self
    {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $this->params) || $this->params[$key] === '') {
                $this->addError($key, 'required');
            }
        }

        return $this;
    }

    /**
     * Assure que la valeur d'un champ est un email
     * @param string $key clé du champ
     * @return $this
     */
    public function email(string $key): self
    {
        if (!filter_var($this->params[$key], FILTER_VALIDATE_EMAIL)) {
            $this->addError($key, 'email');
        }

        return $this;
    }

    /**
     * Assure que la taille d'un champ est comprise entre 2 valeurs
     * @param string $key clé du champ
     * @param int $min taille minimale
     * @param int $max taille maximale
     * @return $this
     */
    public function strLength(string $key, int $min, int $max): self
    {
        if (!array_key_exists($key, $this->params)) {
            return $this;
        }
        $lenght = mb_strlen($this->params[$key]);
        if ($lenght < $min) {
            $this->addError($key, 'strlenghtMin');
        }
        if ($lenght > $max) {
            $this->addError($key, 'strlenghtMax');
        }
        return $this;
    }

    public function intLength(string $key, int $min, int $max): self
    {
        if (!array_key_exists($key, $this->params)) {
            return $this;
        }
        $lenght = $this->params[$key];
        if ($lenght < $min) {
            $this->addError($key, 'intlenghtMin');
        }
        if ($lenght > $max) {
            $this->addError($key, 'intlenghtMax');
        }
        return $this;
    }


    /**
     * Assure que la valeur du est valide pour être utilisé dans une URL
     * @param string $key clé du champ
     * @return $this
     */
    public function slug(string $key): self
    {
        if (!preg_match('/^[a-z\-0-9]+$/', $this->params[$key])) {
            $this->addError($key, 'slug');
        }
        return $this;
    }

    /**
     * Assure que la valeur du champ est un entier
     * @param string $key clé du champ
     * @return $this
     */
    public function integer(string $key): self
    {
        if (!filter_var($this->params[$key], FILTER_VALIDATE_INT)) {
            $this->addError($key, 'integer');
        }
        return $this;
    }

    /**
     * Assure que la valeur du champ est un float
     * @param string $key clé du champ
     * @return $this
     */
    public function float(string $key): self
    {
        $this->params[$key] = floatval($this->params[$key]);
        if (!filter_var($this->params[$key], FILTER_VALIDATE_FLOAT)) {
            $this->addError($key, 'float');
        }
        return $this;
    }

    public function confirm(string $key): self
    {
        $confirm = $key . '_confirm';
        if (!array_key_exists($key, $this->params) or !array_key_exists($confirm, $this->params)) {
            return $this;
        }
        if ($this->params[$key] !== $this->params[$confirm]) {
            $this->addError($key, 'confirm');
        }
        return $this;
    }


    /**
     * Retourne le tableau des erreurs de validation, sinon retourne null
     * @return array|null
     */
    public function getErrors(): ?array
    {
        return $this->errors ?? null;
    }

    /**
     * Ajoute une erreur au tableau des erreurs
     * @param string $key clé du champ
     * @param string $rule règle de validation
     */
    private function addError(string $key, string $rule): void
    {
        if (!isset($this->errors[$key])) {
            $this->errors[$key] = [];
        }
        $this->errors[$key][] = new ValidatorError($key, $rule);
    }
}
