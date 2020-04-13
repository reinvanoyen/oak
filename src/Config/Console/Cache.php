<?php

namespace Oak\Config\Console;

use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;
use Oak\Contracts\Config\RepositoryInterface;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Filesystem\FilesystemInterface;

class Cache extends Command
{
    /**
     * @var RepositoryInterface $config
     */
    private $config;

    /**
     * @var FilesystemInterface $filesystem
     */
    private $filesystem;

    /**
     * Cache constructor.
     * @param RepositoryInterface $config
     * @param FilesystemInterface $filesystem
     * @param ContainerInterface $app
     */
    public function __construct(RepositoryInterface $config, FilesystemInterface $filesystem, ContainerInterface $app)
    {
        $this->config = $config;
        $this->filesystem = $filesystem;

        parent::__construct($app);
    }

    /**
     * @param Signature $signature
     * @return Signature
     */
    protected function createSignature(Signature $signature): Signature
    {
        return $signature
            ->setName('cache')
            ->setDescription('Cache the config')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->filesystem->put($this->config->get('app.cache_path').'config.php', '<?php return '.var_export($this->config->all(), true).';'.PHP_EOL);
        $output->writeLine('Config cached');
    }
}