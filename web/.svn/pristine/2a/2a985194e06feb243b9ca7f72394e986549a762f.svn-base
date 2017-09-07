<?php namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\WordpressMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class PERPII_1038_20140827071936 extends WordpressMigration
{
    public function up(Schema $schema)
    {
        global $wpdb;

        // update crime stats page
        $filePath = '/static-content/PERPII-1038_20140827071936.html';
        $content = $this->getStaticContent($filePath);
        $post_name = 'content-crime-stats';

        $wpdb->query(
            $wpdb->prepare(
                "UPDATE wp_posts SET post_content=%s WHERE post_name = %s;",
                $content, $post_name
            )
        );

        // update term of use page
        $filePath = '/static-content/PERPII-1038_20140827071936_TermOfUse.html';
        $content = $this->getStaticContent($filePath);
        $post_name = 'content-terms-of-use';

        $wpdb->query(
            $wpdb->prepare(
                "UPDATE wp_posts SET post_content=%s WHERE post_name = %s;",
                $content, $post_name
            )
        );

        // update end user license page
        $filePath = '/static-content/PERPII-1038_20140827071936_EndUserLicense.html';
        $content = $this->getStaticContent($filePath);
        $post_name = 'content-user-agreement';

        $wpdb->query(
            $wpdb->prepare(
                "UPDATE wp_posts SET post_content=%s WHERE post_name = %s;",
                $content, $post_name
            )
        );

        // update term of service page
        $filePath = '/static-content/PERPII-1038_20140827071936_TermOfService.html';
        $content = $this->getStaticContent($filePath);
        $post_name = 'content-terms-of-service';

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
        $content = file_get_contents($fullFilePath);
        return $content === false ? '' : $content;
    }
}
