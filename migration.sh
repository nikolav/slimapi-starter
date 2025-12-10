#!/usr/bin/env bash

# ------------------------------------------------------------
# Migration generator for Slim + Eloquent
# Filename format:
#   <TIMESTAMP>_<lowercased_joined_arguments>.php
#
# Example:
#   ./create_migration.sh Create Users Table
# Generates:
#   database/migrations/2025_01_10_201530_create_users_table.php
# ------------------------------------------------------------

# Ensure arguments exist
if [ $# -lt 1 ]; then
  echo "Usage: $0 <migration name words>"
  echo "Example: $0 Create Users Table"
  exit 1
fi

MIGRATIONS_DIR="database/migrations"
mkdir -p "$MIGRATIONS_DIR"

# Convert all args to lowercase and join with underscores
ACTION=$(printf "%s_" "$@" | tr '[:upper:]' '[:lower:]' | sed 's/_$//')

# Timestamp format identical to Laravel: YYYY_MM_DD_HHMMSS
TIMESTAMP=$(date +"%Y_%m_%d_%H%M%S")

# Final filename
FILENAME="${TIMESTAMP}_${ACTION}.php"
FILEPATH="${MIGRATIONS_DIR}/${FILENAME}"

# Create migration file
cat <<EOF > "$FILEPATH"
<?php

use Illuminate\\Database\\Capsule\\Manager as Capsule;
use Illuminate\\Database\\Schema\\Blueprint;

return new class {
    public function up()
    {
        // TODO: Define schema changes here
        // Example:
        // Capsule::schema()->create('table_name', function (Blueprint \$table) {
        //     \$table->increments('id');
        //     \$table->timestamps();
        // });
    }

    public function down()
    {
        // TODO: Reverse schema changes here
        // Example:
        // Capsule::schema()->dropIfExists('table_name');
    }
};
EOF

echo "✔ Migration created at: $FILEPATH"
