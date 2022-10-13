<?php

namespace App\Framework\Validator;

class ValidatorError
{
    /**
     * @var string
     */
    private string $key;

    /**
     * @var string
     */
    private string $rule;

    private array $messages = [
        'required' => 'Le champ %s est requis',
        'intlenght' => 'Le champ %s ne contient pas une valeur valide',
        "strlenght" => "Le champ %s dépasse le nombre de caractères autorisés",
        'email' => 'Le champ %s doit être un email valide'
    ];

    /**
     * @param string $key
     * @param string $rule
     */
    public function __construct(
        string $key,
        string $rule
    ) {
        $this->key = $key;
        $this->rule = $rule;
    }

    public function __toString(): string
    {
        return sprintf($this->messages[$this->rule], $this->key);
    }

    public function string(): string
    {
        return sprintf($this->messages[$this->rule], $this->key);
    }
}
