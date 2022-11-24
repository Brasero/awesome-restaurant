<?php

namespace Framework\Session;

class PHPSession implements SessionInterface
{

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function get(string $key, $default = null)
    {
        $this->ensureStarted();
        return $_SESSION[$key] ?? $default;
    }

    public function set(string $key, $value): void
    {
        $this->ensureStarted();
        $_SESSION[$key] = $value;
    }

    public function setArray(string $key, string $value): void
    {
        $this->ensureStarted();
        $_SESSION[$key][] = $value;
    }

    public function delete(string $key): void
    {
        $this->ensureStarted();
        unset($_SESSION[$key]);
    }

    public function has(string $key): bool
    {
        $this->ensureStarted();
        return isset($_SESSION[$key]);
    }

    public function start(): void
    {
        $this->ensureStarted();
    }

    public function destroy(): void
    {
        session_destroy();
    }

    private function ensureStarted(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}
