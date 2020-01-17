
<!-- Container (Home Cells Section) -->
<div id="home-cells" class="container-fluid text-center bg-grey">
    <h2 class="text-center"><span class="glyphicon glyphicon-lock"></span> Password Recovery <small>Enter Registered Email</small> </h2>

    <div class="row">
        <div class="col-sm-4 col-sm-offset-4">
            <p>A link will be sent to the registered email address to enable you reset your password</p>

            <form action="<?php echo(URL.'winner/account'); ?>" method="post" id="contact_form" onsubmit="return false">
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <input type="text" class="form-control" id="email_recover" placeholder="Enter your email">
                    </div>
                </div>
                <script src='https://www.google.com/recaptcha/api.js'></script>
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <div class="g-recaptcha" data-sitekey="6LeWVSgTAAAAAMAHV2Dl4t9z7AGKxexuUFjoxZGh"></div>                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 form-group" id="status"></div>

                    <div class="col-sm-12 form-group" id="submit">
                        <button class="btn btn-success btn-block" type="submit" onclick="submitEmail()">Reset my password</button>
                    </div>

                </div>

            </form>
        </div>
    </div>
</div>
