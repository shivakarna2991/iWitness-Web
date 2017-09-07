<!DOCTYPE html> <!-- html5 only -->
<html style="margin: 0; padding: 0;">
<head>
    <link rel="shortcut icon" href="<?= get_template_directory_uri(); ?>/favicon.ico" type="image/x-icon" />
    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    <meta property="og:image" content="http://www.iwitness.com/images/thumb.png"/>
  
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> <!-- force IE not used quirk mode -->

    <title><?php wp_title('&#124;', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>

    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-30469246-1']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

    </script>
  <link rel="stylesheet" href="https://www.iwitness.com/wp-includes/iwitness/responsive-fix.css">
 
</head>
<body>