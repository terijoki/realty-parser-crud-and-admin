<?php

namespace RltBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use RltBundle\Entity\Model\DeveloperDTO;
use RltBundle\Entity\Model\DTOInterface;
use RltBundle\Service\ParseListInterface;
use Symfony\Component\DomCrawler\Crawler;

final class DeveloperParserManager extends AbstractManager implements ParseItemInterface
{
    private const ADDRESS = 'Адрес офиса:';
    private const TELEPHONE = 'Телефон:';
    private const EMAIL = 'E-mail:';
    private const SITE = 'Сайт:';
    private const CREATED = 'Дата создания:';

    /**
     * @var DTOInterface
     */
    private $dto;

    /**
     * BuildingParserManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param LoggerInterface        $logger
     * @param ParseListInterface     $service
     */
    public function __construct(EntityManagerInterface $em, LoggerInterface $logger, ParseListInterface $service)
    {
        parent::__construct($em, $logger, $service);
        $this->dto = new DeveloperDTO();
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
        $dom = new Crawler(\file_get_contents(__DIR__ . '/../../../var/mock/developer1.html'));
        $this->externalId = $externalId;

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
                'category' => 'no-name',
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
                    $this->dto->setAddress($result);

                    break;
                case self::TELEPHONE:
                    $this->dto->setPhone($result);

                    break;
                case self::EMAIL:
                    $this->dto->setEmail($result);

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
