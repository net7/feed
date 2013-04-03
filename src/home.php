<?php
    $sources = 
        '['.
            '"http://burckhardtsource.org/resources/letter/oskar-eisenmann-1884-03-29.rdf",' .
            '"http://burckhardtsource.org/resources/letter/wilhelm-von-bode-1884-11-07.rdf",' .
            '"http://burckhardtsource.org/resources/letter/wilhelm-von-bode-1889-12-30.rdf",' .
            '"http://burckhardtsource.org/resources/letter/wilhelm-von-bode-1887-07-11.rdf",' .
            '"http://burckhardtsource.org/resources/letter/gustavo-frizzoni-1888-11-15.rdf",' .
            '"http://burckhardtsource.org/resources/letter/pier-desiderio-pasolini-1891-05-02.rdf",' .

            '"http://www.wittgensteinsource.org/Ts-310,5[3]et6[1]_n.rdf",' .
            '"http://www.wittgensteinsource.org/Ts-310,2[2]et3[1]et3a[1]et4[1]_n.rdf",' .
            '"http://www.wittgensteinsource.org/Ts-310,1[2]et2[1]_n.rdf",' .
            '"http://www.wittgensteinsource.org/Ms-141,6[4]et7[1]_n.rdf",' .
            '"http://www.wittgensteinsource.org/Ms-141,6[3]_n.rdf",' .
            '"http://www.wittgensteinsource.org/Ms-141,4[5]et5[1]et6[1]_n.rdf",' .

            '"http://ancientsource.daphnet.org/texts/Sextus/PH-1,4.rdf",' .
            '"http://ancientsource.daphnet.org/texts/Sextus/PH-1,7.rdf",' .
            '"http://ancientsource.daphnet.org/texts/Sextus/PH-1,8.rdf",' .
            '"http://ancientsource.daphnet.org/texts/Sextus/PH-3,204.rdf",' .
            '"http://ancientsource.daphnet.org/texts/Sextus/PH-3,205.rdf",' .
            '"http://ancientsource.daphnet.org/texts/Sextus/PH-3,206.rdf",' .


            '"http://modernsource.daphnet.org/texts/Leibniz/LeiMon_fr,119[4].rdf",'.
            '"http://modernsource.daphnet.org/texts/Leibniz/LeiBD,118[2]et119[1].rdf",'.
            '"http://modernsource.daphnet.org/texts/Kant/KanND,388[5]et389[1].rdf",'.
            '"http://modernsource.daphnet.org/texts/Locke/LocHum,47[4]et49[1].rdf",'.

            '"http://www.gramscisource.org/quaderno/12/nota/12.rdf",' .
            '"http://www.gramscisource.org/quaderno/12/nota/13.rdf",' .
            '"http://www.gramscisource.org/quaderno/12/nota/22.rdf",' .
            '"http://www.gramscisource.org/quaderno/12/nota/59.rdf",' .
            '"http://www.gramscisource.org/quaderno/12/nota/67.rdf",' .

            '"http://furioso-dev.netseven.it/illustrazione/1.rdf",' .
            '"http://furioso-dev.netseven.it/illustrazione/47.rdf",' .
            '"http://furioso-dev.netseven.it/illustrazione/93.rdf",' .
            '"http://furioso-dev.netseven.it/illustrazione/139.rdf",' .
            '"http://furioso-dev.netseven.it/text/canto1.rdf"' .

        ']';
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php renderHead(0); ?>
        <title>Feed the Pundit: Home</title>
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
                    <span class="brand">Feed the Pundit</span>

<!--                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li class="active"><a href="/">Home</a></li>
                            <li><a href="#about">About</a></li>
                            <li><a href="#contact">Contact</a></li>
                        </ul>
                    </div>
-->
                </div>
            </div>
        </div>

        <div class="container">

<!--            <h1>Feed The Pundit</h1>
            <p>Use this interface ...</p> -->

            <br><br>
            <br>

            <form class="form-horizontal span11">
                <div class="control-group">
                    <label class="control-label" for="inputLurl">Source 1 URL</label>
                    <div class="controls">
                        <input class="span8" type="text" tabindex="1" id="inputLurl" placeholder="http://.." data-provide="typeahead" data-items="10" data-source='<?php echo $sources; ?>' />

                        <a class="btn" href="#" rel="popover" data-placement="bottom" title="First source URL" data-content="Insert a full URL of a compatible RDF source provider"><i class="icon-question-sign"></i></a>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label" for="inputRurl">Source 2 URL</label>
                    <div class="controls">
                        <input class="span8" tabindex="2" type="text" id="inputRurl" placeholder="http://.." data-provide="typeahead" data-items="10" data-source='<?php echo $sources; ?>' />
                        <a class="btn" href="#" rel="popover" data-placement="bottom" title="Second URL" data-content="Insert a full URL of a compatible RDF source provider"><i class="icon-question-sign"></i></a>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="selectConf">Configuration</label>
                    <div class="controls">
                        <select id="punditConf">
                            <option>cortona.js</option>
                            <option>burckhardt.js</option>
                            <option>wab.js</option>
                            <option>modernsource.js</option>
                            <option>ancientsource.js</option>
                        </select>
                        <a class="btn" href="#" rel="popover" data-placement="bottom" title="Pundit configuration file" data-content="Choose the Pundit configuration you want to use"><i class="icon-question-sign"></i></a>
                    </div>
                </div>

                <div class="control-group errors-container">
                </div>


                <div class="control-group">
                    <label class="control-label" for="feedThePundit">Feed The Pundit URL</label>
                    <div class="controls">
                        <a class="btn" href="#" rel="popover" data-placement="bottom" title="Feed URL" data-content="This is the FeedThePundit URL to annotate the selected source(s). You can copy, save and share such URL.">
                            <i class="icon-question-sign"></i>
                        </a>
                    </div>
                </div>


                <input class="span11" type="text" id="feedThePundit" disabled />
                <br><br>
                
                <div>
                    <button id="feedSubmitButton" data-loading-text="Loading Pundit..." type="submit" class="btn btn-large btn-block btn-success" tabindex="3">
                        <i class="icon-arrow-right"></i> Annotate!
                    </button>
<!-- 
                        <a class="btn" href="#" rel="tooltip" title="Second URL" data-content="Long explain">
                            <i class="icon-edit"></i> Copy this address
                        </a>
-->

                </div>
            </form>

        </div> <!-- /container -->
        <?php
        renderFooter();
        ?>

        <script src="/js/jquery.tmpl.min.js"></script>
        <script src="/js/form.js"></script>
        <script id="feedErrorTemplate" type="text/x-jquery-tmpl">
            <div class="alert alert-block alert-error fade in">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <h4 class="alert-heading">${title}</h4>
                <p>${description}</p>
            </div>        
        </script>
    </body>
</html>
