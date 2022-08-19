<?php declare(strict_types=1);

namespace mvcex\core;

abstract class RouteContract {
    protected function GET(): void
    {
        http_response_code(405);
        exit;
    }

    protected function POST(): void
    {
        http_response_code(405);
        exit;
    }

    protected function PUT(): void
    {
        http_response_code(405);
        exit;
    }

    protected function DEL(): void
    {
        http_response_code(405);
        exit;
    }

    public function serve(): void
    {
        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->GET();
        } elseif($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->POST();
        } elseif($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $this->PUT();
        } elseif($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $this->DEL();
        } else {
            http_response_code(405);
        }
    }
}
