<?php

namespace RltBundle\Command;

class EntityNewParserCommand extends AbstractParserCommand
{
    protected const NAME = '';

    /**
     * @throws \ReflectionException
     * @throws \Exception
     */
    protected function process(): void
    {
        $this->output->writeln('Search for links...');
        $links = $this->service->parseLinks();

        $this->output->writeln(\count($links) . ' links founded. Starting parser process...');
        $progress = 0;

        foreach ($links as $id => $link) {
            if ($this->isUnique($id) || !$this->input->getOption('force')) {
                $item = $this->service->getItem($link);
                $dto = $this->parser->parseItem($item, $id);
                $entity = $this->validator->fillEntity($dto, $id);

                try {
                    $this->em->persist($entity);
                    $this->em->commit();
                    $this->em->flush();

                    ++$progress;
                    $this->output->writeln('Stored new entity: ' . $link);
                    $this->logger->info('Stored new entity: ' . $link, [
                        'class' => (new \ReflectionClass(static::class))->getShortName(),
                        'category' => 'parser-command', ]);
                } catch (\Exception $e) {
                    $this->em->rollback();
                    $this->logger->critical($e->getMessage(), [
                        'class' => (new \ReflectionClass(static::class))->getShortName(),
                        'category' => 'parser-command',
                    ]);
                }
            }
            \sleep(static::DELAY);
        }
        $this->output->writeln('Finished parser process, count new entities: ' . $progress);
    }

    /**
     * @param string $externalId
     *
     * @return bool
     */
    protected function isUnique(string $externalId): bool
    {
        return !\in_array($externalId, $this->storedIds, true);
    }
}
