<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\WordpressMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class PERPII_903_20140807033745 extends WordpressMigration
{
    public function up(Schema $schema)
    {
        global $wpdb;

        $filePath = '/static-content/PERPII-903_20140807033745.html';
        $post_name = 'content-contact';
        $content = $this->getStaticContent($filePath);

        $wpdb->query(
            $wpdb->prepare(
                "UPDATE wp_posts SET post_content=%s WHERE post_name = %s;",
                $content, $post_name
            )
        );
    }

    public function down(Schema $schema)
    {


    }

    /**
     * Get the content of static content page
     *
     * @param $filePath
     * @return null|string
     */
    private function getStaticContent($filePath)
    {
        $fullFilePath = realpath(dirname(__FILE__)) . $filePath;

        $content = null;
        if ($fh = fopen($fullFilePath, "r")) {
            $content = fread($fh, readfile($fullFilePath));
            fclose($fh);
        }

        return $content;
    }
}
