<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\WordpressMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class PERPII_957_20140813100757 extends WordpressMigration
{
    public function up(Schema $schema)
    {
        global $wpdb;

        $postName = "content-contacts";
        $content = "[iwitness_contact_list]";

        $wpdb->query(
            $wpdb->prepare(
                "UPDATE wp_posts SET post_content=%s WHERE post_name = %s;",
                $content, $postName
            )
        );
    }

    public function down(Schema $schema)
    {
    }
}
