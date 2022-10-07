<?php

namespace App\Framework\Toaster;

class Toaster
{

    /**
     * @var Toast
     */
    private Toast $toast;

    const ERROR = 0;
    const SUCCESS = 1;
    const WARNING = 2;

    public function __construct()
    {
        session_start();
        $this->toast = new Toast();
    }

    public function createToast(string $message, int $etat): void
    {
        switch ($etat) {
            case 0:
                $this->toast->error($message);
                break;

            case 1:
                $this->toast->success($message);
                break;

            case 2:
                $this->toast->warning($message);
                break;
        }
    }

    public function renderToast(): string
    {
        $message = $_SESSION['toast'];
        unset($_SESSION['toast']);
        return $message;
    }

    public function hasToast(): bool
    {
        if (isset($_SESSION['toast']) && !empty($_SESSION['toast'])) {
            return true;
        }
        return false;
    }
}
