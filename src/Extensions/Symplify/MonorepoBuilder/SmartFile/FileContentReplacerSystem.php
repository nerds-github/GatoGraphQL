<?php

declare(strict_types=1);

namespace PoP\PoP\Extensions\Symplify\MonorepoBuilder\SmartFile;

use Nette\Utils\Strings;
use Symplify\SmartFileSystem\SmartFileInfo;
use Symplify\SmartFileSystem\SmartFileSystem;

final class FileContentReplacerSystem
{
    public function __construct(
        private SmartFileSystem $smartFileSystem,
    ) {
    }

    /**
     * @param string[] $files
     * @param array<string,string> $patternReplacements a regex pattern to search, and its replacement
     */
    public function replaceContentInFiles(
        array $files,
        array $patternReplacements,
        bool $useRegex
    ): void {
        foreach ($files as $file) {
            $fileContent = $this->smartFileSystem->readFile($file);
            foreach ($patternReplacements as $pattern => $replacement) {
                if ($useRegex) {
                    $fileContent = Strings::replace(
                        $fileContent,
                        $pattern,
                        $replacement
                    );
                } else {
                    $fileContent = str_replace(
                        $pattern,
                        $replacement,
                        $fileContent
                    );
                }
            }
            $this->smartFileSystem->dumpFile($file, $fileContent);
        }
    }

    /**
     * @param SmartFileInfo[] $smartFileInfos
     * @param array<string,string> $patternReplacements a regex pattern to search, and its replacement
     */
    public function replaceContentInSmartFileInfos(
        array $smartFileInfos,
        array $patternReplacements,
        bool $useRegex
    ): void {
        $files = array_map(
            fn (SmartFileInfo $smartFileInfo) => $smartFileInfo->getRealPath(),
            $smartFileInfos
        );
        $this->replaceContentInFiles($files, $patternReplacements, $useRegex);
    }
}
