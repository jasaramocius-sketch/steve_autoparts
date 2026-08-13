#!/usr/bin/env python3
"""
save-opencode-session.py — save an opencode session's full chat to disk
using chat-saver.php (JSON + markdown with date-time stamp).

Usage:
    python3 save-opencode-session.py                       # current project, latest session
    python3 save-opencode-session.py <session-id>          # specific session
    python3 save-opencode-session.py <session-id> <dir> <prefix>

Finds the opencode SQLite DB automatically (checks the active data dirs),
extracts messages + parts, and pipes them into chat-saver.php.
"""

import json
import os
import sqlite3
import subprocess
import sys
from datetime import datetime

BASE = os.path.dirname(os.path.abspath(__file__))
PHP_SCRIPT = os.path.join(BASE, "chat-saver.php")
OUTPUT_DIR = os.path.join(BASE, "chat-logs")

CANDIDATE_DBS = [
    os.path.join(os.environ.get("XDG_DATA_HOME", ""), "opencode", "opencode.db"),
    os.path.expanduser("~/.local/share/opencode/opencode.db"),
    os.path.expanduser("~/.local/state/opencode/opencode.db"),
]

TOOL_OUTPUT_MAX = int(os.environ.get("CHAT_TOOL_OUTPUT_MAX", "3000"))
SKIP_ROLES = {"system"}


def find_db():
    candidates = [p for p in CANDIDATE_DBS if p and os.path.isfile(p)]
    if not candidates:
        return None
    return max(candidates, key=lambda p: os.path.getmtime(p))


def pick_session(con, session_id=None, directory=None):
    cur = con.cursor()
    if session_id:
        cur.execute("SELECT id, title, directory FROM session WHERE id=?", (session_id,))
    else:
        cur.execute(
            "SELECT id, title, directory FROM session WHERE directory=? "
            "ORDER BY time_updated DESC LIMIT 1",
            (directory,),
        )
    row = cur.fetchone()
    return row


def format_tool(part):
    state = part.get("state", {})
    tool = part.get("tool", "unknown")
    status = state.get("status", "")
    lines = [f"[tool:{tool} ({status})]"]
    inp = state.get("input")
    if inp is not None:
        lines.append("Input: " + json.dumps(inp, ensure_ascii=False)[:2000])
    out = state.get("output", "")
    if isinstance(out, (dict, list)):
        out = json.dumps(out, ensure_ascii=False)
    if out:
        out = str(out)
        if len(out) > TOOL_OUTPUT_MAX:
            out = out[:TOOL_OUTPUT_MAX] + "\n...[truncated]"
        lines.append("Output: " + out)
    return "\n".join(lines)


def build_chat(con, sid):
    cur = con.cursor()
    cur.execute("SELECT id, data FROM message WHERE session_id=? ORDER BY time_created", (sid,))
    messages = cur.fetchall()
    chat = []
    for mid, data in messages:
        info = json.loads(data)
        role = info.get("role", "unknown")
        if role in SKIP_ROLES:
            continue

        cur.execute("SELECT data FROM part WHERE message_id=? ORDER BY time_created", (mid,))
        parts = [json.loads(p[0]) for p in cur.fetchall()]

        content_parts = []
        for part in parts:
            ptype = part.get("type")
            if ptype == "text" and part.get("text"):
                text = part["text"]
                content_parts.append(text if isinstance(text, str) else json.dumps(text, ensure_ascii=False))
            elif ptype == "tool" and part.get("state"):
                content_parts.append(format_tool(part))
            # reasoning / step-start / step-finish / snapshot are skipped

        if not content_parts and info.get("summary"):
            content_parts.append(
                info["summary"] if isinstance(info["summary"], str) else json.dumps(info["summary"], ensure_ascii=False)
            )

        content_parts = [
            c if isinstance(c, str) else json.dumps(c, ensure_ascii=False)
            for c in content_parts
        ]
        content = "\n\n".join(content_parts).strip()
        if content:
            chat.append({"role": role, "content": content})
    return chat


def main():
    args = sys.argv[1:]
    session_id = args[0] if len(args) > 0 else None
    out_dir = args[1] if len(args) > 1 else OUTPUT_DIR
    prefix = args[2] if len(args) > 2 else "opencode"

    db = find_db()
    if not db:
        print("ERROR: no opencode DB found", file=sys.stderr)
        sys.exit(1)

    con = sqlite3.connect(f"file:{db}?mode=ro", uri=True)
    try:
        row = pick_session(con, session_id, BASE)
        if not row:
            print(f"ERROR: session not found: {session_id or BASE}", file=sys.stderr)
            sys.exit(1)
        sid, title, _ = row

        chat = build_chat(con, sid)
        if not chat:
            print("ERROR: no chat messages found", file=sys.stderr)
            sys.exit(1)

        tmp = os.path.join(BASE, ".opencode-session-tmp.json")
        meta = os.path.join(BASE, ".opencode-session-meta.json")
        with open(tmp, "w") as f:
            json.dump(chat, f, ensure_ascii=False)
        with open(meta, "w") as f:
            json.dump({"tool": "opencode", "session": sid, "title": title}, f, ensure_ascii=False)

        proc = subprocess.run(
            ["php", PHP_SCRIPT, tmp, out_dir, prefix, meta],
            capture_output=True,
            text=True,
            cwd=BASE,
        )
        if proc.returncode != 0:
            print("ERROR:", proc.stderr.strip(), file=sys.stderr)
            sys.exit(1)
        print(proc.stdout.strip())
        os.unlink(tmp)
        os.unlink(meta)
    finally:
        con.close()


if __name__ == "__main__":
    main()
