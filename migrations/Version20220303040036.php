<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220303040036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE score DROP FOREIGN KEY FK_32993751CB944F1A');
        $this->addSql('ALTER TABLE score DROP FOREIGN KEY FK_3299375123EDC87');
        $this->addSql('DROP INDEX IDX_32993751CB944F1A ON score');
        $this->addSql('DROP INDEX IDX_3299375123EDC87 ON score');
        $this->addSql('ALTER TABLE score DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE score ADD student INT NOT NULL, ADD subject INT NOT NULL, DROP student_id, DROP subject_id');
        $this->addSql('ALTER TABLE score ADD PRIMARY KEY (student, subject)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE score DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE score ADD student_id INT NOT NULL, ADD subject_id INT NOT NULL, DROP student, DROP subject');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT FK_32993751CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT FK_3299375123EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id)');
        $this->addSql('CREATE INDEX IDX_32993751CB944F1A ON score (student_id)');
        $this->addSql('CREATE INDEX IDX_3299375123EDC87 ON score (subject_id)');
        $this->addSql('ALTER TABLE score ADD PRIMARY KEY (student_id, subject_id)');
    }
}
