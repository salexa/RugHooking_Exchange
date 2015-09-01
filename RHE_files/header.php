<?php

    echo ("<nav class='navbar navbar-inverse navbar-fixed-top' role='navigation'>" .
        "<div class='container'>" .
            "<!-- Brand and toggle get grouped for better mobile display -->" .
           "<div class='navbar-header'>" .
                "<button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#bs-example-navbar-collapse-1'>" .
                    "<span class='sr-only'>Toggle navigation</span>" .
                    "<span class='icon-bar'></span>" .
                    "<span class='icon-bar'></span>" .
                    "<span class='icon-bar'></span>" .
                    "<span class='icon-bar'></span>" .
                "</button>" .
                "<a class=navbar-brand href='../index.php'>Rug Hooking Exchange</a>" .
            "</div>" .
            "<!-- Collect the nav links, forms, and other content for toggling -->" .
          "<div class='collapse navbar-collapse' id='bs-example-navbar-collapse-1'>" .
                "<ul class='nav navbar-nav'>" .
                   "<li>" .
                        "<a href='browseItem.php'>Browse Items</a>" .
                    "</li>" .
                    "<li>" .
                        "<a href='postItem.php'>Post Items</a>" .
                    "</li>" .
                    "<li>" .
                        "<a href='contact.php'>Contact</a>" .
                    "</li>" .
                "</ul>" .
            "<ul class='nav navbar-nav navbar-right'>" .
                    "<li class='dropdown'>" .
                        "<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Instructions<span class='caret'></span></a>"  .
                  "<ul class='dropdown-menu'>" . 
                    "<li><a href='#'>How to Post an Item</a></li>" .
                    "<li><a href='#'>How to Purchase an Item</a></li>" .
                    "<li><a href='#'>FAQs</a></li>" .
                    "<li role='separator' class='divider'></li>" .
                    "<li><a href='#'>Separated link</a></li>" .
                  "</ul>" .
                    "</li> <!-- dropdown --> " .
            "</ul>  <!-- /.navbar-right --> " .
          "</div>  <!-- /.navbar-collapse -->" .
        "</div>  <!-- /.container --> " .
      "</nav>");

?>


