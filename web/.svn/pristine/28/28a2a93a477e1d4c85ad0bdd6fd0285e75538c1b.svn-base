<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\WordpressMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class PERPII_1146_20141111065221 extends WordpressMigration
{
    public function up(Schema $schema)
    {
        $pageChangePass = array(
            'post_name' => 'promo',
            'post_content' => '[iwitness_special_promo_pricing]',
            'post_title' => 'Special Promotion Pricing',
            'post_type' => 'page',
            'post_status' => 'publish',
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_author' => 1,
            'page_template' => $this->getDefaultTemplate(),
        );
        $this->savePage($pageChangePass);
    }

    public function down(Schema $schema)
    {
        $this->deletePageByName('promo');
    }
}
