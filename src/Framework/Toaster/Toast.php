<?php

namespace App\Framework\Toaster;

class Toast
{
    public function success(string $message): string
    {
        return '<span class="success">
                            <span class="message">
                                '.$message.'
                            </span>
                            <span class="progressBar"></span>
                        </span>';
    }

    public function error(string $message): string
    {
        return '<span class="error">
                            <span class="message">
                                '.$message.'
                            </span>
                            <span class="progressBar"></span>
                        </span>';
    }

    
    public function warning(string $message): string
    {
        return '<span class="warning">
                            <span class="message">
                                '.$message.'
                            </span>
                            <span class="progressBar"></span>
                        </span>';
    }
}
