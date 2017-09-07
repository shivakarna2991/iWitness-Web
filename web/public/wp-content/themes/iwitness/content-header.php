<div class="head">

    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <ul id="social-media" class="nav navbar-nav navbar-right hidden-xs">
                    <li class="facebook">
                        <!--<div class="fb-like" data-href="http://wwww.iwitness.com" data-layout="button" data-action="like" data-show-faces="true" data-share="false"></div>

                        <div id="fb-root"></div>!-->
                     <a target="_blank" href="https://www.facebook.com/iWitnesscorp/?fref=ts"> <img src="<?= get_template_directory_uri(); ?>/images/facebook.png" 
                             alt="iWitness"/></a>
                        <script>(function(d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0];
                                if (d.getElementById(id)) return;
                                js = d.createElement(s); js.id = id;
                                js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
                                fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));
                        </script>
                    </li>


                    <li class="twitter">
                        <a target="_blank" href="https://twitter.com/iwitnesscorp" ><img src="<?= get_template_directory_uri(); ?>/images/twitter.png" alt="iWitness"/></a>
                        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                    </li>
                </ul>
            </div>

            <div class="navbar navbar-default top-nav" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#open-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="/">
                        <img src="<?= get_template_directory_uri(); ?>/images/logo.gif" class="img-responsive"
                             alt="iWitness"/>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="open-collapse">

                    <ul class="nav navbar-nav navbar-right">

                        <?php iwitness_guest_menu_render(); ?>

                        <?php if (is_user_logged_in()): ?>
                            <?php /* todo: temporary comment this code because we do not release in this version
                            <li class="dropdown hidden-sm hidden-xs" id="message-notification">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <span class="glyphicon glyphicon-bell"></span> Message  <span id="num-of-notify" class="label label-danger">0</span>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <div class="panel panel-default">
                                            <div class="panel-heading text-center">Notifications</div>
                                            <div class="panel-body">

                                                <div class="list-group" id="message-box">

                                                </div>

                                            </div>
                                            <div class="panel-footer text-center">
                                                <button class="btn btn-primary btn-block">View All</button>
                                                <a id="next" href="#" class="hide"></a>
                                                <!--<a href="#">View All</a>-->
                                            </div>
                                        </div>
                                    </li>
                                </ul>

                                <!-- user template -->
                                <script type="text/html" id="notification-template">

                                    <div class="list-group-item">
                                        <span class="message-text col-sm-9" data-content="message"></span>
                                        <div class="message-action pull-right col-sm-3 hide">
                                            <a href="#"><span class="glyphicon glyphicon-remove"></span></a>
                                            <a href="#"><span class="glyphicon glyphicon-ok"></span></a>
                                        </div>
                                    </div>

                                </script>
                            </li> */ ?>

                            <?php
                            try{
                                $user = iwitness_get_current_api_user(false);
                            }catch(\Exception $ex){
                                $user = null;
                            }
                            ?>

                            <li class="dropdown navbar-right hidden-sm hidden-xs">

                                <?php if ($user): ?>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <?php echo $user->firstName . ' ' . $user->lastName ?>
                                        <span class="caret"></span>
                                        <img width="40" height="40" class="img-circle hidden-xs"
                                             src="<?php echo $user->get_user_image(); ?>">
                                    </a>

                                <?php endif; ?>
                                <ul class="dropdown-menu api-dropdown-menu pull-right" role="menu">

                                    <?php iwitness_user_menu_render(); ?>

                                </ul>
                            </li>

                        <?php endif; ?>

                    </ul>

                    <ul class="nav navbar-nav visible-sm visible-xs">
                        <!-- these menu item for mobile or tablet only -->
                        <?php iwitness_small_device_user_menu_render(); ?>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
