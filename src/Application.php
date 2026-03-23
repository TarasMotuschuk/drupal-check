<?php declare(strict_types=1);

namespace DrupalCheck;

use Symfony\Component\Console\Application as BaseApplication;

final class Application extends BaseApplication
{
    public function __construct()
    {
        $version = $this->resolveVersion();
        parent::__construct('Drupal Check', $version);
        $this->addCommand(new Command\CheckCommand());
        $this->setDefaultCommand('check', true);
    }

    private function resolveVersion(): string
    {
        foreach (['drudev/drupal-check', 'mglaman/drupal-check'] as $packageName) {
            try {
                return \Jean85\PrettyVersions::getVersion($packageName)->getPrettyVersion();
            } catch (\OutOfBoundsException $e) {
                // Try the next package alias.
            }
        }

        return '0.0.0';
    }
}
