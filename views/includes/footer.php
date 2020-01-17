<div class="container-fluid col2">
    <div class="row" id="login" >
        <!-- <div class="col-sm-4">
            <h2> Some sublime effect</h2><br>
            <p> Our Mandate speaks of liberation in all facets of human existence, we focus mainly on destinies that have been afflicted, battered, beaten, tattered, deformed and subsequently in groaning and agonies, as a result of pains, pangs and crying. This is the mandate...</p>
            <br>

        </div>
        <div class="col-sm-4">
            <h2> News <small>& Tit bits</small></h2><br>

        </div>
        <div class="col-sm-4" id="students">
            <h2> Jokes <small> & Poems </small></h2><br>

        </div>
         -->


    </div>
</div>
<!-- Footer -->
<div class="container-fluid col4">
    <div class="row" id="footer">
        <div class="col-sm-4">
            <div class="footbox">
                <h2>School Address</h2>
                <ul>
                    <li><a href="#">Address Line 1</a></li>
                    <li><a href="#">Address Line 2</a></li>
                    <li><a href="#">Contact Number 1</a></li>
                    <li><a href="#">Contact Number 2</a></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="text-center">
                <h2>Site Links</h2>
                <div class="list-group">
                    <a href="#" class="list-group-item">First item</a>
                    <a href="#" class="list-group-item">Second item</a>
                    <a href="#" class="list-group-item">Third item</a>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="">
                <h2 >Bus Routes</h2>
                <ul>
                    <li><a href="#">Bus route 1</a></li>
                    <li><a href="#">Major Bustop/ Landmark</a></li>
                    <li><a href="#">Bus route 2</a></li>
                    <li><a href="#">Major Bustop/ Landmark</a></li>
                    <li><a href="#">Bus route 3</a></li>
                    <li><a href="#">Major Bustop/ Landmark</a></li>
                </ul>
            </div>
        </div>
    </div><br>
    <hr/>
    <div id="copyright">
        <p class="pull-left">Digital Technology for School Management.</p>
        <br/>
        <p class="pull-right">Design and Developed for School Education by <a href="http://frogfreezone.com/"> <span class="glyphicon glyphicon-king"> </span> Chinonso Ani. </a> All rights reserved &copy; 2016 - <?php echo(date('Y')); ?></p>

    </div>

</div>

<!-- Scripts -->
<script src="<?php echo URL; ?>public/bootstrap/js/jQuery-2.2.0.min.js"></script>
<script src="<?php echo URL; ?>public/bootstrap/js/bootstrap.min.js"></script>

<?php
    //general applicable js
    if (isset($this->generalJS))
    {
        foreach ($this->generalJS as $general)
        {
            echo '<script type="text/javascript" src="'.URL.'public/'.$general.'"></script>';
        }
    }
    //page specific js
    if (isset($this->js))
    {
        foreach ($this->js as $js)
        {
            echo '<script type="text/javascript" src="'.URL.'views/'.$js.'"></script>';
        }
    }

?>


</body>
</html>
