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
                    echo "window.console && console.log('".addslashes($message)."');";
                }
            } ?>
        });
    </script>
<?php } ?>