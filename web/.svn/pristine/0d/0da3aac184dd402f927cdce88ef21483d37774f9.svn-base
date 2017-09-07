<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\WordpressMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class PERPII_825_20140729091126 extends WordpressMigration
{
    public function up(Schema $schema)
    {
        //create change-password page
        $pageChangePass = array(
            'post_name' => 'change-password',
            'post_content' => '[iwitness_profile_change_password]',
            'post_title' => 'Change password',
            'page_template' => $this->getDefaultTemplate(),
            'post_type' => 'page',
            'post_status' => 'publish',
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_author' => 1,
        );

        $this->savePage($pageChangePass);

        $this->removePageParent('reset-password');
        $this->removePageParent('profile-edit');
        $this->removePageParent('change-number');
    }

    public function down(Schema $schema)
    {
        $this->deletePageByName('change-password');
    }

    private function  removePageParent($pageName)
    {
        $page = $this->getPageByName($pageName);
        if ($page) {
            $page->post_parent = 0;
            $this->updatePage($page, array());
        }
    }
}
