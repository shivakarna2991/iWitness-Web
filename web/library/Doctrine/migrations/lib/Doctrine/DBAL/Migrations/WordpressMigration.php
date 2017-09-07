<?php

namespace Doctrine\DBAL\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;

abstract class WordpressMigration extends AbstractMigration
{

    public function savePage(array $data)
    {
        if (!isset($data['post_title'])) {
            throw new \Exception('post_title is missing');
        }

        if (isset($data['ID'])) {
            $page = $this->get_post($data['ID']);
        } else {
            $page = $this->getPageByName($data['post_name']);
        }

        if ($page) {
            return $this->updatePage($page, $data);
        } else {
            return $this->createPage($data);
        }
    }

    /**
     * @param $postId
     * @param $force_delete
     * @return mixed
     */
    public function deletePage($postId, $force_delete)
    {
        return wp_delete_post($postId, $force_delete);
    }

    /**
     * @param $page_name
     * @throws \Exception
     * @return mixed
     */
    public function deletePageByName($page_name)
    {
        $page = $this->getPageByName($page_name);
        if (!$page) {
            throw new \Exception('Page with title ' . $page_name . ' doesn\'t exist');
        }
        return wp_delete_post($page->ID, true);
    }

    /**
     * @param array $data
     * @return int|\WP_Error
     */
    public function createPage(array $data)
    {
        return wp_insert_post($data);
    }

    /**
     * @param \WP_Post $page
     * @param array $data
     * @return int|\WP_Error
     */
    public function updatePage(\WP_Post $page, array $data)
    {
        unset($data['ID']); //check in-case

        $newPage = array_merge($page->to_array(), $data);
        $error = null;
        return wp_insert_post($newPage, $error);

    }

    /**
     * @param $page_title
     * @param string $output
     * @param string $post_type
     * @return null|\WP_Post
     */
    public function  getPageByTitle($page_title, $output = OBJECT, $post_type = 'page')
    {
        return get_page_by_title($page_title, $output, $post_type);
    }


    /**
     * Retrieve a page given its name.
     *
     * @since 2.1.0
     * @uses $wpdb
     *
     * @param string $page_title Page title
     * @param string $output Optional. Output type. OBJECT, ARRAY_N, or ARRAY_A. Default OBJECT.
     * @param string|array $post_type Optional. Post type or array of post types. Default page.
     * @return WP_Post|null WP_Post on success or null on failure
     */
    function getPageByName($page_name, $output = OBJECT, $post_type = 'page')
    {
        global $wpdb;

        if (is_array($post_type)) {
            $post_type = esc_sql($post_type);
            $post_type_in_string = "'" . implode("','", $post_type) . "'";
            $sql = $wpdb->prepare("
			SELECT ID
			FROM $wpdb->posts
			WHERE post_name = %s
			AND post_type IN ($post_type_in_string)
		", $page_name);
        } else {
            $sql = $wpdb->prepare("
			SELECT ID
			FROM $wpdb->posts
			WHERE post_name = %s
			AND post_type = %s
		", $page_name, $post_type);
        }

        $page = $wpdb->get_var($sql);

        if ($page)
            return get_post($page, $output);

        return null;
    }

    /**
     * @return string
     */
    public function getDefaultTemplate()
    {
        return 'page-templates/dynamic-full-width.php';
    }

    /**
     * Get the content of static content page
     *
     * @param $filePath
     * @return null|string
     */
    protected function getStaticPageContent($filePath)
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