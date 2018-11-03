<?php

namespace RltBundle\Command;

use Symfony\Component\Console\Input\InputOption;

class BuildingUpdateParserCommand extends AbstractParserCommand
{
    protected const NAME = 'RltBundle:Building';

    /**
     * BuildingUpdateParser Configurate.
     */
    protected function configure(): void
    {
        $this
            ->setName('parser:update-buildings')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Update all data without checking for last updated')
            ->setDescription('Checks updated date in building and parse them if we need it')
        ;
    }

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
            $item = $this->service->getItem($link);
            if ($this->parser->needToUpdate($item, $id)) {
                $item = $this->service->getItem($link);
                $dto = $this->parser->parseItem($item, $id);
                $entity = $this->validator->fillEntity($dto, $id);

                try {
                    $this->em->persist($entity);
                    $this->em->commit();
                    $this->em->flush();

                    ++$progress;
                    $this->output->writeln('Updated entity: ' . $link);
                    $this->logger->info('Updated entity: ' . $link, [
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
        $this->output->writeln('Finished parser process, count updated: ' . $progress);
    }
}
