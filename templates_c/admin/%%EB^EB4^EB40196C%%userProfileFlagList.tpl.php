<?php /* Smarty version 2.6.26, created on 2015-01-13 18:24:55
         compiled from /home/suraimu/templates/admin/user/userProfileFlagList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/user/userProfileFlagList.tpl', 27, false),array('modifier', 'implode', '/home/suraimu/templates/admin/user/userProfileFlagList.tpl', 33, false),array('modifier', 'cat', '/home/suraimu/templates/admin/user/userProfileFlagList.tpl', 114, false),array('function', 'html_options', '/home/suraimu/templates/admin/user/userProfileFlagList.tpl', 72, false),array('function', 'make_link', '/home/suraimu/templates/admin/user/userProfileFlagList.tpl', 114, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="./js/jquery.colorize.js"></script>
<link type="text/css" href="./css/pager.css" rel="stylesheet" />
<script type="text/javascript">
<!--


    $(function() {
        // テーブルマウスオーバーカラー
        $('#list_table').colorize({
            altColor :'#CCCCCC',
            hiliteColor :'none'
        });

    });


//-->
</script>
</head>
<body>

<div id="ContentsCol">

<h2 class="ContentTitle">フラグコードの名前を編集</h2>
    <?php if (count($this->_tpl_vars['errMsg'])): ?>
        <div class="warning ui-widget">
        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
        <p>
        <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
        <?php $_from = $this->_tpl_vars['errMsg']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
            <?php echo implode($this->_tpl_vars['val'], "<br>"); ?>

        <?php endforeach; endif; unset($_from); ?>
        </p>
        </div>
        </div>
        <br>
<?php endif; ?>

<?php if (count($this->_tpl_vars['msg'])): ?>
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    <?php $_from = $this->_tpl_vars['msg']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
        <?php echo implode($this->_tpl_vars['val'], "<br>"); ?>

    <?php endforeach; endif; unset($_from); ?>
    </p>
    </div>
    </div>
    <br>
<?php endif; ?>

<div>
    <form action="./" method="post">
        <?php echo $this->_tpl_vars['POSTparam']; ?>

            <table border="0" cellspacing="0" cellpadding="0" id="src_table" class="TableSet04">
                <tr><th colspan="2" style="text-align:center;">フラグコードの名前を編集</th></tr>
                <tr>
                    <th>コード</th>
                    <td><input name="user_profile_flag_code" size="20"/></td>
                </tr>
                <tr>
                    <th>コード名</th>
                    <td><input name="user_profile_flag_name" size="20"/></td>
                </tr>
                <tr>
                    <th>ｱｸｾｽ後の移動先</th>
                    <td>
                       <?php echo smarty_function_html_options(array('name' => 'user_profile_flag_convert_code','options' => $this->_tpl_vars['user_profile_flag_convert_code'],'selected' => $this->_tpl_vars['val']['convert_code']), $this);?>

                    </td>
                </tr>
                <tr>
                    <td  style="text-align: center;" colspan="3">
                        <input type="submit" id="submit" name="action_user_CreateUserProfileFlagExec" value="登　録" />
                    </td>
                </tr>
           </table>
    </form>
</div>
<br>

<?php if ($this->_tpl_vars['dataList']): ?>
    <div style="padding-bottom: 10px;">
    <?php echo $this->_tpl_vars['totalCount']; ?>
件中<br />
    <?php echo $this->_tpl_vars['dispFirst']; ?>
～<?php echo $this->_tpl_vars['dispLast']; ?>
件表示しています
    <?php if ($this->_tpl_vars['pager']): ?>
    <ul class="pager">
        <li><?php echo $this->_tpl_vars['pager']['previous']; ?>
</li>
        <li><?php echo implode($this->_tpl_vars['pager']['pages'], "</li><li>"); ?>
</li>
        <li><?php echo $this->_tpl_vars['pager']['next']; ?>
</li>
    </ul>
    <?php endif; ?>
    </div>

    <div style="padding-bottom: 10px;">
        <font color="red">通常登録時はフラクＯＦＦとなります</font><br>
        <font color="red">コード1は編集出来ません</font>
    </div>

    <table border="0" cellspacing="0" cellpadding="0" id="list_table" class="TableSet02">
    <tr>
    <th>コード</th>
    <th>コード名</th>
    <th>ｱｸｾｽ後の移動先</th>
    </tr>
    <?php $_from = $this->_tpl_vars['dataList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
        <tr>
        <?php if ($this->_tpl_vars['val']['code'] == 1): ?>
            <td><?php echo $this->_tpl_vars['val']['code']; ?>
</td>
        <?php else: ?>
            <td><a href="<?php echo smarty_function_make_link(array('action' => 'action_user_UserProfileFlagData','getTags' => ((is_array($_tmp="user_profile_flag_code=")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['val']['code']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['val']['code']))), $this);?>
" target="_blank"><?php echo $this->_tpl_vars['val']['code']; ?>
</a></td>
        <?php endif; ?>
        <td><?php echo $this->_tpl_vars['val']['name']; ?>
</td>
        <td><?php echo $this->_tpl_vars['user_profile_flag_convert_code'][$this->_tpl_vars['val']['convert_code']]; ?>
</td>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
    </table>
    <br>
    <div style="padding-bottom: 10px;">
    <?php echo $this->_tpl_vars['totalCount']; ?>
件中<br />
    <?php echo $this->_tpl_vars['dispFirst']; ?>
～<?php echo $this->_tpl_vars['dispLast']; ?>
件表示しています
    <?php if ($this->_tpl_vars['pager']): ?>
    <ul class="pager">
        <li><?php echo $this->_tpl_vars['pager']['previous']; ?>
</li>
        <li><?php echo implode($this->_tpl_vars['pager']['pages'], "</li><li>"); ?>
</li>
        <li><?php echo $this->_tpl_vars['pager']['next']; ?>
</li>
    </ul>
    <?php endif; ?>
    </div>

<?php else: ?>
    <div class="warning ui-widget">
    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    <p>
    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    該当ログはありません
    </p>
    </div>
    </div>
<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admFooter'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</body>
</html>