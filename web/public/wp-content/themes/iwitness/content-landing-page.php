<!-- get header of the content -->
<?php get_template_part('content-header'); ?>

<!-- get main content -->
<div class="bd">
    <div class="container">
        <div class="row">
            <div class="col-md-8 home-info">
                <h1>Always have a witness</h1>
                <hr>
                <div class="row">
                    <div class="col-md-10 col-md-offset-2 col-sm-12 col-sm-offset-0">
                        <p>
                            A personal safety smartphone app so easy, safe and
                            economical that using it daily is simple common sense.
                        </p>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-left text-center">
                            <br>
                            <strong>Give the Gift of Safety</strong><br>
                            <a href="/gift-card"><img src="<?= get_template_directory_uri(); ?>/images/store/giftcard.gif" class="img-responsive"></a>
                            <a href="/gift-card">Give an E-Subscription</a>
                        </div>
                        <div class="pull-right" style="width:200px;">
                            <p>
                                <a href="/start-now" class="btn btn-primary btn-block">Buy Now</a>
                            </p>
                            <p>
                                <a href="/content-learn-more" class="btn btn-default btn-block">Learn More</a>
							</p>
                            <p>
                      <h5 class="text-center">
                        Available for Apple and Android
                    </h5></p>
                          </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 hidden-xs hidden-sm">
                <br>
                <div class="text-center">
                    <img src="<?= get_template_directory_uri(); ?>/images/iw_app_home.png" alt="iWitness App">
                         </div>
            </div>
        </div>
    </div>
</div>

<div class="bottom-content">
    <div class="container">
        <div class="row">
            <div class="bottom-box">
                <div class="col-md-4 bottom-box-border">
                    <a class="btn btn-link" target="_blank" href="https://itunes.apple.com/us/app/iwitness-personal-safety/id511623656?mt=8"><img src="<?= get_template_directory_uri(); ?>/images/store/appstore.jpg" alt="iPhone App Store"></a>
                    <a class="btn btn-link" target="_blank" href="https://play.google.com/store/apps/details?id=com.iwitness.android"><img src="<?= get_template_directory_uri(); ?>/images/store/playstore.jpg" alt="Google Play"></a>
                </div>
                <div class="col-md-4 bottom-box-border">
                    <strong>Watch Video: </strong>
                    <a href="http://fast.wistia.com/embed/iframe/f78c7de7ec?version=v1&videoWidth=640&videoHeight=360&controlsVisibleOnLoad=true&autoPlay=true&popover=v1" id="launch-player2" class="wistia-popover[width=640,height=360,playerColor=#636155]" target="_blank">
                        <img src="<?= get_template_directory_uri(); ?>/images/index/play-button.gif" alt="Play Video" height="48">
                    </a>
                </div>
                <div class="col-md-4">
                    As little as <strong>$2.50 a month</strong><br>
                    <small>* With an annual subscription</small>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- get footer of the content -->
<?php get_template_part('content-footer'); ?>
