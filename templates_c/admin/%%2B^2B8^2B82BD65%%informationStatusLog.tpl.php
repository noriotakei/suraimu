<?php /* Smarty version 2.6.26, created on 2014-08-09 10:14:00
         compiled from /home/suraimu/templates/admin/log/informationStatusLog.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'make_link', '/home/suraimu/templates/admin/log/informationStatusLog.tpl', 25, false),array('modifier', 'cat', '/home/suraimu/templates/admin/log/informationStatusLog.tpl', 25, false),)), $this); ?>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<script language="JavaScript">
<!--
    $(function() {
                $('#table').colorize({
            altColor :'#E5E5E5',
            hiliteColor :'none'
        });

    });
// -->
</script>
<h2 class="ContentTitle">情報アクセスログリスト</h2>
<table cellspacing="0" cellpadding="0" class="TableSet01" id="table" align="center">
    <tr>
        <th>情報ID</th>
        <th>タイトル</th>
        <th>消費ポイント</th>
        <th>付与ポイント</th>
        <th>既読日時</th>
    </tr>
    <?php $_from = $this->_tpl_vars['dataList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
    <tr>
        <td><a href="<?php echo smarty_function_make_link(array('action' => 'action_informationStatus_informationData','getTags' => ((is_array($_tmp=((is_array($_tmp="isid=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['val']['id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['val']['id'])))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['URLparam']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['URLparam']))), $this);?>
" target="_blank"><?php echo $this->_tpl_vars['val']['id']; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['val']['name']; ?>
pt</td>
        <td><?php echo $this->_tpl_vars['val']['point']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['bonus_point']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['log_create_datetime']; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>
