<?php
declare(strict_types=1);

namespace Kryus\GeneRally;

class Language
{
    /** @var string[] */
    private $translations;

    /**
     * @param string[] $translations
     */
    public function __construct(array $translations)
    {
        $this->translations = $translations;
    }

    /**
     * @param string $filename
     * @return Language
     */
    public static function createFromFile(string $filename): Language
    {
        $file = file_get_contents($filename);
        $translations = [];

        //TODO

        return new self($translations);
    }

    /**
     * @return string[]
     */
    public function getTranslations(): array
    {
        return $this->translations;
    }

    /**
     * @param int $id
     * @return string|null
     */
    public function getTranslation(int $id): ?string
    {
        return $this->translations[$id] ?? null;
    }
}