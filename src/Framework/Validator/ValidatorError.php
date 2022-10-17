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
        'intlenghtMin' => 'Le champ %s n\'atteint pas la valeur minimale',
        'intlenghtMax' => 'Le champ %s dépasse la valeur maximale autorisée',
        "strlenghtMin" => "Le champ %s n'atteint le nombre de caractères requis",
        "strlenghtMax" => "Le champ %s dépasse le nombre de caractères autorisés",
        'email' => 'Le champ %s doit être un email valide',
        'float' => 'Le champ %s doit être un nombre à virgule',
        'integer' => 'Le champ %s doit être un nombre entier',
        'confirm' => 'Le champ mot de passe et confirmation de mot de passe doivent être identiques'
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