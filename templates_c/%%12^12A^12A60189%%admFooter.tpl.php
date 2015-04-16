<?php /* Smarty version 2.6.26, created on 2010-03-15 15:39:46
         compiled from /home/suraimu/templates/admin/include/admFooter.tpl */ ?>
<form action="./" method="post">
<div class="reload">
    <?php echo $this->_tpl_vars['reloadParam']; ?>

    <input type="hidden" name="<?php echo $this->_tpl_vars['actionKey']; ?>
" value="1">
    <input type="image" src="./img/auto_reload.gif" title="リロード" width="25"/>
</div>
</form>