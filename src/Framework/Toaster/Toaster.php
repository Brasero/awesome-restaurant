<?php

namespace App\Framework\Toaster;

use App\Framework\Session\SessionInterface;

class Toaster
{
    private const SESSION_KEY = 'toast[]';

    const ERROR = 0;
    const SUCCESS = 1;
    const WARNING = 2;


    private SessionInterface $session;
    /**
     * @var Toast
     */
    private Toast $toast;
    private ToastFactory $toastFactory;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
        $this->session->start();
        $this->toast = new Toast();
        $this->toastFactory = new ToastFactory();
    }

    public function createToast($message, int $etat): void
    {
        if (is_array($message)) {
            foreach ($message as $msg) {
                $this->session->setArray(self::SESSION_KEY, $this->toastFactory->makeToast($msg, $etat));
            }
        } else {
            $this->session->setArray(self::SESSION_KEY, $this->toastFactory->makeToast($message, $etat));
        }
    }

    public function renderToast()
    {
        $message = $this->session->get(self::SESSION_KEY);
        $this->session->delete(self::SESSION_KEY);
        return $message;
    }

    public function hasToast(): bool
    {
        if ($this->session->has(self::SESSION_KEY) && sizeof($this->session->get(self::SESSION_KEY)) > 0) {
            return true;
        }
        return false;
    }
}
