<div class="payment">

    <div class="form-horizontal">
        <fieldset>

            <input type="hidden" name="cardtype" id="card_type" value="<?= $view_model['cardType'] ?>">

            <div class="form-group">
                <label for="card_number" class="col-md-2 control-label">Card Number</label>
                <div class="col-md-7">
                    <div class="card-container">
                        <span id="card_number_icon" class="ccard-icon"></span>
                        <input id="card_number" type="text" name="card_num" value="<?= $view_model['cardNum'] ?>"
                               class="required  creditcard form-control" autocomplete="off"
                               placeholder="">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label" for="exp_month">
                    Expiration Date
                </label>
                <div class="col-md-4">
                    <select id="exp_month" name="exp_month" class="required form-control">
                        <?php
                        $data = array('' => 'Expiration Month');
                        foreach (range(1, 12) as $month):
                            $data[$month] = str_pad($month, 2, '0', STR_PAD_LEFT) . ' - ' . date("M", strtotime(date('Y') . "-{$month}-01"));
                        endforeach;

                        iwitness_view_helper_select_options($view_model['expMonth'], $data);
                        ?>

                    </select>
                </div>
                <div class="col-md-3">
                    <select id="exp_year" name="exp_year" class="required form-control">
                        <?php
                        $data = array('' => 'Expiration Year');
                        foreach (range(date("Y"), date("Y") + 10) as $year):
                            $data[$year] = $year;
                        endforeach;

                        iwitness_view_helper_select_options($view_model['expYear'], $data);
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="card_code" class="col-md-2 control-label">Card Security Code</label>
                <div class="col-md-2">
                    <input type="text" id="card_code" name="card_code" value="<?= $view_model['cardCode'] ?>" maxlength="10"
                           class="required form-control"
                           autocomplete="off"/>
                </div>
            </div>

            <div class="bg-grey" style="padding-left: 5px">
                <span class="text-danger glyphicon glyphicon-lock"></span>
                This is a secure transaction
            </div>

        </fieldset>
    </div>
</div>

<h3>Billing information</h3>

<?php include_once($plugin_path.'/templates/partial/billing-info.php'); ?>

<!--payment -->
