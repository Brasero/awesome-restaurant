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
        'email' => 'Le champ %s doit être un email valide',
        'float' => 'Le champ %s doit être un nombre à virgule',
        'integer' => 'Le champ %s doit être un nombre entier',
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


    public function toString(): string
    {
        return sprintf($this->messages[$this->rule], $this->key);
    }
}
