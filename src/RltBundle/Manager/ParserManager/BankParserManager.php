<?php

namespace RltBundle\Manager\ParserManager;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use RltBundle\Entity\Model\BankDTO;
use RltBundle\Entity\Model\DTOInterface;
use RltBundle\Manager\AbstractManager;
use RltBundle\Service\BaseService;
use RltBundle\Service\ParseListInterface;
use Symfony\Component\DomCrawler\Crawler;

final class BankParserManager extends AbstractManager implements ParseItemInterface
{
    private const ADDRESS = 'Адрес офиса:';
    private const TELEPHONE = 'Телефон:';
    private const SITE = 'Официальный сайт:';
    private const CREATED = 'Дата создания:';

    private $dto;

    /**
     * BankParserManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param LoggerInterface        $logger
     * @param BaseService        $service
     */
    public function __construct(EntityManagerInterface $em, LoggerInterface $logger, ParseListInterface $service)
    {
        parent::__construct($em, $logger, $service);
        $this->dto = new BankDTO();
    }

    /**
     * @return DTOInterface
     */
    public function getDto(): DTOInterface
    {
        return $this->dto;
    }

    /**
     * @param string $item
     * @param int    $externalId
     *
     * @return DTOInterface
     */
    public function parseItem(string $item, int $externalId): DTOInterface
    {
        $dom = new Crawler($item);

        $this->parseCharacteristics($dom);
        $this->dto
            ->setName($this->parseName($dom))
            ->setLogo($this->parseLogo($dom))
            ->setDescription($this->parseDescription($dom))
        ;

        $dom->clear();

        return $this->getDto();
    }

    /**
     * @param Crawler $dom
     *
     * @return string
     */
    private function parseName(Crawler $dom): string
    {
        try {
            return $dom->filter('h1[itemprop="name"]')->text();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), [
                'category' => self::ERROR_PARSE_TAG,
                'info' => $dom->html(),
            ]);
        }
    }

    /**
     * @param Crawler $dom
     */
    private function parseCharacteristics(Crawler $dom): void
    {
        foreach ($dom->filter('table[id="BuildData"]')->eq(0)->children() as $node) {
            $result = \trim($node->childNodes->item(2)->nodeValue);
            switch ($node->firstChild->nodeValue) {
                case self::ADDRESS:
                    $address = \trim($node->childNodes
                        ->item(2)
                        ->getElementsByTagName('span')
                        ->item(0)
                        ->nodeValue);
                    $this->dto->setAddress($address);

                    break;
                case self::TELEPHONE:
                    $this->dto->setPhone($result);

                    break;
                case self::SITE:
                    $this->dto->setSite($result);

                    break;
                case self::CREATED:
                    $result = \preg_replace('/(\d{4})\s\г\./ui', '$1', $result);
                    $this->dto->setCreated((int) $result);

                    break;
            }
        }
    }

    /**
     * @param Crawler $dom
     *
     * @return string
     */
    private function parseLogo(Crawler $dom): string
    {
        return \trim($dom->filter('div[id="BuildImg"] > img')->attr('src')) ?? '';
    }

    /**
     * @param Crawler $dom
     *
     * @return string
     */
    private function parseDescription(Crawler $dom): string
    {
        return \trim($dom->filter('div[id="BuildDescription"]')->html());
    }
}
