<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Web Account Verification</h4>
            </div>
            <div class="modal-body">
                <p>Please wait, an SMS has been sent to the specified number & should arrive shortly.</p>
                <p>Accounts of emails and phone numbers not verified in 7 days will be deleted from the database.</p>
                <p class="text-primary"> Enter the Alphanumeric code that was sent to the phone number to proceed</p>
                <form id="form1" name="form1" method="post" action="<?php echo URL; ?>login/account_setup" onsubmit="return false"  enctype="multipart/form-data" class="form-horizontal" role="form">

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="code">Code:</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="code" placeholder="Enter 8 Alphanumeric code">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" onclick="checkCode()">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
