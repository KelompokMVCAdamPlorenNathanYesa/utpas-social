#!/bin/bash

DB_PATH="/var/www/html/database/database.db"
SQL_FILE="/var/www/html/database/utpas-social.sql"

# Buat database jika belum ada
if [ ! -f "$DB_PATH" ]; then
  echo "Creating SQLite database..."
  if [ -f "$SQL_FILE" ]; then
    sqlite3 "$DB_PATH" < "$SQL_FILE"
    echo "Database created from $SQL_FILE"
  else
    echo "SQL file not found at $SQL_FILE"
  fi
else
  echo "Database already exists at $DB_PATH"
fi

# Start Apache
exec apache2-foreground
