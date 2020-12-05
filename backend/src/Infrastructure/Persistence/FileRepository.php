<?php declare(strict_types=1);

namespace MySelf\Scrabble\Infrastructure\Persistence;

class FileRepository
{
    protected const PATH_TO_REPOSITORY = __DIR__ . '/../../Resources/FileRepository/';

    protected string $fileName = 'FileRepository';
    protected string $repositoryFile;
    protected string $delimiter = ',';

    public function __construct(string $fileName = null)
    {
        if ($fileName) {
            $this->fileName = $fileName;
        }

        $this->repositoryFile = self::PATH_TO_REPOSITORY . $this->fileName;
    }

    public function dropRepository(): void
    {
        unlink($this->repositoryFile);
    }

    protected function readData(): \Generator
    {
        if (!file_exists($this->repositoryFile)) {
            yield '';

            return;
        }

        $file = fopen($this->repositoryFile, 'r');

        while (!feof($file)) {
            yield fgetcsv($file, 0, $this->delimiter);
        }
    }
}
