#!/usr/bin/env bash
# Usage: ./production/up.sh [docker compose up args...]
#
# For ~/.bashrc (aliases run from any directory). Set DUMPRES_ROOT to the
# repository root (parent of production/). Example:
#   export DUMPRES_ROOT="$HOME/path/to/dumpres-renext"
#   alias dumpres-up='bash "$DUMPRES_ROOT/production/up.sh"'
set -euo pipefail

if [[ -n "${DUMPRES_ROOT:-}" ]]; then
  ROOT="$(cd "$DUMPRES_ROOT" && pwd)"
else
  SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
  ROOT="$(cd "${SCRIPT_DIR}/.." && pwd)"
fi

cd "$ROOT"
docker compose -f production/compose.app.yaml up "$@"
