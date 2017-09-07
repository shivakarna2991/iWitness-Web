<h3>Step 2) Choose your preferred program text added</h3>


<div class="form-horizontal">
    <fieldset>
        <div class="form-group plan">
            <div class="col-sm-4 col-sm-offset-2">
                <label class="control-label">
                    <input type="radio" name="plan" value="month"
                           class="required" <?= $view_model['plan']=='month'? 'checked':''  ?>/> &nbsp;
                  <input type="hidden" name="price_month" id="price_month" value= <?= $plans['month']['price'] ?> />
                  <input type="hidden" name="mprice_month" id="mprice_month"  value= <?= $plans['month']['member_price'] ?> />
                    <span class="price">
                      	$<?= $plans['month']['price'] ?>&nbsp;+&nbsp;
                  			$<?= $plans['month']['member_price'] ?>
                  	</span>
                </label>&nbsp;per each extra member
            </div>
            <span class="details col-sm-2">Per month</span>
        </div>

        <div class="form-group plan">
            <div class="col-sm-4 col-sm-offset-2">
                <label class="control-label">
                    <input type="radio" name="plan" value="year"
                           class="required" <?= $view_model['plan']=='year'? 'checked':''  ?>/> &nbsp;
                  <input type="hidden" name="price_year" id="price_year" value= <?= $plans['year']['price'] ?> />
                  <input type="hidden" name="mprice_year" id="mprice_year" value= <?= $plans['year']['member_price'] ?> />
                    <span class="price">
                      	$<?= $plans['year']['price'] ?>&nbsp;+&nbsp;
                  			$<?= $plans['year']['member_price'] ?> 
                  	</span>
                </label>&nbsp;per each extra member
            </div>
            <span class="details col-sm-3">One year subscription</span>

            <div class="col-sm-2 label label-default">Just $2.50 per month</div>
        </div>

        <label style="text-align: center; display: none;" class="col-sm-6  error" for="plan">This field is required.</label>
    </fieldset>
</div>

<hr>
