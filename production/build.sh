#!/usr/bin/env bash
# Usage: ./production/build.sh <tag>
# Example: ./production/build.sh v1.0.0
#
# For ~/.bashrc:
#   export DUMPRES_ROOT="$HOME/path/to/dumpres-renext"
#   alias dumpres-build='bash "$DUMPRES_ROOT/production/build.sh"'
set -euo pipefail

TAG="${1:?Usage: $0 <tag> (example: $0 v1.0.0)}"

if [[ -n "${DUMPRES_ROOT:-}" ]]; then
  ROOT="$(cd "$DUMPRES_ROOT" && pwd)"
else
  SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
  ROOT="$(cd "${SCRIPT_DIR}/.." && pwd)"
fi

cd "$ROOT"

# Shell env wins over production/.env; image name matches compose image: line.
APP_TAG="${TAG}" docker compose -f production/compose.app.yaml build app

docker tag "akhirrijal:${TAG}" akhirrijal:latest
