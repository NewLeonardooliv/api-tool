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

        try {
            $json = $this->convertMarkdownToJson($markdownText);
            print json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            print 'Erro: '.$e->getMessage();
        }
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
        if (preg_match(self::PATTERN_HEADER_LEVEL_ONE, $line, $matches)) {
            return ['type' => 'header', 'level' => 1, 'text' => $matches[1]];
        }
        if (preg_match(self::PATTERN_HEADER_LEVEL_TWO, $line, $matches)) {
            return ['type' => 'header', 'level' => 2, 'text' => $matches[1]];
        }
        if (preg_match(self::PATTERN_LIST_ITEM, $line, $matches)) {
            return ['type' => 'list_item', 'text' => $matches[1]];
        }
        if (preg_match(self::PATTERN_LINK, $line, $matches)) {
            return ['type' => 'link', 'text' => $matches[1], 'href' => $matches[2]];
        }
        if (preg_match(self::PATTERN_IMAGE, $line, $matches)) {
            return ['type' => 'image', 'alt' => $matches[1], 'src' => $matches[2]];
        }
        if (preg_match(self::PATTERN_BLOCK_QUOTE, $line, $matches)) {
            return ['type' => 'block_quote', 'text' => $matches[1]];
        }
        if (preg_match(self::PATTERN_INLINE_CODE, $line, $matches)) {
            return ['type' => 'inline_code', 'code' => $matches[1]];
        }
        if (preg_match(self::PATTERN_CODE_BLOCK, $line)) {
            return $this->parseCodeBlock($line);
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
