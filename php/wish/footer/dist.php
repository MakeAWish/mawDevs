<?php

$showError = isset($clientMessage) AND ($clientMessage != "");
$showDebug = isset($debugMessages);

if ($showError OR $showDebug) {
    ?>
    <script type="text/javascript">
        $(window).load(function () {
            <?php if(isset($clientMessage) AND $clientMessage != "") { ?>
            modal.open({content: "<?php echo $clientMessage ?>", timeout: 15000});
            <?php }
            if(isset($debugMessages)) {
                foreach ($debugMessages as &$message) {
                    $text = trim(preg_replace('/\s+/', ' ', addslashes($message)));
                    echo "window.console && console.log('$text');";
                }
            } ?>
        });
    </script>
<?php } ?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-4257717-4', 'borisschapira.com');
  ga('send', 'pageview');

</script>