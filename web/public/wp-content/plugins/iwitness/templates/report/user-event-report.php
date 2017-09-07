<?php do_action('iwitness_print_notices'); ?>

<h2>List User Activity (Events Created)</h2>
<hr>

<div id="user-event-table-container" class="well dt-search">
    <table id="event-table" class="table table-condensed table-hover table-striped">
        <thead>
        <tr>
            <th data-column-id="displayName" data-order="desc" data-sortable="false">Display Name</th>
            <th data-column-id="initialLat" data-sortable="false">Lat</th>
            <th data-column-id="initialLong" data-sortable="false">Lng</th>
            <th data-column-id="processed" data-sortable="false" data-formatter="checked-formatter">Processed</th>
            <th data-column-id="imageUrl" data-sortable="false" data-formatter="video-link-formatter">Video</th>
        </tr>
        </thead>
    </table>

    <!-- search template -->
    <script type="text/html" id="search-template">
        <div class="search pull-left">
            <div class="form-group">
                <label class="control-label col-sm-3" for="select2-user">User: </label>
                <div class="col-sm-9">
                    <input type="text" id="select2-user" name="select2-user" style="width:200px; text-align: left;">
                </div>
            </div>
        </div>
    </script>
</div>

<?php
// lazy loading style and script
wp_print_scripts('iwitness-user-event-report-plugin');
?>