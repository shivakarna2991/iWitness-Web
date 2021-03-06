<div class="well supported-devices">
    <div class="row">

        <div class="col-xs-12 col-sm-6 col-md-3">
            <label class="control-label">
                <h5 style="width:  208px">iPhone 4S, 5C, 5S, 6, &amp; 6 Plus</h5>
                <img src="/wp-content/themes/iwitness/images/start-now/iphone5.png" class="img-responseive">
                <br>
                <input type="radio" name="phone_model" id="iphone4" value="iphone4"
                   class="required" <?= $view_model['originalPhoneModel'] == 'iphone4' ? 'checked' : '' ?>  />
            </label>
        </div>

        <!--<div class="col-xs-12 col-sm-6 col-md-3">
            <div id="iphone3-warning-overlay">
                The flash feature used in the <br/>
                iWitness app is not available on the iPhone 3GS, all other functions of the app are usable with this
                phone type.
            </div>
           <label class="control-label">
                <h5>iPhone 3GS</h5>
                <img src="/wp-content/themes/iwitness/images/start-now/iphone3gs.png" class="img-responseive">
                <br>
                <input type="radio" name="phone_model" id="iphone3" value="iphone3"
                   class="required" <?= $view_model['originalPhoneModel'] == 'iphone3' ? 'checked' : '' ?>/>
            </label>
        </div>-->

        <div class="col-xs-12 col-sm-6 col-md-3">
            <label class="control-label">
                <h5>Android</h5>
                <img src="/wp-content/themes/iwitness/images/start-now/android.png" class="img-responseive">
                <br>
                <input type="radio" name="phone_model" id="android" value="android"
                   class="required" <?= $view_model['originalPhoneModel'] == 'android' ? 'checked' : '' ?> />
            </label>
        </div>

      <!--  <div class="col-xs-12 col-sm-6 col-md-3">
            <label class="control-label">
                <h5>Windows 7</h5>
                <img src="/wp-content/themes/iwitness/images/start-now/windows.png" class="img-responseive">
                <br>
                <input type="radio" name="phone_model" id="windows7" value="windows7"
                   class="required" <?=  $view_model['originalPhoneModel'] == 'windows7' ? 'checked' : '' ?>/>
            </label>
        </div>-->

        <label for="phone_model" class="error" style="display:none">Please choose your smartphone</label>

    </div>
</div>
