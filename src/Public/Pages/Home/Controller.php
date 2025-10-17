<?php

namespace Vortrixs\Portfolio\Public\Pages\Home;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\StreamFactoryInterface;
use Vortrixs\Portfolio\Core\ViewModelFactory;
use Vortrixs\Portfolio\Public;
use Vortrixs\Portfolio\Public\Components;

class Controller
{
    public function __construct(
        private Public\Page $page,
        private ViewModelFactory $viewModelFactory,
        private StreamFactoryInterface $streamFactory,
    ) {}

    public function __invoke(Request $request, Response $response)
    {
        $this->page->title = 'Home';
        $this->page->url = 'https://he-jepsen.dk/';
        $this->page->viewModel = $this->viewModelFactory->create(Components\CVList\ViewModel::class);

        $body = $this->streamFactory->createStream($this->page->render($request));

        return $response
            ->withBody($body)
            ->withHeader('Content-Type', 'text/html');
    }
}
