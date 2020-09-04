<?php

namespace Oak\Migration;

use Oak\Contracts\Container\ContainerInterface;

/**
 * Class that manages and stores migrators.
 *
 * @package Oak
 * @author Rein Van Oyen <reinvanoyen@gmail.com>
 */
class MigrationManager
{
    /**
     * @var ContainerInterface $app
     */
    private $app;

    /**
     * @var array $migrators
     */
    private $migrators = [];

    /**
     * MigrationManager constructor.
     * @param ContainerInterface $app
     */
    public function __construct(ContainerInterface $app)
    {
        $this->app = $app;
    }

    /**
     * @param $migrator
     */
    public function addMigrator($migrator)
    {
        if (is_string($migrator)) {
            $this->migrators[] = $this->app->get($migrator);
            return;
        }

        $this->migrators[] = $migrator;
    }

    /**
     * @return array
     */
    public function getMigrators(): array
    {
        return $this->migrators;
    }
}