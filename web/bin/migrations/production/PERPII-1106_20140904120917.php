<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\WordpressMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class PERPII_1106_20140904120917 extends WordpressMigration
{
    public function up(Schema $schema)
    {
        $pageChangePass = array(
            'post_name' => 'wspta-buy-now',
            'post_content' => '[iwitness_special_washington_state_pta_pricing]',
            'post_title' => 'Washington State PTA buy now',
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
        $this->deletePageByName('wspta-buy-now');
    }
}
