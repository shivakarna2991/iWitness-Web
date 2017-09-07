<?php do_action('iwitness_print_notices'); ?>

<h2>Expire Subscription Report</h2>
<hr>

<div id="subscription-table-container" class="dt-search well">
    <table id="user-table" class="table table-condensed table-hover table-striped">
        <thead>
        <tr>
            <th data-column-id="firstName" data-sortable="true">First name</th>
            <th data-column-id="lastName" data-sortable="true">Last name</th>
            <th data-column-id="phone" data-sortable="true">Phone</th>
            <th data-column-id="email" data-sortable="true" data-visible="false">Email</th>
            <th data-column-id="subscriptionStartAt"  data-sortable="true"
                data-formatter="start-at-formatter">Subscription Start At</th>
            <th data-column-id="subscriptionExpireAt" data-order="desc" data-sortable="true"
                data-formatter="expired-at-formatter">Subscription Expire At</th>
        </tr>
        </thead>
    </table>

    <!-- search template -->
    <script type="text/html" id="search-template">
        <div class="search pull-left">
            <div class="form-group">
                <label class="control-label col-sm-3" for="start-date">Start date: </label>

                <div class="col-sm-9">
                    <input type="text" class="form-control" id="start-date" name="start-date">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="end-date">End date: </label>

                <div class="col-sm-9">
                    <input type="text" class="form-control" id="end-date" name="end-date" value="<?= date('m/d/Y') ?>">
                </div>
            </div>
        </div>
    </script>
</div>

<?php
// lazy loading style and script
wp_print_scripts('iwitness-subscription-report-plugin');
?>