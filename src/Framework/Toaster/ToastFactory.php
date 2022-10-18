<?php

namespace App\Framework\Toaster;

class ToastFactory
{

    private Toast $toast;

    public function __construct()
    {
        $this->toast = new Toast();
    }

    public function makeToast(string $message, int $etat): string
    {
        $toast = "";
        switch ($etat) {
            case 0:
                $toast = $this->error($message);
                break;

            case 1:
                $toast = $this->success($message);
                break;

            case 2:
                $toast = $this->warning($message);
                break;
        }
        return $toast;
    }

    private function error(string $message): string
    {
        return $this->toast->error($message);
    }

    private function success(string $message): string
    {
        return $this->toast->success($message);
    }

    private function warning(string $message): string
    {
        return $this->toast->warning($message);
    }
}
