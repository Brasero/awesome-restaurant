<?php

namespace App\Framework\Toaster;

use App\Framework\Session\SessionInterface;

class Toaster
{
    private const SESSION_KEY = 'toast';

    const ERROR = 0;
    const SUCCESS = 1;
    const WARNING = 2;


    private SessionInterface $session;
    /**
     * @var Toast
     */
    private Toast $toast;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
        $this->session->start();
        $this->toast = new Toast();
    }

    public function createToast(string $message, int $etat): void
    {
        $toast = "";
        switch ($etat) {
            case 0:
                $toast = $this->toast->error($message);
                break;

            case 1:
                $toast = $this->toast->success($message);
                break;

            case 2:
                $toast = $this->toast->warning($message);
                break;
        }
        $this->session->set(self::SESSION_KEY, $toast);
    }

    public function renderToast(): string
    {
        $message = $this->session->get(self::SESSION_KEY);
        $this->session->delete(self::SESSION_KEY);
        return $message;
    }

    public function hasToast(): bool
    {
        if ($this->session->has(self::SESSION_KEY) && $this->session->get(self::SESSION_KEY) !== "") {
            return true;
        }
        return false;
    }
}
