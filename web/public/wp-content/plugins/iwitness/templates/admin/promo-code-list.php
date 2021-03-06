<div class="row">
    <div class="col-md-6">
        <h2>Generated promo codes list</h2>
    </div>
    <div class="col-md-6">
        <a href="<?php echo iwitness_get_page_path(IWITNESS_PAGE_ADMIN_DASHBOARD_ID); ?>"
           class="btn btn-primary pull-right" style="margin-top:20px">Create Promotion</a>
    </div>
</div>
<hr>

<div class="well">
    <table id="coupon-table" class="table table-condensed table-hover table-striped">
        <thead>
        <tr>
            <th data-column-id="code" data-order="desc">Codes</th>
            <th data-column-id="price" data-sortable="true" data-visible="false"
                data-formatter="free-formatter">Free</th>
            <th data-column-id="currentUsages" data-sortable="true" data-visible="false">Current Usages</th>
            <th data-column-id="isActive" data-sortable="true" data-visible="false"
                data-formatter="active-formatter">Active</th>
            <th data-column-id="price" data-sortable="true"
                data-formatter="price-formatter">Price</th>
            <th data-column-id="name" data-sortable="true">Name</th>
            <th data-column-id="maxRedemption" data-sortable="true">Max Redemption</th>
            <th data-column-id="redemptionStartDate" data-sortable="true"
                data-formatter="redemption-start-date-formatter">Start Date</th>
            <th data-column-id="redemptionEndDate" data-sortable="true"
                data-formatter="redemption-end-date-formatter">End Date</th>
            <th data-column-id="plan" data-sortable="true" data-visible="false">Plan</th>
            <th data-column-id="codeString" data-sortable="true" data-visible="false">Code String</th>
        </tr>
        </thead>
    </table>
</div>

<?php
// lazy loading style and script
wp_print_scripts('iwitness-coupon-manage-plugin');
?>