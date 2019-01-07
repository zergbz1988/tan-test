<?php declare(strict_types=1);

namespace App\Db\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\Version;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181227200146 extends AbstractMigration
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
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('cars');
        $table
            ->addColumn('id', Type::INTEGER)
            ->setLength(11)
            ->setUnsigned(true)
            ->setNotnull(true)
            ->setAutoincrement(true)
            ->setComment('ID');
        $table
            ->addColumn('make', Type::STRING)
            ->setLength(128)
            ->setNotnull(true)
            ->setComment('Марка');
        $table
            ->addColumn('model', Type::STRING)
            ->setLength(128)
            ->setNotnull(true)
            ->setComment('Модель');
        $table
            ->addColumn('componentry', Type::TEXT)
            ->setNotnull(true)
            ->setLength(512)
            ->setComment('Комплектация');
        $table
            ->addColumn('price', Type::INTEGER)
            ->setUnsigned(true)
            ->setNotnull(true)
            ->setComment('Цена');
        $table
            ->addColumn('vin', Type::STRING)
            ->setLength(17)
            ->setNotnull(true)
            ->setComment('VIN-номер');
        $table
            ->addColumn('dealer_id', Type::INTEGER)
            ->setLength(11)
            ->setUnsigned(true)
            ->setNotnull(false)
            ->setComment('ID дилера, у которого продаётся данный авто');

        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['vin'], 'UIDX_cars_vin');
        $table->addIndex(['make', 'model', 'componentry'], 'IDX_cars_mmc', [], ['lengths' => [128, 128, 512]]);

        $table->addIndex(['dealer_id'], 'IDX_c_at_d_dealer_id');

        $table->addForeignKeyConstraint('dealers', ['dealer_id'], ['id'], [
            'onUpdate' => 'SET NULL',
            'onDelete' => 'SET NULL'
        ], 'FK_cars_dealer_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $schema->dropTable('cars_at_dealers');
        $schema->dropTable('cars');
    }
}
