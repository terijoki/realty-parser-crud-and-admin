<?php

namespace RltBundle\Command;

class EntityParserCommand extends AbstractParserCommand
{
    protected const NAME = '';
    protected const LINKS_SELECTOR = '';

    /**
     * @throws \ReflectionException
     * @throws \Exception
     */
    protected function process(): void
    {
        $this->output->writeln('Search for links...');
        $links = $this->service->parseLinks(static::LINKS_SELECTOR);

        $this->output->writeln(\count($links) . ' links founded. Starting parse process...');
        $progress = 0;

        foreach ($links as $id => $link) {
            if ($this->isUnique($id) || $this->input->getOption('force')) {
                $item = $this->service->getItem($link);
                if (!$item) {
                    continue;
                }

                $dto = $this->parser->parseItem($item, $id);
                $entity = $this->validator->fillEntity($dto, $id);

                $this->em->persist($entity);

                try {
                    $this->em->flush();

                    ++$progress;
                    $this->output->writeln('Stored new entity: ' . $link);
                    $this->logger->info('Stored new entity: ' . $link, [
                        'class' => (new \ReflectionClass(static::class))->getShortName(),
                        'category' => 'parser-command', ]);
                } catch (\Exception $e) {
                    $this->logger->critical($e->getMessage(), [
                        'class' => (new \ReflectionClass(static::class))->getShortName(),
                        'category' => 'parser-command',
                    ]);
                    throw $e;
                }
                \sleep(static::DELAY);
            }
        }
        $this->output->writeln('Finished parse process, count new entities: ' . $progress);
    }

    /**
     * @param int $externalId
     *
     * @return bool
     */
    protected function isUnique(int $externalId): bool
    {
        return !\in_array($externalId, $this->storedIds, true);
    }
}
