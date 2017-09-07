<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\WordpressMigration;
use Doctrine\DBAL\Schema\Schema;


class PERPII_1142_20141020032012 extends WordpressMigration
{
    public function up(Schema $schema)
    {
        $pageChangePass = array(
            'post_name' => 'student',
            'post_content' => '[iwitness_special_student_pricing]',
            'post_title' => 'Special Student Pricing',
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
        $this->deletePageByName('student');
    }
}
