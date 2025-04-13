#!/bin/bash
set -e

echo "=== Running PHP Syntax Checks ==="

EXIT_CODE=0
FILES=$(find . -type f -name '*.php' -not -path "./vendor/*")
for file in $FILES; do
  output=$(php -l "$file")
  if [[ $output != *"No syntax errors detected"* ]]; then
    echo "Syntax error in $file"
    EXIT_CODE=1
  else
    echo "Syntax OK: $file"
  fi
done

if [ $EXIT_CODE -ne 0 ]; then
  echo "One or more PHP files contain syntax errors."
  exit 1
fi

echo "PHP syntax check passed!"

echo "=== Starting PHP Built-in Server for Functional Testing ==="
php -S localhost:8000 > /dev/null 2>&1 &
SERVER_PID=$!

sleep 2

echo "=== Running HTTP Test on index.php ==="
HTTP_CODE=$(curl -o /dev/null -s -w "%{http_code}" http://localhost:8000/index.php)

kill $SERVER_PID

if [ "$HTTP_CODE" -eq 200 ]; then
  echo "HTTP test passed with status code $HTTP_CODE!"
else
  echo "HTTP test failed, received status code $HTTP_CODE."
  exit 1
fi

echo "All tests passed successfully!"
exit 0
