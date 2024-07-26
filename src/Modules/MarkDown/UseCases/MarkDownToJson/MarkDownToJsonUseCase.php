<?php

namespace App\Modules\MarkDown\UseCases\MarkDownToJson;

use App\Infra\Contracts\UseCase;

class MarkdownToJsonConverter implements UseCase
{
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
        } catch (\Exception $e) {
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
        $patterns = [
            '/^# (.*)$/' => ['type' => 'header', 'level' => 1, 'text' => 1],
            '/^## (.*)$/' => ['type' => 'header', 'level' => 2, 'text' => 1],
            '/^\* (.*)$/' => ['type' => 'list_item', 'text' => 1],
            '/^\[(.*)\]\((.*)\)$/' => ['type' => 'link', 'text' => 1, 'href' => 2],
            '/^!\[(.*)\]\((.*)\)$/' => ['type' => 'image', 'alt' => 1, 'src' => 2],
            '/^> (.*)$/' => ['type' => 'block_quote', 'text' => 1],
            '/`([^`]*)`/' => ['type' => 'inline_code', 'code' => 1],
            '/^```/' => 'code_block',
        ];

        foreach ($patterns as $pattern => $structure) {
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