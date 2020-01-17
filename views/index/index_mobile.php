<!DOCTYPE html>
<html>
<head>
    <title>First jQuery Mobile Example</title>
    <!-- the three things that jQuery Mobile needs to work -->
    <link rel="stylesheet" href="<?php echo URL; ?>public/custom/jquery.mobile-1.4.2/jquery.mobile-1.4.2.css" />
    <script src="<?php echo URL; ?>public/custom/jquery.mobile-1.4.2/jquery-1.11.0.js" type="text/javascript"></script>
    <script src="<?php echo URL; ?>public/custom/jquery.mobile-1.4.2/jquery.mobile-1.4.2.js" type="text/javascript"></script>
    <meta name="viewport" content="width=device-width"/>
</head>
<body>
<!-- This is the first page -->
<section id="firstpage" data-role="page">
    <div data-role="header">
        <h1>Page Content Header</h1>
    </div>
    <div class="ui-content" role="main">
        <p>This is the content on page 1</p>
        <p><a href="#secondpage">Go to second page</a></p>
    </div>
    <div data-role="footer">
        <h2>Page Content Footer</h2>
    </div>
</section>

<!-- This is the second page -->
<div id="secondpage" data-role="page">
    <div data-role="header">
        <h1>Page Content Header</h1>
    </div>
    <div class="ui-content" role="main">
        <p>Page 2 has different content on it</p>
        <p><a href="#firstpage">Go to first page</a></p>
    </div>
    <div data-role="footer">
        <h2>Page Content Footer</h2>
    </div>
</div>
</body>
</html>
