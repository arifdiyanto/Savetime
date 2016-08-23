<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?=HTTP_A?>/images/favicon/default.ico">
    <title>
        Me Framework
        <?=APP_BASE?>
    </title>
    <style type="text/css">
    body {
        padding-top: 20px;
    }
    </style>
    <?php include_once DIR_V . '/layouts/libs.php';?>
</head>

<body>
    <div class="container">
        <!-- Static navbar -->
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Me Framework</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active mebar_frm_default"><a href="?pg=frm_default">Home</a></li>
                        <li class="mebar_sample_frm_sample"><a href="?pg=sample/frm_sample">Sample CRUD</a></li>
                        <li class="mebar_contact_frm_contact"><a href="?pg=contact/frm_contact">Contact</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">Nav header</li>
                                <li><a href="#">Separated link</a></li>
                                <li><a href="#">One more separated link</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="mebar_sfgenerator_frm_sfgenerator"><a href="?pg=sfgenerator/frm_sfgenerator">Generator</a></li>
                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
            <!--/.container-fluid -->
        </nav>
        <div class="content">
            <?=$page_content?>
        </div>
    </div>
    <!-- /container -->
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript">
    $("#navbar ul li.active").removeClass('active');
    $("#navbar ul li.mebar_<?=str_replace('/', '_', Req::get('pg'))?>").addClass('active');
    </script>
</body>

</html>
