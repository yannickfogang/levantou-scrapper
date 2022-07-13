<?php

namespace Module\Infrastructure\Scrapper;

use Goutte\Client;
use Illuminate\Support\Facades\App;
use Module\Domain\Product\ScrapperApi;
use Symfony\Component\DomCrawler\Crawler;

class ScrapperWebScrappingApi implements ScrapperApi
{
    private Curl $curl;

    public function __construct(Curl $curl)
    {
        $this->curl = new $curl;
    }

    /**
     * @throws \Exception
     */
    public function loadPage(string $url, string $countryCode): string
    {
        $basePath = $this->basePath();
        if ($this->checkIfFileAlreadyLoad()) {
            return $basePath . '/page.html';
        }
        if (!is_dir($basePath)) {
            mkdir($basePath);
        }
        $content = $this->curl->Call($url, $countryCode);
        $this->saveContent($basePath, $content);
        return $basePath . '/page.html';
    }

    /**
     * @param string $page
     * @return bool
     */
    public function extractContent(string $page): bool
    {
        //{"title": {"selector": "span#productTitle", 'output': "html"}}
    }

    private function saveContent($dir, $contents)
    {
        $file = $dir . "/page.html";
        file_put_contents($file, $contents);
    }

    /**
     * @return bool
     */
    private function checkIfFileAlreadyLoad(): bool
    {
        $date = date('dmY');
        $basePath = base_path() . '/scrapper/file/' . $date;
        if (!is_dir($basePath)) {
            return false;
        }
        if (!file_exists($basePath . '/page.html')) {
            return false;
        }
        return true;
    }

    /**
     * @return string
     */
    private function basePath(): string
    {
        $date = date('dmY');
        if (App::environment() != 'prod') {
            return base_path() . '/scrapper/work';
        }
        return base_path() . '/scrapper/file/' . $date;
    }
}

