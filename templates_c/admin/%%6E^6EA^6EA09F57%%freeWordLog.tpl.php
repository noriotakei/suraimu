<?php /* Smarty version 2.6.26, created on 2015-02-01 10:44:00
         compiled from /home/suraimu/templates/admin/log/freeWordLog.tpl */ ?>
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
<h2 class="ContentTitle">フリーワードデータ</h2>
<br>
<table cellspacing="0" cellpadding="0" class="TableSet01" id="table" align="center">
    <tr>
        <th colspan="3" style="text-align: center; font-weight: bold;">数字選択</th>
    </tr>
    <?php $_from = $this->_tpl_vars['freeWord']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
    <tr>
        <th>ﾕｰｻﾞｰ表示％変換</th>
        <th>ﾕｰｻﾞｰ入力値</th>
        <th>処理日時</th>
    </tr>
    <tr>
        <td>-%free_word_1_<?php echo $this->_tpl_vars['val']['free_word_cd']; ?>
-</td>
        <td><?php echo $this->_tpl_vars['val']['free_word_value']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['update_datetime']; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>
<br>
<br>
<table cellspacing="0" cellpadding="0" class="TableSet01" id="table" align="center">
    <tr>
        <th colspan="3" style="text-align: center; font-weight: bold;">文言選択</th>
    </tr>
    <?php $_from = $this->_tpl_vars['freeWordSet']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
        $this->_foreach['loop']['iteration']++;
?>
    <tr>
        <th>ﾕｰｻﾞｰ表示％変換</th>
        <th>ﾕｰｻﾞｰ入力値</th>
        <th>処理日時</th>
    </tr>
    <tr>
        <td>-%free_word_2_<?php echo $this->_tpl_vars['val']['free_word_cd']; ?>
-</td>
        <td><?php echo $this->_tpl_vars['val']['free_word_text']; ?>
</td>
        <td><?php echo $this->_tpl_vars['val']['update_datetime']; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>
