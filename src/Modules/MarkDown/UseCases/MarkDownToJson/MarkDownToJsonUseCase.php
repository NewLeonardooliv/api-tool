<?php

namespace App\Modules\MarkDown\UseCases\MarkDownToJson;

use App\Infra\Contracts\UseCase;

class MarkDownToJsonUseCase implements UseCase
{
    public const PATTERN_HEADER_LEVEL_ONE = '/^# (.*)$/';
    public const PATTERN_HEADER_LEVEL_TWO = '/^## (.*)$/';
    public const PATTERN_LIST_ITEM = '/^\* (.*)$/';
    public const PATTERN_LINK = '/^\[(.*)\]\((.*)\)$/';
    public const PATTERN_IMAGE = '/^!\[(.*)\]\((.*)\)$/';
    public const PATTERN_BLOCK_QUOTE = '/^> (.*)$/';
    public const PATTERN_INLINE_CODE = '/`([^`]*)`/';
    public const PATTERN_CODE_BLOCK = '/^```/';

    public const PATTERNS = [
        self::PATTERN_HEADER_LEVEL_ONE => ['type' => 'header', 'level' => 1, 'text' => 1],
        self::PATTERN_HEADER_LEVEL_TWO => ['type' => 'header', 'level' => 2, 'text' => 1],
        self::PATTERN_LIST_ITEM => ['type' => 'list_item', 'text' => 1],
        self::PATTERN_LINK => ['type' => 'link', 'text' => 1, 'href' => 2],
        self::PATTERN_IMAGE => ['type' => 'image', 'alt' => 1, 'src' => 2],
        self::PATTERN_BLOCK_QUOTE => ['type' => 'block_quote', 'text' => 1],
        self::PATTERN_INLINE_CODE => ['type' => 'inline_code', 'code' => 1],
        self::PATTERN_CODE_BLOCK => 'code_block',
    ];

    public function execute()
    {
        $markdownText = <<<'MD'
        # Título
        ## Subtítulo
        * Item 1
        * Item 2
        [Site](https://www.site.com)
        ![Imagem](https://www.example.com/image.png)
        > Isso é uma citação.
        `Código inline`
        ```php
        echo "Bloco de código";
        ```
        MD;

        return $this->convertMarkdownToJson($markdownText);
    }

    private function convertMarkdownToJson(string $markdownText): array
    {
        $lines = explode("\n", $markdownText);
        $json = [];

        foreach ($lines as $line) {
            $json[] = $this->parseLine($line);
        }

        return $json;
    }

    private function parseLine(string $line): array
    {
        foreach (self::PATTERNS as $pattern => $structure) {
            if (preg_match($pattern, $line, $matches)) {
                if ($structure === 'code_block') {
                    return $this->parseCodeBlock($line);
                }

                $result = [];
                foreach ($structure as $key => $value) {
                    $result[$key] = is_int($value) ? $matches[$value] : $value;
                }

                return $result;
            }
        }

        return ['type' => 'paragraph', 'text' => $line];
    }

    private function parseCodeBlock(string &$line): array
    {
        $codeBlockContent = '';
        $language = '';

        if (preg_match('/^```(\w+)?$/', $line, $matches)) {
            $language = $matches[1] ?? '';
        }

        while (($line = next($lines)) !== false && !preg_match('/^```$/', $line)) {
            $codeBlockContent .= $line."\n";
        }

        return [
            'type' => 'block_code',
            'language' => $language,
            'code' => trim($codeBlockContent),
        ];
    }
}
