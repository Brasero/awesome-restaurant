<?php

namespace App\Admin;

interface AdminWidgetInterface
{
    public function render(): string;

    public function menuButtonAdmin(): string;

    public function menuButtonClient(): string;
}
