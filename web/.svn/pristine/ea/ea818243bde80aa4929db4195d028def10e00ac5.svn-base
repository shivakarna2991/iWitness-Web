<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\WordpressMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class PERPII_1105_20140904103858 extends WordpressMigration
{
    public function up(Schema $schema)
    {
        $pageChangePass = array(
            'post_name' => 'wspta',
            'post_content' => '',
            'post_title' => 'Washington State PTA Landing Page',
            'post_type' => 'page',
            'post_status' => 'publish',
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_author' => 1,
        );

        $this->savePage($pageChangePass);
    }

    public function down(Schema $schema)
    {
        $this->deletePageByName('wspta');
    }
}
