<!-- Scripts -->
<script src="<?php echo URL; ?>public/bootstrap/js/jQuery-2.2.0.min.js"></script>
<script src="<?php echo URL; ?>public/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo URL; ?>public/custom/js/person_search.js"></script>
<script src="<?php echo URL; ?>public/custom/js/liveTimeAgo.js"></script>
<script type="text/javascript">
    // Select all elements with data-toggle="popover" in the document
    $('[data-toggle="popover"]').popover({html: true, placement: "top"});
</script>
<script>
    $('.liveTime').liveTimeAgo();
</script>
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
<!-- Footer -->
<footer class="container-fluid  text-center jumbosmall">
    <a href="#myPage" title="To Top">
        <span class="glyphicon glyphicon-chevron-up"></span>
    </a>
    <hr/>
    <h3> Quick Links</h3>
    <hr/>

    <p class="pull-left">Digital Technology for School Management.</p>
    <br/>
    <p class="pull-right">Design and Developed for School Education by <a href="http://frogfreezone.com/"> <span class="glyphicon glyphicon-king"> </span> MOVE UP LIMITED. </a> All rights reserved &copy; 2016 - <?php echo(date('Y')); ?></p>


</footer>

</body>
</html>
