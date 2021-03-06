<?php do_action('iwitness_print_notices'); ?>

<h2>Revenue Report</h2>
<hr>

<div id="revenue-table-container" class="dt-search well">

    <div class="search">
        <div class="form-group">
            <label class="control-label col-sm-3" for="start-date">Start date: </label>

            <div class="col-sm-9">
                <input type="text" class="form-control" id="start-date" name="start-date">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3" for="end-date">End date: </label>

            <div class="col-sm-9">
                <input type="text" class="form-control" id="end-date" name="end-date">
            </div>
        </div>
        <ul>
            <li>Total <span id="total-summary"></span></li>
            <li>Revenue <span id="total-revenue"></span></li>
        </ul>
    </div>

    <table id="user-table" class="table table-condensed table-hover table-striped">
        <thead>
        <tr>
            <th data-column-id="created" data-order="desc" data-sortable="false">Created</th>
            <th data-column-id="plan" data-sortable="false">Plan</th>
            <th data-column-id="total" data-sortable="false" data-formatter="registered-counter-formatter">Total</th>
            <th data-column-id="revenue" data-sortable="false" data-formatter="revenue-counter-formatter">Revenue</th>
        </tr>
        </thead>
    </table>

</div>

<?php
// lazy loading style and script
wp_print_scripts('iwitness-revenue-report-plugin');
?>