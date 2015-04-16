<?php /* Smarty version 2.6.26, created on 2014-08-11 12:24:33
         compiled from /home/suraimu/templates/admin/log/pointLog.tpl */ ?>
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
<h2 class="ContentTitle">ポイントログリスト</h2>
<table cellspacing="0" cellpadding="0" class="TableSet01" align="center">
    <tr>
        <th>現在ポイント</th>
        <th>合計使用ポイント</th>
        <th>合計付与ポイント</th>
    </tr>
    <tr>
        <td><?php echo $this->_tpl_vars['userData']['point']; ?>
pt</td>
        <td><?php echo $this->_tpl_vars['userData']['total_use_point']; ?>
pt</td>
        <td><?php echo $this->_tpl_vars['userData']['total_addition_point']; ?>
pt</td>
    </tr>
</table>
<br>
<table cellspacing="0" cellpadding="0" class="TableSet01" id="table" align="center">
    <tr>
        <th>処理日時</th>
        <th>種別</th>
        <th>ポイント</th>
        <th>注文ID</th>
        <th>情報ID</th>
    </tr>
    <?php $_from = $this->_tpl_vars['dataList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
    <tr>
        <td><?php echo $this->_tpl_vars['val']['create_datetime']; ?>
</td>
        <td><?php echo $this->_tpl_vars['pointLogType'][$this->_tpl_vars['val']['type']]; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['point']; ?>
pt</td>
        <td><?php echo $this->_tpl_vars['val']['ordering_id']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['information_status_id']; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>
