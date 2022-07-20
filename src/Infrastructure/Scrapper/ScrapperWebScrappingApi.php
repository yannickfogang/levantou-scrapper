<?php

namespace Module\Infrastructure\Scrapper;

use Goutte\Client;
use Illuminate\Support\Facades\App;
use Module\Domain\Product\Product;
use Module\Domain\Product\ScrapperApi;
use Symfony\Component\DomCrawler\Crawler;

class ScrapperWebScrappingApi implements ScrapperApi
{
    private Curl $curl;
    /**
     * @var \string[][]
     */
    private array $defaultExtractRule;
    private string $url;
    private string $countryCode;
    private string $baseUrl;

    public function __construct(Curl $curl)
    {
        $this->url = 'https://www.amazon.co.uk/dp';
        $this->baseUrl = 'https://www.amazon.co.uk';
        $this->countryCode = 'gb';
        $this->curl = new $curl;
        $this->defaultExtractRule = [
            'title' => ['selector' => '#productTitle', 'output' => 'text'],
            'categories' => [
                'selector' => 'div#wayfinding-breadcrumbs_feature_div a.a-color-tertiary',
                'output' => 'html'
            ],
            'description' => [
                'selector' => 'div#feature-bullets ul.a-unordered-list',
                'output' => 'html'
            ],
            'price' => [
                'selector' => 'div#corePrice_feature_div span.a-offscreen',
                'output' => 'text'
            ],
            'sender' => [
                'selector' => 'div#tabular-buybox div.tabular-buybox-container div[tabular-attribute-name="Dispatches from"] div.a-spacing-none',
                'output' => 'html'
            ],
            'seller' => [
                'selector' => 'div#tabular-buybox div.tabular-buybox-container div[tabular-attribute-name="Sold by"] div.a-spacing-none',
                'output' => 'html'
            ],
            /*'asin' => [
                'selector' => 'table#productDetails_techSpec_section_1 > tbody > tr:last-child',
                'output' => 'html'
            ],*/
            'first_date_publish' => [
                'selector' => 'table#productDetails_detailBullets_sections1 > tbody',
                'output' => 'html'
            ],
            'evaluation' => [
                'selector' => 'div#averageCustomerReviews i.a-icon-star span',
                'output' => 'html'
            ],
            'best_seller_rank' => [
                'selector' => 'table#productDetails_detailBullets_sections1 > tbody',
                'output' => 'html'
            ],
            'open_link_concurrent_product' => [
                'selector' => 'div.olp-link-widget span[data-action="show-all-offers-display"]'
            ],
            'images' => [
                'selector' => 'div#altImages',
                'output' => 'html'
            ]
        ];
    }

    public function extractDefaultProductDetailsData(string $asin): ?Product
    {

        $productBuilder = ScrapperProductBuilder::asProduct();

        if (App::isLocal() || App::environment() == 'testing') {
            $file = base_path() . "/scrapper/work/page.txt";
            $content = file_get_contents($file);
        } else {
            $url = $this->url . '/' . $asin;
            $content = $this->curl->Call($url, $this->countryCode, $this->defaultExtractRule);
            $file = base_path() . "/scrapper/work/page.txt";
            file_put_contents($file, $content);
        }
        $arrData = json_decode($content, true);

        if (empty($arrData)) {
            return null;
        }

        $productBuilder->withAsin($asin);
        $this->parseTitle($arrData, $productBuilder);
        $this->parseDescription($arrData, $productBuilder);
        $this->parsePriceAndCurrency($arrData, $productBuilder);
        $this->parseSenderAndSeller($arrData, $productBuilder);
        //$this->parseAsinProduct($arrData, $productBuilder);
        $this->parseFirstDatePublish($arrData, $productBuilder);
        $this->parseEvaluation($arrData, $productBuilder);
        $this->parseBestSellerRank($arrData, $productBuilder);
        $this->parseCategoriesProduct($arrData, $productBuilder);
        $this->parseOpenLinkConcurrentProduct($arrData, $productBuilder, $this->baseUrl);
        $this->parseImagesProduct($arrData, $productBuilder);

        if ($productBuilder->link_more_builder) {
            $this->extractConcurrentProductData($productBuilder->link_more_builder, $this->baseUrl, $this->countryCode, $productBuilder);
        }
        $this->extractRelatedProductData($this->url, $this->countryCode, $productBuilder);
        $this->extractProductBoughtTogetherData($this->url, $this->countryCode, $productBuilder);

        return $productBuilder->build();
    }


    private function extractConcurrentProductData(string $url, string $baseUrl, string $countryCode, ScrapperProductBuilder $productBuilder)
    {

        $extractRule = [
            'concurrent_product' => ['selector' => 'div#aod-offer-list > div#aod-offer', 'output' => 'html'],
        ];

        if (App::isLocal() || App::environment() == 'testing') {
            $file = base_path() . "/scrapper/work/page_other.txt";
            $content = file_get_contents($file);
        } else {
            $content = $this->curl->CallJS($url, $countryCode, $extractRule);
            $file = base_path() . "/scrapper/work/page_other.txt";
            file_put_contents($file, $content);
        }
        $arrData = json_decode($content, true);
        $arrOtherProduct = [];
        if (!empty($arrData['concurrent_product'])) {
            $crawler = new Crawler($arrData['concurrent_product']);
            $nodeValues = $crawler->filter('div#aod-offer')->each(function (Crawler $node, $i) {
                return $node->html();
            });
            foreach ($nodeValues as $node) {

                try {
                    $crawler = new Crawler($node);
                    $nodeHeader = $crawler->filter('div#aod-offer-heading')->text();
                    $nodePrice = $crawler->filter('span.a-offscreen')->text();
                    $sender = $crawler->filter('div#aod-offer-shipsFrom span.a-color-base')->text();
                    $saller = $crawler->filter('div#aod-offer-soldBy a.a-link-normal')->text();
                    $sallerLink = $crawler->filter('div#aod-offer-soldBy a.a-link-normal')->attr('href');

                    if (!str_contains($sallerLink, $baseUrl)) {
                        $sallerLink = $baseUrl . $sallerLink;
                    }

                    $arrOtherProduct[] = [
                        'product_status' => $nodeHeader,
                        'price' => $nodePrice,
                        'sender' => $sender,
                        'saller' => $saller,
                        'sallerLink' => $sallerLink
                    ];
                } catch (\InvalidArgumentException $e) {
                }
            }
        }

        $productBuilder->withConcurrentProduct($arrOtherProduct);
    }

    private function extractProductBoughtTogetherData(string $url, string $countryCode, ScrapperProductBuilder $productBuilder)
    {
        $extractRule = [
            'bought_together_products' => ['selector' => 'div#sims-consolidated-2_feature_div div[cel_widget_id="sims-consolidated-2_csm_instrumentation_wrapper"]', 'output' => 'html'],
        ];
        if (App::isLocal() || App::environment() == 'testing') {
            $file = base_path() . "/scrapper/work/page_bought_product.txt";
            $content = file_get_contents($file);
        } else {
            $content = $this->curl->CallJS($url, $countryCode, $extractRule);
            $file = base_path() . "/scrapper/work/page_bought_product.txt";
            file_put_contents($file, $content);
        }
        $arrData = json_decode($content, true);
        if (!empty($arrData['bought_together_products'])) {
            $crawler = new Crawler($arrData['bought_together_products']);
            $nodeValues = $crawler->filter('div.sp_offerVertical')->each(function (Crawler $node, $i) {
                return $node->attr('data-asin');
            });
            $productBuilder->withProductsBoughtTogether(array_unique($nodeValues));
        }
    }

    private function extractRelatedProductData(string $url, string $countryCode, ScrapperProductBuilder $productBuilder)
    {
        $extractRule = [
            'related_products' => ['selector' => 'li.a-carousel-card', 'output' => 'html'],
        ];

        if (App::isLocal() || App::environment() == 'testing') {
            $file = base_path() . "/scrapper/work/page_related_product.txt";
            $content = file_get_contents($file);
        } else {
            $content = $this->curl->CallJS($url, $countryCode, $extractRule);
            $file = base_path() . "/scrapper/work/page_related_product.txt";
            file_put_contents($file, $content);
        }
        $arrData = json_decode($content, true);

        if (!empty($arrData['related_products'])) {
            $crawler = new Crawler($arrData['related_products']);
            $nodeValues = $crawler->filter('div.sp_offerVertical')->each(function (Crawler $node, $i) {
                return $node->attr('data-asin');
            });
            $productBuilder->withRelatedProducts($nodeValues);
        }
    }

    private function parseTitle(array $arrData, ScrapperProductBuilder $productBuilder)
    {
        if (!empty($arrData['title'])) {
            $productBuilder->withTitle(trim($arrData['title']));
        }
    }

    private function parseDescription(array $arrData, ScrapperProductBuilder $productBuilder)
    {
        if (!empty($arrData['description'])) {
            $productBuilder->withDescriptionHtml($arrData['description']);
            $crawler = new Crawler($arrData['description']);
            $crawler = $crawler->filter('ul');
            $nodeValues = $crawler->filter('li')->each(function (Crawler $node, $i) {
                return $node->text();
            });
            $description = implode('', $nodeValues);
            $productBuilder->withDescription($description);
        }
    }

    private function parsePriceAndCurrency(array $arrData, ScrapperProductBuilder $productBuilder)
    {
        if (!empty($arrData['price'])) {
            $arrPrice = explode('£', $arrData['price']);
            if (isset($arrPrice[1])) {
                $productBuilder->withPrice($arrPrice[1]);
                $productBuilder->withCurrency('£');
            }
        }
    }

    private function parseSenderAndSeller(array $arrData, ScrapperProductBuilder $productBuilder)
    {
        if (!empty($arrData['sender'])) {
            $crawler = new Crawler($arrData['sender']);
            $nodeValues = $crawler->filter('span')->each(function (Crawler $node, $i) {
                return $node->text();
            });
            if (isset($nodeValues[1])) {
                $productBuilder->withSalerBy($nodeValues[1]);
            }
        }
        if (!empty($arrData['seller'])) {
            $crawler = new Crawler($arrData['seller']);
            $nodeValues = $crawler->filter('span')->each(function (Crawler $node, $i) {
                return $node->text();
            });
            if (isset($nodeValues[1])) {
                $productBuilder->withSenderOnStore($nodeValues[1]);
            }
        }
    }

    private function parseAsinProduct(array $arrData, ScrapperProductBuilder $productBuilder)
    {
        if (!empty($arrData['asin'])) {
            $crawler = new Crawler($arrData['asin']);
            $nodeValues = $crawler->filter('td')->each(function (Crawler $node, $i) {
                return $node->text();
            });
            if (isset($nodeValues[0])) {
                $productBuilder->withAsin(ltrim($nodeValues[0]));
            }
        }
    }

    private function parseFirstDatePublish(array $arrData, ScrapperProductBuilder $productBuilder)
    {
        if (!empty($arrData['first_date_publish'])) {
            $crawler = new Crawler($arrData['first_date_publish']);
            $nodeValues = $crawler->filter('tr')->each(function (Crawler $node, $i) {
                return $node->html();
            });
            $nodeDate = null;
            foreach ($nodeValues as $nodes) {
                if (str_contains($nodes, 'Date First Available')) {
                    $nodeDate = $nodes;
                    break;
                }
            }
            if ($nodeDate) {
                $crawler = new Crawler($nodeDate);
                $nodeValue = $crawler->filter('td')->text();
                $productBuilder->withPublishDate($nodeValue);
            }
        }
    }

    private function parseEvaluation(array $arrData, ScrapperProductBuilder $productBuilder)
    {
        if (!empty($arrData['evaluation'])) {
            $crawler = new Crawler($arrData['evaluation']);
            $nodeValues = $crawler->filter('span')->each(function (Crawler $node, $i) {
                return $node->text();
            });
            if (isset($nodeValues[0])) {
                $arrEvaluation = explode('out', $nodeValues[0]);
                if (isset($arrEvaluation[0])) {
                    $productBuilder->withEvaluation(trim($arrEvaluation[0]));
                }
            }
        }
    }

    private function parseBestSellerRank(array $arrData, ScrapperProductBuilder $productBuilder)
    {
        if (!empty($arrData['best_seller_rank'])) {

            $crawler = new Crawler($arrData['best_seller_rank']);
            $nodeValues = $crawler->filter('tr')->each(function (Crawler $node, $i) {
                return $node->html();
            });
            $nodeSellerRank = null;
            $nodeSellerRankHtml = null;
            foreach ($nodeValues as $nodes) {
                if (str_contains($nodes, 'Best Sellers Rank')) {
                    $nodeSellerRank = $nodes;
                    break;
                }
            }

            if ($nodeSellerRank) {
                $crawler = new Crawler($nodeSellerRank);
                $nodeSellerRankHtml = $crawler->filter('td')->text();
            }

            if ($nodeSellerRankHtml) {
                $nodeValues = $nodeSellerRankHtml;
                $openBraket = strpos($nodeSellerRankHtml, '(');
                $closeBraket = strpos($nodeSellerRankHtml, ')');
                if ($openBraket && $closeBraket) {
                    $firstPath = substr($nodeSellerRankHtml, 0, $openBraket);
                    $secondPath = substr($nodeSellerRankHtml, $closeBraket + 1);
                    $completeNode = trim(str_replace(',', ' ', $firstPath));
                    if ($secondPath) {
                        $completeNode .= ', ' . trim(str_replace(',', ' ', $secondPath));
                    }
                    $nodeValues = $completeNode;
                }
                $productBuilder->withBestSellerRank($nodeValues);
            }
        }
    }

    private function parseOpenLinkConcurrentProduct(array $arrData, ScrapperProductBuilder $productBuilder, string $baseUrl)
    {
        if (!empty($arrData['open_link_concurrent_product'])) {
            $crawler = new Crawler($arrData['open_link_concurrent_product']);
            $nodeValues = $crawler->filter('a.a-touch-link')->attr('href');
            if ($nodeValues) {
                $productBuilder->withLinkMoreProduct($baseUrl . $nodeValues);
            }
        }
    }

    private function parseCategoriesProduct(array $arrData, ScrapperProductBuilder $productBuilder)
    {
        if (!empty($arrData['categories'])) {
            $crawler = new Crawler($arrData['categories']);
            $nodeValues = $crawler->filter('a')->each(function (Crawler $node, $i) {
                return $node->text();
            });
            if (!empty($nodeValues)) {
                $productBuilder->withCategoriesProduct(implode(' / ', $nodeValues));
            }
        }
    }

    private function parseImagesProduct(array $arrData, ScrapperProductBuilder $productBuilder)
    {
        if (!empty($arrData['images'])) {
            $crawler = new Crawler($arrData['images']);
            $nodeValues = $crawler->filter('li span.a-button-text img')->each(function (Crawler $node, $i) {
                return $node->attr('src');
            });
            $productBuilder->withImagesProducts($nodeValues);
        }
    }


}

