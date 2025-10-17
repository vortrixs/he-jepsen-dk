<?php

namespace Vortrixs\Portfolio\Public;

use Psr\Http\Message\ServerRequestInterface;
use Vortrixs\Portfolio\Core;

final class Page
{
    public string $title = '';
    public string $url = '';
    public ?object $viewModel = null;

    public function __construct(
        private Core\Renderer $renderer,
        private Core\ViewModelFactory $viewModelFactory,
    ) {}

    public function render(ServerRequestInterface $request): string
    {
        if ($this->viewModel === null) {
            throw new \RuntimeException('ViewModel is not set on Page.');
        }

        $rendered_view = $this->renderer->render($this->viewModel);

        $header = $this->renderer->render($this->viewModelFactory->create(Components\Navigation\ViewModel::class, ['request' => $request]));
        $header .= $this->renderer->render($this->viewModelFactory->create(Components\About\ViewModel::class));

        $head = implode(PHP_EOL, [
            '<meta property="og:title" content="' . htmlspecialchars($this->title) . '">',
            '<meta property="og:url" content="' . htmlspecialchars($this->url) . '">',
        ]);

        return $this->renderer->render(new Core\Page\ViewModel($rendered_view, $header, $head));
    }
}