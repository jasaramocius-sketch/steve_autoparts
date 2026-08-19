import chokidar from 'chokidar';
import { execSync } from 'child_process';
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

/*
 * chat-watcher.mjs — generic transcript watcher for ANY AI tool.
 *
 * Watches a transcript/export file (or directory) and auto-saves the full
 * chat to chat-logs/ (JSON + markdown, date-time stamp) via chat-saver.php
 * whenever the transcript changes.
 *
 * Works with: Gemini CLI, Aider, Codex, Claude Code exports, Cursor chat
 * exports, Copilot exports — anything that writes a .jsonl / .json /
 * markdown transcript.
 *
 * Usage:
 *   node chat-watcher.mjs <transcript-file-or-dir> [output-dir] [prefix]
 *   node chat-watcher.mjs --once <file> [output-dir] [prefix]   (one-shot)
 *
 * Environment overrides: CHAT_WATCH_DIR, CHAT_OUTPUT_DIR, CHAT_PREFIX
 */

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const BASE = __dirname;
const PHP_SCRIPT = path.join(BASE, 'chat-saver.php');
const DEFAULT_OUTPUT = path.join(BASE, 'chat-logs');
const DEBOUNCE_MS = 2000;

const args = process.argv.slice(2);
const onceMode = args[0] === '--once';
const argsIdx = onceMode ? 1 : 0;

const target = args[argsIdx] || process.env.CHAT_WATCH_DIR;
const outputDir = args[argsIdx + 1] || process.env.CHAT_OUTPUT_DIR || DEFAULT_OUTPUT;
const prefix = args[argsIdx + 2] || process.env.CHAT_PREFIX || 'chat';

if (!target) {
  console.error('Usage: node chat-watcher.mjs <transcript-file-or-dir> [output-dir] [prefix]');
  process.exit(1);
}

const lastSignature = new Map();
const debounceTimers = new Map();

function normalizeMessage(raw) {
  if (typeof raw === 'string') return { role: 'unknown', content: raw };
  if (!raw || typeof raw !== 'object') return null;

  const role = raw.role || raw.author || raw.type || raw.sender || (raw.user ? 'user' : null) || 'unknown';

  let content = raw.content ?? raw.text ?? raw.message ?? raw.value ?? '';

  if (Array.isArray(content)) {
    content = content
      .map((block) => {
        if (typeof block === 'string') return block;
        if (block && typeof block === 'object') return block.text ?? block.content ?? '';
        return '';
      })
      .filter(Boolean)
      .join('\n');
  } else if (Array.isArray(raw.parts)) {
    content = raw.parts
      .map((p) => (p && typeof p === 'object' ? p.text ?? p.content ?? '' : ''))
      .filter(Boolean)
      .join('\n');
  } else if (content && typeof content === 'object') {
    content = JSON.stringify(content);
  }

  return { role: String(role), content: String(content) };
}

function parseTranscript(raw) {
  const trimmed = String(raw ?? '').trim();
  if (!trimmed) return [];

  if (trimmed.startsWith('[')) {
    try {
      return JSON.parse(trimmed).map(normalizeMessage).filter(Boolean);
    } catch (_) {}
  }

  const lines = trimmed.split('\n').map((l) => l.trim()).filter(Boolean);
  if (lines.every((l) => l.startsWith('{'))) {
    const out = [];
    for (const line of lines) {
      try {
        const msg = normalizeMessage(JSON.parse(line));
        if (msg) out.push(msg);
      } catch (_) {}
    }
    if (out.length) return out;
  }

  const out = [];
  let role = 'unknown';
  let buf = [];
  const HEADER = /^\s*(?:>)?\s*(?:###?\s*\d*\.?\s*)?\*{0,2}\s*(user|human|assistant|ai|system)\b[^:]*[:|]\s*\*{0,2}\s*(.*)$/i;
  const HEADER_ONLY = /^\s*(?:>)?\s*(?:###?\s*\d*\.?\s*)?\*{0,2}\s*(user|human|assistant|ai|system)\b[:|]?\s*$/i;
  for (const line of lines) {
    const m = line.match(HEADER);
    const roleMap = { user: 'user', human: 'user', assistant: 'assistant', ai: 'assistant', system: 'system' };
    if (m) {
      if (buf.length) out.push({ role, content: buf.join('\n') });
      role = roleMap[m[1].toLowerCase()] || 'unknown';
      buf = m[2].trim() ? [m[2].trim()] : [];
    } else if (HEADER_ONLY.test(line)) {
      if (buf.length) out.push({ role, content: buf.join('\n') });
      role = roleMap[HEADER_ONLY.exec(line)[1].toLowerCase()] || 'unknown';
      buf = [];
    } else {
      buf.push(line);
    }
  }
  if (buf.length) out.push({ role, content: buf.join('\n') });

  return out.filter((m) => m.content && m.content.trim());
}

function saveTranscript(filePath) {
  let raw;
  try {
    raw = fs.readFileSync(filePath, 'utf8');
  } catch (_) {
    return;
  }

  const chat = parseTranscript(raw);
  if (!chat.length) return;

  const signature = JSON.stringify(chat);
  if (lastSignature.get(filePath) === signature) return;
  lastSignature.set(filePath, signature);

  const tmp = path.join(BASE, '.chat-watcher-tmp.json');
  fs.writeFileSync(tmp, JSON.stringify(chat));

  try {
    const out = execSync(
      `php ${JSON.stringify(PHP_SCRIPT)} ${JSON.stringify(tmp)} ${JSON.stringify(outputDir)} ${JSON.stringify(prefix)}`,
      { cwd: BASE, encoding: 'utf8' }
    );
    const result = JSON.parse(out || '{}');
    console.log(
      `[chat-watcher] ${new Date().toISOString()} saved ${path.basename(filePath)} -> ${result.json}`
    );
  } catch (e) {
    console.error('[chat-watcher] save failed:', e.message);
  } finally {
    fs.unlinkSync(tmp);
  }
}

function schedule(filePath) {
  if (debounceTimers.has(filePath)) clearTimeout(debounceTimers.get(filePath));
  debounceTimers.set(
    filePath,
    setTimeout(() => {
      debounceTimers.delete(filePath);
      saveTranscript(filePath);
    }, DEBOUNCE_MS)
  );
}

if (onceMode) {
  saveTranscript(target);
  process.exit(0);
}

let watchTarget = target;
if (fs.existsSync(target) && fs.statSync(target).isDirectory()) {
  watchTarget = path.join(target, '**/*.{jsonl,json,md,txt}');
}

const watcher = chokidar.watch(watchTarget, {
  persistent: true,
  ignoreInitial: true,
  awaitWriteFinish: { stabilityThreshold: 800, pollInterval: 150 },
});

watcher.on('add', schedule).on('change', schedule);

console.log(`[chat-watcher] watching: ${target}`);
console.log(`[chat-watcher] output:    ${outputDir} (prefix: ${prefix})`);
console.log(`[chat-watcher] press Ctrl+C to stop`);

process.on('SIGINT', () => watcher.close().then(() => process.exit(0)));
process.on('SIGTERM', () => watcher.close().then(() => process.exit(0)));
