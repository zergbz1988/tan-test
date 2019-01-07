<?php declare(strict_types=1);

namespace App\Db\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Migrations\Version;
/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181227195456 extends AbstractMigration
{
    /**
     * Version20181227195456 constructor.
     * @param Version $version
     * @throws \Doctrine\DBAL\DBALException
     */
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->platform->registerDoctrineTypeMapping('enum', 'string');
        $this->platform->registerDoctrineTypeMapping('bit', 'boolean');
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('dealers');
        $table
            ->addColumn('id', Type::INTEGER)
            ->setLength(11)
            ->setUnsigned(true)
            ->setNotnull(true)
            ->setAutoincrement(true)
            ->setComment('ID');
        $table
            ->addColumn('name', Type::STRING)
            ->setLength(128)
            ->setNotnull(true)
            ->setComment('Название');
        $table
            ->addColumn('address', Type::TEXT)
            ->setNotnull(true)
            ->setComment('Адрес');

        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['name'], 'UIDX_dealers_name');
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('dealers');
    }
}
