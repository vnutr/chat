</div><!-- /.blog-main -->

</div><!-- /.row -->

</div><!-- /.container -->

<?php foreach($base->getJS() as $key_js => $value_js): ?>
    <?php if($value_js == Base_Controller::SCRIPT_FOOTER): ?>
        <script src="<?= base_url() . "js/$key_js" ?>" type="text/javascript"></script>
    <?php endif ?>
<?php endforeach; ?>
</body>
</html>