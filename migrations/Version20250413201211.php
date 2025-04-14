<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250413201211 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Initial';
    }

    public function up(Schema $schema) : void
    {
        switch ($this->connection->getDatabasePlatform()->getName()) {
            case 'postgresql':
                $this->addSql('CREATE TABLE article (id SERIAL PRIMARY KEY, precursor_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, amount INT NOT NULL, active BOOLEAN NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, usage_count INT NOT NULL)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E66FA546BCC ON article (precursor_id)');
                $this->addSql('CREATE TABLE article_tag (id SERIAL PRIMARY KEY, article_id INT DEFAULT NULL, tag_id INT DEFAULT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL)');
                $this->addSql('CREATE INDEX IDX_919694F97294869C ON article_tag (article_id)');
                $this->addSql('CREATE INDEX IDX_919694F9BAD26311 ON article_tag (tag_id)');
                $this->addSql('CREATE UNIQUE INDEX article_tag_unique_idx ON article_tag (article_id, tag_id)');
                $this->addSql('CREATE TABLE barcode (id SERIAL PRIMARY KEY, article_id INT DEFAULT NULL, barcode VARCHAR(32) NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL)');
                $this->addSql('CREATE INDEX IDX_97AE02667294869C ON barcode (article_id)');
                $this->addSql('CREATE UNIQUE INDEX barcode_unique_idx ON barcode (barcode)');
                $this->addSql('CREATE TABLE tag (id SERIAL PRIMARY KEY, tag VARCHAR(255) NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL)');
                $this->addSql('CREATE TABLE transactions (id SERIAL PRIMARY KEY, user_id INT NOT NULL, article_id INT DEFAULT NULL, recipient_transaction_id INT DEFAULT NULL, sender_transaction_id INT DEFAULT NULL, quantity INT DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, amount INT NOT NULL, deleted BOOLEAN NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL)');
                $this->addSql('CREATE INDEX IDX_EAA81A4CA76ED395 ON transactions (user_id)');
                $this->addSql('CREATE INDEX IDX_EAA81A4C7294869C ON transactions (article_id)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_EAA81A4C87F3EDB8 ON transactions (recipient_transaction_id)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_EAA81A4CFE2C36CC ON transactions (sender_transaction_id)');
                $this->addSql('CREATE TABLE "user" (id SERIAL PRIMARY KEY, name VARCHAR(64) NOT NULL, email VARCHAR(255) DEFAULT NULL, balance INT NOT NULL, disabled BOOLEAN NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6495E237E06 ON "user" (name)');
                $this->addSql('CREATE INDEX disabled_updated ON "user" (disabled, updated)');
                $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66FA546BCC FOREIGN KEY (precursor_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
                $this->addSql('ALTER TABLE article_tag ADD CONSTRAINT FK_919694F97294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
                $this->addSql('ALTER TABLE article_tag ADD CONSTRAINT FK_919694F9BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
                $this->addSql('ALTER TABLE barcode ADD CONSTRAINT FK_97AE02667294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
                $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
                $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C7294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
                $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C87F3EDB8 FOREIGN KEY (recipient_transaction_id) REFERENCES transactions (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
                $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CFE2C36CC FOREIGN KEY (sender_transaction_id) REFERENCES transactions (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
                break;
            case 'sqlite':
                $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, precursor_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, amount INTEGER NOT NULL, active BOOLEAN NOT NULL, created DATETIME NOT NULL, usage_count INTEGER NOT NULL)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E66FA546BCC ON article (precursor_id)');
                $this->addSql('CREATE TABLE article_tag (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, article_id INTEGER DEFAULT NULL, tag_id INTEGER DEFAULT NULL, created DATETIME NOT NULL)');
                $this->addSql('CREATE INDEX IDX_919694F97294869C ON article_tag (article_id)');
                $this->addSql('CREATE INDEX IDX_919694F9BAD26311 ON article_tag (tag_id)');
                $this->addSql('CREATE UNIQUE INDEX article_tag_unique_idx ON article_tag (article_id, tag_id)');
                $this->addSql('CREATE TABLE barcode (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, article_id INTEGER DEFAULT NULL, barcode VARCHAR(32) NOT NULL, created DATETIME NOT NULL)');
                $this->addSql('CREATE INDEX IDX_97AE02667294869C ON barcode (article_id)');
                $this->addSql('CREATE UNIQUE INDEX barcode_unique_idx ON barcode (barcode)');
                $this->addSql('CREATE TABLE tag (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tag VARCHAR(255) NOT NULL, created DATETIME NOT NULL)');
                $this->addSql('CREATE TABLE transactions (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, article_id INTEGER DEFAULT NULL, recipient_transaction_id INTEGER DEFAULT NULL, sender_transaction_id INTEGER DEFAULT NULL, quantity INTEGER DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, amount INTEGER NOT NULL, deleted BOOLEAN NOT NULL, created DATETIME NOT NULL)');
                $this->addSql('CREATE INDEX IDX_EAA81A4CA76ED395 ON transactions (user_id)');
                $this->addSql('CREATE INDEX IDX_EAA81A4C7294869C ON transactions (article_id)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_EAA81A4C87F3EDB8 ON transactions (recipient_transaction_id)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_EAA81A4CFE2C36CC ON transactions (sender_transaction_id)');
                $this->addSql('CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(64) NOT NULL, email VARCHAR(255) DEFAULT NULL, balance INTEGER NOT NULL, disabled BOOLEAN NOT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6495E237E06 ON "user" (name)');
                $this->addSql('CREATE INDEX disabled_updated ON "user" (disabled, updated)');
                break;
            case 'mysql':
                $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT PRIMARY KEY, precursor_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, amount INT NOT NULL, active TINYINT(1) NOT NULL, created DATETIME NOT NULL, usage_count INT NOT NULL, UNIQUE INDEX UNIQ_23A0E66FA546BCC (precursor_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
                $this->addSql('CREATE TABLE article_tag (id INT AUTO_INCREMENT PRIMARY KEY, article_id INT DEFAULT NULL, tag_id INT DEFAULT NULL, created DATETIME NOT NULL, INDEX IDX_919694F97294869C (article_id), INDEX IDX_919694F9BAD26311 (tag_id), UNIQUE INDEX article_tag_unique_idx (article_id, tag_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
                $this->addSql('CREATE TABLE barcode (id INT AUTO_INCREMENT PRIMARY KEY, article_id INT DEFAULT NULL, barcode VARCHAR(32) NOT NULL, created DATETIME NOT NULL, INDEX IDX_97AE02667294869C (article_id), UNIQUE INDEX barcode_unique_idx (barcode)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
                $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT PRIMARY KEY, tag VARCHAR(255) NOT NULL, created DATETIME NOT NULL) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
                $this->addSql('CREATE TABLE transactions (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, article_id INT DEFAULT NULL, recipient_transaction_id INT DEFAULT NULL, sender_transaction_id INT DEFAULT NULL, quantity INT DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, amount INT NOT NULL, deleted TINYINT(1) NOT NULL, created DATETIME NOT NULL, INDEX IDX_EAA81A4CA76ED395 (user_id), INDEX IDX_EAA81A4C7294869C (article_id), UNIQUE INDEX UNIQ_EAA81A4C87F3EDB8 (recipient_transaction_id), UNIQUE INDEX UNIQ_EAA81A4CFE2C36CC (sender_transaction_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
                $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(64) NOT NULL, email VARCHAR(255) DEFAULT NULL, balance INT NOT NULL, disabled TINYINT(1) NOT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D6495E237E06 (name), INDEX disabled_updated (disabled, updated)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
                $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66FA546BCC FOREIGN KEY (precursor_id) REFERENCES article (id)');
                $this->addSql('ALTER TABLE article_tag ADD CONSTRAINT FK_919694F97294869C FOREIGN KEY (article_id) REFERENCES article (id)');
                $this->addSql('ALTER TABLE article_tag ADD CONSTRAINT FK_919694F9BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
                $this->addSql('ALTER TABLE barcode ADD CONSTRAINT FK_97AE02667294869C FOREIGN KEY (article_id) REFERENCES article (id)');
                $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
                $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
                $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C87F3EDB8 FOREIGN KEY (recipient_transaction_id) REFERENCES transactions (id) ON DELETE CASCADE');
                $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CFE2C36CC FOREIGN KEY (sender_transaction_id) REFERENCES transactions (id) ON DELETE CASCADE');
                break;
            default:
                $this->abort('Unsupported database platform: ' . $this->connection->getDatabasePlatform()->getName());
        }
    }

    public function down(Schema $schema) : void
    {
        switch ($this->connection->getDatabasePlatform()->getName()) {
            case 'postgresql':
                $this->addSql('CREATE SCHEMA public');
                $this->addSql('ALTER TABLE article DROP CONSTRAINT FK_23A0E66FA546BCC');
                $this->addSql('ALTER TABLE article_tag DROP CONSTRAINT FK_919694F97294869C');
                $this->addSql('ALTER TABLE barcode DROP CONSTRAINT FK_97AE02667294869C');
                $this->addSql('ALTER TABLE transactions DROP CONSTRAINT FK_EAA81A4C7294869C');
                $this->addSql('ALTER TABLE article_tag DROP CONSTRAINT FK_919694F9BAD26311');
                $this->addSql('ALTER TABLE transactions DROP CONSTRAINT FK_EAA81A4C87F3EDB8');
                $this->addSql('ALTER TABLE transactions DROP CONSTRAINT FK_EAA81A4CFE2C36CC');
                $this->addSql('ALTER TABLE transactions DROP CONSTRAINT FK_EAA81A4CA76ED395');
                $this->addSql('DROP TABLE article');
                $this->addSql('DROP TABLE article_tag');
                $this->addSql('DROP TABLE barcode');
                $this->addSql('DROP TABLE tag');
                $this->addSql('DROP TABLE transactions');
                $this->addSql('DROP TABLE "user"');
                break;
            case 'sqlite':
                $this->addSql('DROP TABLE article');
                $this->addSql('DROP TABLE article_tag');
                $this->addSql('DROP TABLE barcode');
                $this->addSql('DROP TABLE tag');
                $this->addSql('DROP TABLE transactions');
                $this->addSql('DROP TABLE "user"');
                break;
            case 'mysql':
                $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66FA546BCC');
                $this->addSql('ALTER TABLE article_tag DROP FOREIGN KEY FK_919694F97294869C');
                $this->addSql('ALTER TABLE barcode DROP FOREIGN KEY FK_97AE02667294869C');
                $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4C7294869C');
                $this->addSql('ALTER TABLE article_tag DROP FOREIGN KEY FK_919694F9BAD26311');
                $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4C87F3EDB8');
                $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CFE2C36CC');
                $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CA76ED395');
                $this->addSql('DROP TABLE article');
                $this->addSql('DROP TABLE article_tag');
                $this->addSql('DROP TABLE barcode');
                $this->addSql('DROP TABLE tag');
                $this->addSql('DROP TABLE transactions');
                $this->addSql('DROP TABLE `user`');
                break;
            default:
                $this->abort('Unsupported database platform: ' . $this->connection->getDatabasePlatform()->getName());
        }
    }
}
