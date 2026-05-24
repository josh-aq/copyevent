Migration folder: place ordered SQL files here.

Usage (CLI with PHP):

1. From the project root, run:

   php tools/migrate.php

2. The script uses config/db.php to connect to MySQL (DB credentials set there).

Notes:
- The script executes each .sql file in lexical order.
- If a migration fails, the script stops and outputs the error.
- Review SQL files before running in production.
