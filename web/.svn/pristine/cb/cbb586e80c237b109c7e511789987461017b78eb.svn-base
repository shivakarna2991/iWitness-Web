<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\WordpressMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class PERPII_744_20140804131801 extends WordpressMigration
{
    public function up(Schema $schema)
    {
        $this->createPage(
            array(
                'post_content' => '[iwitness_friend_connect]',
                'post_type' => 'page',
                'post_status' => 'publish',
                'page_template' => $this->getDefaultTemplate(),
                'post_name' => 'friend-connect',
                'post_title' => 'Contact Confirmation',
            )
        );

        $this->createPage(
            array(
                'post_content' => '[iwitness_friend_connected]',
                'post_type' => 'page',
                'post_status' => 'publish',
                'page_template' => $this->getDefaultTemplate(),
                'post_name' => 'friend-connected',
                'post_title' => 'Contact Confirmation',
            )
        );

        $this->createPage(
            array(
                'post_content' => '[iwitness_friend_alert]',
                'post_type' => 'page',
                'post_status' => 'publish',
                'page_template' => $this->getDefaultTemplate(),
                'post_name' => 'friend-alert',
                'post_title' => 'Alert Information',
            )
        );
    }

    public function down(Schema $schema)
    {
        $this->deletePageByName('friend-connect');
        $this->deletePageByName('friend-connected');
        $this->deletePageByName('friend-alert');
    }
}
