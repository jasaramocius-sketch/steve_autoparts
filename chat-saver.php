<?php

declare(strict_types=1);

/**
 * chat-saver.php
 *
 * Generic, framework-free PHP function to save a full AI chat (any tool:
 * OpenAI, Claude, local models, custom assistants, etc.) to disk with a
 * date + time stamp. No composer dependencies — drop this file into any
 * PHP project and use it.
 */

if (!function_exists('save_chat')) {
    /**
     * Save a full chat to disk as JSON + readable markdown.
     *
     * @param array  $chat      Full chat. Each message can be:
     *                          - string ('Hello')
     *                          - ['role' => 'user', 'content' => 'Hello']
     *                          - ['author' => 'assistant', 'text' => 'Hi']
     *                          - ['type' => 'user', 'message' => 'Hi']
     *                          - ['role' => 'user', 'content' => [
     *                                ['type' => 'text', 'text' => 'Hello']
     *                            ]]  (OpenAI-style content blocks)
     * @param array  $meta      Extra metadata, e.g. ['model' => 'gpt-4o', 'tool' => 'opencode']
     * @param string $dir       Directory to store the chat files (created if missing)
     * @param string $prefix    Filename prefix
     *
     * @return array{json: string, markdown: string, stamp: string}
     * @throws RuntimeException If the files cannot be written
     */
    function save_chat(array $chat, array $meta = [], string $dir = 'chat-logs', string $prefix = 'chat'): array
    {
        $stamp = date('Y-m-d_H-i-s');
        $dir  = rtrim($dir, '/\\');

        if (!is_dir($dir) && !mkdir($dir, 0775, true) && !is_dir($dir)) {
            throw new RuntimeException("Cannot create chat directory: {$dir}");
        }

        $base    = sprintf('%s_%s', $prefix, $stamp);
        $jsonPath = $dir . '/' . $base . '.json';
        $mdPath   = $dir . '/' . $base . '.md';

        $messages = array_map('normalize_chat_message', $chat);

        $payload = array_filter([
            'saved_at' => date('Y-m-d H:i:s'),
            'meta'     => $meta ?: null,
            'count'    => count($messages),
            'chat'     => $messages,
        ], fn ($v) => $v !== null);

        if (file_put_contents($jsonPath, json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n") === false) {
            throw new RuntimeException("Cannot write JSON file: {$jsonPath}");
        }

        $md = "# Chat Log\n\n";
        $md .= "- **Saved:** " . date('Y-m-d H:i:s') . "\n";
        foreach ($meta as $k => $v) {
            $md .= sprintf("- **%s:** %s\n", ucfirst((string) $k), is_scalar($v) ? $v : json_encode($v));
        }
        $md .= "- **Messages:** " . count($messages) . "\n\n---\n\n";

        foreach ($messages as $i => $m) {
            $role    = $m['role'];
            $content = $m['content'];
            $md .= sprintf("### %d. %s\n\n", $i + 1, ucfirst($role));
            $md .= is_string($content) ? $content . "\n" : json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
            $md .= "\n---\n\n";
        }

        if (file_put_contents($mdPath, $md) === false) {
            throw new RuntimeException("Cannot write markdown file: {$mdPath}");
        }

        return [
            'json'     => $jsonPath,
            'markdown' => $mdPath,
            'stamp'    => $stamp,
        ];
    }

    /**
     * Normalize any message shape into ['role' => ..., 'content' => ...].
     */
    function normalize_chat_message(mixed $msg): array
    {
        if (is_string($msg)) {
            return ['role' => 'unknown', 'content' => $msg];
        }
        if (!is_array($msg)) {
            return ['role' => 'unknown', 'content' => (string) $msg];
        }

        $role = $msg['role']
            ?? $msg['author']
            ?? $msg['type']
            ?? $msg['sender']
            ?? 'unknown';

        $content = $msg['content']
            ?? $msg['text']
            ?? $msg['message']
            ?? $msg['value']
            ?? '';

        if (is_array($content) && array_is_list($content)) {
            $parts = [];
            foreach ($content as $block) {
                if (is_array($block) && isset($block['text'])) {
                    $parts[] = $block['text'];
                } elseif (is_array($block) && isset($block['type']) && $block['type'] === 'text') {
                    $parts[] = $block['text'] ?? '';
                } else {
                    $parts[] = is_scalar($block) ? (string) $block : json_encode($block);
                }
            }
            $content = implode("\n", $parts);
        } elseif (is_array($content)) {
            $content = json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        } else {
            $content = (string) $content;
        }

        return ['role' => (string) $role, 'content' => $content];
    }
}

/*
 * CLI entry point — lets any external tool (opencode plugin, cron, script)
 * auto-save a full chat without writing PHP glue code:
 *
 *   php chat-saver.php <chat.json> [output-dir] [prefix] [meta.json]
 *
 * chat.json : array of messages (same shapes accepted by save_chat)
 * meta.json : optional metadata (e.g. {"tool":"opencode","session":"..."})
 * Output   : JSON with the written file paths.
 */
if (PHP_SAPI === 'cli' && isset($argv[0]) && basename($argv[0]) === 'chat-saver.php') {
    $inputFile = $argv[1] ?? null;

    if (!$inputFile) {
        // read chat from STDIN as fallback
        $stdin = stream_get_contents(STDIN);
        $chat  = $stdin ? json_decode($stdin, true) : null;
        $meta  = [];
    } else {
        if (!is_file($inputFile)) {
            fwrite(STDERR, "chat-saver: input file not found: {$inputFile}\n");
            exit(1);
        }
        $chat = json_decode((string) file_get_contents($inputFile), true);
        $meta = [];
        if (isset($argv[4]) && is_file($argv[4])) {
            $meta = json_decode((string) file_get_contents($argv[4]), true) ?: [];
        }
    }

    if (!is_array($chat)) {
        fwrite(STDERR, "chat-saver: chat must be a JSON array of messages\n");
        exit(1);
    }

    $dir    = $argv[2] ?? 'chat-logs';
    $prefix = $argv[3] ?? 'chat';

    try {
        $result = save_chat($chat, $meta, $dir, $prefix);
    } catch (\RuntimeException $e) {
        fwrite(STDERR, "chat-saver: {$e->getMessage()}\n");
        exit(1);
    }

    echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
    exit(0);
}
