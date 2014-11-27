<script src="<?php echo $webroot; ?>js/flashMessage.js"></script>
dashboard page content
<?php

        // In view
        echo $this->Session->flash('warning');
        echo $this->Session->flash('success');
        echo $this->Session->flash('error');
        echo $this->Session->flash('notice');
?>