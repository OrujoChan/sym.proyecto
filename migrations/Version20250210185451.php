<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250210185451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carta ADD usuario_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE carta ADD CONSTRAINT FK_BDB93BE4DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('CREATE INDEX IDX_BDB93BE4DB38439E ON carta (usuario_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carta DROP FOREIGN KEY FK_BDB93BE4DB38439E');
        $this->addSql('DROP INDEX IDX_BDB93BE4DB38439E ON carta');
        $this->addSql('ALTER TABLE carta DROP usuario_id');
    }
}
