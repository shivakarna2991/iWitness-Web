<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\WordpressMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class PERPII_1025_20140903105333 extends WordpressMigration
{
    public function up(Schema $schema)
    {
        $pageChangePass = array(
            'post_name' => 'renewal-guidance',
            'post_content' => '[iwitness_renewal_guidance]',
            'post_title' => 'Renewal Guidance',
            'page_template' => $this->getDefaultTemplate(),
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
        $this->deletePageByName('renewal-guidance');
    }
}
