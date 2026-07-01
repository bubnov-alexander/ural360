#!/usr/bin/env python3
import json
import sqlite3
import sys
from pathlib import Path


TABLES = [
    "admins",
    "routes",
    "orders",
    "catamaran_services",
    "transfer_services",
    "supboard_services",
    "settings",
]


def main() -> int:
    if len(sys.argv) != 3:
        print("Usage: export-yst-travel.py <database.db> <output.json>", file=sys.stderr)
        return 1

    source = Path(sys.argv[1]).resolve()
    output = Path(sys.argv[2]).resolve()

    if not source.exists():
        print(f"SQLite database not found: {source}", file=sys.stderr)
        return 1

    connection = sqlite3.connect(f"file:{source}?mode=ro", uri=True)
    connection.row_factory = sqlite3.Row

    payload = {
        "source": str(source),
        "tables": {},
    }

    for table in TABLES:
        rows = connection.execute(f'SELECT * FROM "{table}" ORDER BY id').fetchall()
        payload["tables"][table] = [dict(row) for row in rows]

    output.parent.mkdir(parents=True, exist_ok=True)
    output.write_text(json.dumps(payload, ensure_ascii=False, indent=2), encoding="utf-8")

    for table, rows in payload["tables"].items():
        print(f"{table}: {len(rows)}")

    return 0


if __name__ == "__main__":
    raise SystemExit(main())
