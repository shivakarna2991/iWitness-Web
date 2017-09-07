<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\WordpressMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class PERPII_1098_20140905113006 extends WordpressMigration
{
    public function up(Schema $schema)
    {
        global $wpdb;

        // landing page
        $filePath = '/static-content/PERPII_1098_20140905113006_Landing_Page.html';
        $post_name = 'content-landing-page';
        $content = $this->getStaticContent($filePath);

        $wpdb->query(
            $wpdb->prepare(
                "UPDATE wp_posts SET post_content=%s WHERE post_name = %s;",
                $content, $post_name
            )
        );

        // WSPTA landing page
        $filePath = '/static-content/PERPII_1098_20140905113006_WSPTA_Landing_Page.html';
        $post_name = 'wspta';
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
