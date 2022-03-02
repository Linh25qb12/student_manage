<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220302043506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE score DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE score CHANGE subject_id subject_id INT NOT NULL');
        $this->addSql('ALTER TABLE score ADD PRIMARY KEY (student_id, subject_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE score DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE score CHANGE subject_id subject_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE score ADD PRIMARY KEY (score, student_id)');
    }
}
