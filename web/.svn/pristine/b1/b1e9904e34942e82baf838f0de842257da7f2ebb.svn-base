<?php do_action('iwitness_print_notices'); ?>

    <h2>User Report</h2>
    <hr>

    <div id="user-table-container" class="dt-search well">
        <table id="user-table" class="table table-condensed table-hover table-striped">
            <thead>
            <tr>
                <th data-column-id="created" data-order="desc" data-sortable="true"
                    data-formatter="created-datetime-formatter">Created</th>
                <th data-column-id="firstName" data-sortable="true">First name</th>
                <th data-column-id="lastName" data-sortable="true">Last name</th>
                <th data-column-id="phone"  data-sortable="true">Phone</th>
                <th data-column-id="address1" data-sortable="true">Address</th>
                <th data-column-id="address2" data-sortable="true" data-visible="false">Address 2</th>
                <th data-column-id="city" data-sortable="true" data-visible="false">City</th>
                <th data-column-id="state" data-sortable="true" data-visible="false">State</th>
                <th data-column-id="zip" data-sortable="true" data-visible="false">Zip</th>
                <th data-column-id="email" data-sortable="true">Email</th>
                <th data-column-id="gender" data-sortable="true" data-visible="false">Gender</th>
                <th data-column-id="birthDate" data-sortable="true" data-visible="false"
                    data-formatter="datetime-formatter">Birthday
                </th>
                <th data-column-id="heightFeet" data-sortable="true" data-visible="false">Height Feet</th>
                <th data-column-id="heightInches" data-sortable="true" data-visible="false">Height Inches</th>
                <th data-column-id="weight" data-sortable="true" data-visible="false">Weight</th>
                <th data-column-id="eyeColor" data-sortable="true" data-visible="false">Eye Color</th>
                <th data-column-id="hairColor" data-sortable="true" data-visible="false">Hair Color</th>
                <th data-column-id="ethnicity" data-sortable="true" data-visible="false">Ethnicity</th>
                <th data-column-id="timezone" data-sortable="true" data-visible="false">Time Zone</th>
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
                        <input type="text" class="form-control" id="end-date" name="end-date">
                    </div>
                </div>
            </div>
        </script>
    </div>

<?php
// lazy loading style and script
wp_print_scripts('iwitness-user-report-plugin');
?>