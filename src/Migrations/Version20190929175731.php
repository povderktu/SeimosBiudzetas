<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190929175731 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE expanse (id INT AUTO_INCREMENT NOT NULL, member_id INT DEFAULT NULL, pavadinimas VARCHAR(255) NOT NULL, suma DOUBLE PRECISION NOT NULL, INDEX IDX_A2581AF17597D3FE (member_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `member` (id INT AUTO_INCREMENT NOT NULL, reason VARCHAR(255) DEFAULT NULL, dabartinis_limitas DOUBLE PRECISION DEFAULT NULL, username VARCHAR(191) NOT NULL, password VARCHAR(64) NOT NULL, role INT NOT NULL, limitas DOUBLE PRECISION NOT NULL, busena VARCHAR(30) NOT NULL, UNIQUE INDEX UNIQ_70E4FA78F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE expanse ADD CONSTRAINT FK_A2581AF17597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE expanse DROP FOREIGN KEY FK_A2581AF17597D3FE');
        $this->addSql('DROP TABLE expanse');
        $this->addSql('DROP TABLE `member`');
    }
}
