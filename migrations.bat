@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/vendor/doctrine/migrations/bin/doctrine-migrations
php "%BIN_TARGET%" migrations:%* --db-configuration app\db\doctrine-migrations\db.php --configuration app\db\doctrine-migrations\config.yml --no-interaction
