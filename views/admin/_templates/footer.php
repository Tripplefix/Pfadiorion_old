<style>
</style>
<div class="footer">
    <?php if (Session::get('user_logged_in') == true): ?>
        <a href="<?php echo URL; ?>admin/login/logout">Logout</a>        
    <?php else: ?>  
        <a href="<?php echo URL; ?>">Pfadi Orion</a> &copy; <?php echo date("Y"); ?>
    <?php endif; ?>  
</div>

</body>
</html>