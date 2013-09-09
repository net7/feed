<?php
    $sources = 
        '['.
            '"http://burckhardtsource.org/letter/117.rdf",' .
            '"http://burckhardtsource.org/letter/3.rdf",' .
            '"http://burckhardtsource.org/letter/59.rdf",' .
            '"http://burckhardtsource.org/letter/53.rdf",' .
            '"http://burckhardtsource.org/letter/56.rdf",' .
            '"http://burckhardtsource.org/letter/427.rdf",' .

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
            .control-group.errors-container .alert {
                margin: 20px;
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

            <br/><br/>

            <form class="form-horizontal span11">
                

                <div class="tabbable">
                  <ul class="nav nav-tabs">
                      <li class="active"><a href="#t1" data-toggle="tab">One RDF resource</a></li>
                      <li class=""><a href="#t2" data-toggle="tab">Two RDF resources</a></li>
                      <li class=""><a href="#t3" data-toggle="tab">An image</a></li>
                  </ul>
                  <div class="tab-content">
                      <div class="tab-pane active" id="t1">

                          <label>Insert a full URL of a compatible RDF source</label>
                          <input class="input-block-level" type="text" tabindex="1" id="inputurl" placeholder="http://.." data-provide="typeahead" data-items="10" data-source='<?php echo $sources; ?>' />
                          <input type="text" style="visibility: hidden" />

                      </div>
                      <div class="tab-pane" id="t2">

                          <label>Insert two full URLs of two compatible RDF sources</label>
                          <input class="input-block-level" type="text" tabindex="1" id="inputLurl" placeholder="http://.." data-provide="typeahead" data-items="10" data-source='<?php echo $sources; ?>' />
                          <input class="input-block-level" type="text" tabindex="1" id="inputRurl" placeholder="http://.." data-provide="typeahead" data-items="10" data-source='<?php echo $sources; ?>' />
                          
                      </div>
                      <div class="tab-pane" id="t3">

                          <label>Insert an image's absolute URL</label>
                          <input class="input-block-level" type="text" tabindex="1" id="inputimage" placeholder="http://.."/>
                          <input type="text" style="visibility: hidden" />
                          
                      </div>
                  </div>
                </div>
                
                <br />

                <label>
                    Configuration
                </label>
                <select id="punditConf" class="input-block-level">
                    <option value="burckhardt.js">Burckhardt source (see http://burckhardtsource.org)</option>
                    <option value="wab.js">Wittgenstein Source Pilot (see http://wittgensteinsource.org)</option>
                    <option value="modernsource.js">Modern source (see http://modernsource.daphnet.org/)</option>
                    <option value="ancientsource.js">Ancient Source (see http://ancientsource.daphnet.org/)</option>
                    <option value="cortona.js">Open Platforms for Humanities @ Cortona (see http://openplatformsforhumanities.org)</option>
                    <option value="timeline-demo.js">Timeline demo (see http://www-wp.thepund.it/demo-applications/timeline-demo/)</option>
                </select>

                <div class="control-group errors-container">
                </div>


                <br />

                <label>
                    Feed The Pundit URL, you can copy, save and share this URL.
                </label>
                    
                <input class="span11" type="text" id="feedThePundit" disabled />
                <br><br>
                
                <div>
                    <button id="feedSubmitButton" data-loading-text="Loading Pundit..." type="submit" class="btn btn-large btn-block btn-success" tabindex="3">
                        <i class="icon-arrow-right"></i> Annotate!
                    </button>

                </div>
            </form>

        </div> <!-- /container -->

        <?php
            renderFooter(false);
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
