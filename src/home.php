
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php renderHead(0); ?>
        <title>Feedthepund.it</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Net7srl">

        <!-- Le styles -->
        <style>
            body {
                padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
            }
        </style>

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    </head>

    <body>

        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <span class="brand">FeedThePundit</span>
<!--                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li class="active"><a href="/">Home</a></li>
                            <li><a href="#about">About</a></li>
                            <li><a href="#contact">Contact</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
-->
                </div>
            </div>
        </div>

        <div class="container">

<!--            <h1>Feed The Pundit</h1>
            <p>Use this interface ...</p> -->

            <form class="form-horizontal">
                <div class="control-group">
                    <label class="control-label" for="inputLurl">URL 1</label>
                    <div class="controls">
                        <input type="text" id="inputLurl" placeholder="Insert first URL" />
                        <a class="btn" href="#" rel="popover" title="First URL" data-content="Long explain"><i class="icon-question-sign"></i></a>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label" for="inputRurl">URL 2</label>
                    <div class="controls">
                        <input type="text" id="inputRurl" placeholder="Insert second URL" />
                        <a class="btn" href="#" rel="popover" title="Second URL" data-content="Long explain"><i class="icon-question-sign"></i></a>
                    </div>
                </div>

                
                <div class="control-group">
                    <label class="control-label" for="selectConf">Configuration</label>
                    <div class="controls">
                        <select>
                            <option>cortona.js</option>
                            <option>burckhardt.js</option>
                            <option>wab.js</option>
                            <option>pisanotizie.js</option>
                            <option>otherconf.js</option>
                        </select>
                        <a class="btn" href="#" rel="popover" title="Pundit configuration file" data-content="Long explain"><i class="icon-question-sign"></i></a>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="feedThePundit">Feed</label>
                    <div class="controls">
                        <input type="text" id="feedThePundit" disabled />
                        <a class="btn" href="#" rel="tooltip" title="Second URL" data-content="Long explain">
                            <i class="icon-arrow-right"></i>
                        </a>
                        <a class="btn" href="#" rel="tooltip" title="Second URL" data-content="Long explain">
                            <i class="icon-edit"></i>
                        </a>
                        <a class="btn" href="#" rel="popover" title="Second URL" data-content="Long explain">
                            <i class="icon-question-sign"></i>
                        </a>
                    </div>
                </div>
            </form>

        </div> <!-- /container -->
        <?php
        renderFooter();
        ?>
        <script src="/js/form.js"></script>
    </body>
</html>
