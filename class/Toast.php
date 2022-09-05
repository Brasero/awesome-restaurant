<?php

namespace Tool;

class Toast
{

    private string $toast;

    const ERROR = 0;
    const SUCCESS = 1;
    const WARNING = 2;

    public function __construct()
    {
        return $this;
    }

    public function createToast(string $message, int $etat): void
    {
        
        switch($etat){
            case 0:
                $this->toast = '<span class="error">
                                    <span class="message">
                                        '.$message.'
                                    </span>
                                    <span class="progressBar"></span>
                                </span>';
                break;

            case 1:
                $this->toast = '<span class="success">
                                    <span class="message">
                                        '.$message.'
                                    </span>
                                    <span class="progressBar"></span>
                                </span>';
                break;

            case 2:
                $this->toast = '<span class="warning">
                                    <span class="message">
                                        '.$message.'
                                    </span>
                                    <span class="progressBar"></span>
                                </span>';
                break;
        }
    }

    public function renderToast(): string
    {
        return $this->toast;
    }
}