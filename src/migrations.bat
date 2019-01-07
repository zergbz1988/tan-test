@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/vendor/doctrine/migrations/bin/doctrine-migrations
php "%BIN_TARGET%" migrations:%* --db-configuration app\config\packages\doctrine\db.php --configuration app\config\packages\doctrine\migrations.yml --no-interaction
