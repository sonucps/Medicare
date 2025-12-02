<!DOCTYPE HTML>
<!--
    Projection by TEMPLATED
    templated.co @templatedco
    Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
    <head>
        <title>Project by Sonuraushanharsh</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="assets/css/main.css" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function()
            {
                $('#find').click(function()
                {
                    $("#form_x").toggle();
                });
            });
        </script>
        <script>
            $(document).ready(function(){
            $('input.typeahead').typeahead({
                name: 'typeahead',
                remote:'search.php?key=%QUERY',
                limit : 10
            });
        });
        </script>
        <style type="text/css">
            #form_x
            {
                display: none;
            }
            #banner .inner {
    border-top: 2px solid rgba(255, 255, 255, 0.2);
    position: relative;
    z-index: 10005;
    padding-top: 5em;
}
        </style>
<!-- Leaflet CSS/JS -->
<link
  rel="stylesheet"
  href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
  integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
  crossorigin=""
/>
<script
  src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
  integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
  crossorigin=""
></script>


        </head>
    <body>

        <!-- Header -->
            <header id="header">
                <div class="inner">
                    <!--<a href="index.html" class="logo"><strong>Projection</strong> by RV-creations</a>-->
                    <a href="index.html" class="logo"><img src="images/phrmcy.png" width="50"><strong><font size="15">Medicare</font></strong></a>
                    <nav id="nav">
                        <a href="index.html">Home</a>
                        <a href="index2.html">Admin Login</a>
                        
                    </nav>
                    <a href="#navPanel" class="navPanelToggle"><span class="fa fa-bars"></span></a>
                </div>
            </header>
<!-- Banner -->
            <section id="banner">
                <div class="inner">
                    <header>
                        <h1>Welcome to E-MEDS</h1>
                    </header>

                    <div class="flex ">

                        <div>
                            <i class="material-icons" style="font-size:36px;color:#6cc091;">my_location</i>
                            <!--<span class="icon fa-car"></span>-->
                            <h3>Search Store</h3>
                            <p>Search NearBy pharmaceutical</p>
                        </div>

                        <div>
                            <i class="material-icons" style="font-size:36px;color:#6cc091;">business_center</i>
                            <!--<span class="icon fa-camera"></span>-->
                            <h3>Find Medicine</h3>
                            <p>View Medicine Price</p>
                        </div>

                        <div>
                            <i class="material-icons" style="font-size:36px;color:#6cc091;">local_atm</i>
                            <!--<span class="icon fa-bug"></span>-->
                            <h3>COD Method</h3>
                            <p>Make Payment Easy</p>
                        </div>

                    </div>

                    <footer>

                        <div class="col-sm-12">
                            <div class="col-sm-6">
                               <a style="margin: 10px;" id="buy" href="index1.html" class="button">🛒 Buy Your Medicine</a>

                                <center>
#=====================================
    <script src="typeahead.min.js"></script>
    <script>
    $(document).ready(function(){
    $('input.typeahead').typeahead({
        name: 'typeahead',
        remote:'search.php?key=%QUERY',
        limit : 10
    });
});
    </script>

 
    <div class="bs-example">
        <input type="text" name="typeahead" class="typeahead tt-query" autocomplete="off" spellcheck="false" placeholder="Type your Query">
    </div>

    #===============================

    <form id="form_x" class="form-inline" action="buy_pro.php" method="GET">
                                    <div class="form-group">
                                    <input style="margin: 10px;width:20%;" type="text" name="med" placeholder="Search..">
                                    <input type="submit" name="logout" text="Logout">
                                    </div>
                                </form>
                                </center>               
                                            
                            </div>
                            <div class="col-sm-6">
                                <a style="margin: 10px;" href="map.html" class="button">View NearBy pharmacy </a>
                            </div>
                        </div>
                        
                        
                        
                    </footer>
                </div>
            </section>

            <!-- Footer -->
            <footer id="footer">
                <div class="inner">

                    <h3>Get in touch</h3>

                    <form action="#" method="post">

                        <div class="field half first">
                            <label for="name">Name</label>
                            <input name="name" id="name" type="text" placeholder="Name">
                        </div>
                        <div class="field half">
                            <label for="email">Email</label>
                            <input name="email" id="email" type="email" placeholder="Email">
                        </div>
                        <div class="field">
                            <label for="message">Message</label>
                            <textarea name="message" id="message" rows="6" placeholder="Message"></textarea>
                        </div>
                        <ul class="actions">
                            <li><input value="Send Message" class="button alt" type="submit"></li>
                        </ul>
                    </form>

                    <div class="copyright">
                        
                    </div>

                </div>
            </footer>

        <!-- Scripts 
            <script src="assets/js/jquery.min.js"></script>
            <script src="assets/js/skel.min.js"></script>
            <script src="assets/js/util.js"></script>
            <script src="assets/js/main.js"></script>
-->
    </body>
</html>

  
