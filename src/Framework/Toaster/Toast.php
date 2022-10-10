<?php

namespace App\Framework\Toaster;

class Toast
{
    public string $message = "";

    public function success(string $message): void
    {
        $this->message =  '<span class="success">
                            <span class="message">
                                '.$message.'
                            </span>
                            <span class="progressBar"></span>
                        </span>';
        $_SESSION['toast'] = $this->message;
    }

    public function error(string $message): void
    {
        $this->message = '<span class="error">
                            <span class="message">
                                '.$message.'
                            </span>
                            <span class="progressBar"></span>
                        </span>';
        $_SESSION['toast'] = $this->message;
    }

    
    public function warning(string $message): void
    {
        $this->message = '<span class="warning">
                            <span class="message">
                                '.$message.'
                            </span>
                            <span class="progressBar"></span>
                        </span>';
        $_SESSION['toast'] = $this->message;
    }
}
