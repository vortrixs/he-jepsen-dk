<?php

namespace Vortrixs\Portfolio\Public\Pages\Portfolio;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\StreamFactoryInterface;
use Vortrixs\Portfolio\Public;
use Vortrixs\Portfolio\Public\Components;
use Vortrixs\Portfolio\Core\ViewModelFactory;

class Controller
{
    public function __construct(
        private Public\Page $page,
        private ViewModelFactory $viewModelFactory,
        private StreamFactoryInterface $streamFactory,
    ) {}

    public function __invoke(Request $request, Response $response)
    {
        $this->page->title = 'Portfolio';
        $this->page->url = 'https://he-jepsen.dk/portfolio';
        $this->page->viewModel = $this->viewModelFactory->create(Components\Portfolio\ViewModel::class);

        $body = $this->streamFactory->createStream($this->page->render($request));

        return $response
            ->withBody($body)
            ->withHeader('Content-Type', 'text/html');
    }
}
