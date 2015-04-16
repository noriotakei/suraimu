<?php /* Smarty version 2.6.26, created on 2014-08-20 10:32:42
         compiled from /home/suraimu/templates/admin/banner/bannerUpd.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', '/home/suraimu/templates/admin/banner/bannerUpd.tpl', 7, false),array('modifier', 'implode', '/home/suraimu/templates/admin/banner/bannerUpd.tpl', 13, false),array('function', 'html_image', '/home/suraimu/templates/admin/banner/bannerUpd.tpl', 33, false),array('function', 'html_options', '/home/suraimu/templates/admin/banner/bannerUpd.tpl', 41, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['admHeader'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body>
<div id="ContentsCol">
    <h2 class="ContentTitle">バナー画像データ更新画面</h2>
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
    <?php endif; ?>
    <form action="./" method="post">
        <div class="SubMenu">
            <input type="submit" name="action_banner_List" value="一覧に戻る" />
        </div>
    </form>
    <?php if ($this->_tpl_vars['param']): ?>
        <form action="./" method="post" enctype="multipart/form-data">
            <?php echo $this->_tpl_vars['POSTparam']; ?>

            <table border="0" cellspacing="0" cellpadding="0" class="TableSet01">

                <tr>
                <th>画像</th>
                <td style="text-align: left;">
                <?php if ($this->_tpl_vars['param']['extension_type'] == IMAGETYPE_SWF || $this->_tpl_vars['param']['extension_type'] == IMAGETYPE_SWC): ?>
                    <?php echo smarty_function_html_image(array('file' => "./img/thumbnails/swf.jpg",'width' => '64','height' => '58','alt' => $this->_tpl_vars['param']['name']), $this);?>

                <?php else: ?>
                    <img src="./<?php echo $this->_tpl_vars['bannerPath']; ?>
<?php echo $this->_tpl_vars['param']['file_name']; ?>
.<?php echo $this->_tpl_vars['extensionTypeArray'][$this->_tpl_vars['param']['extension_type']]; ?>
?<?php echo time(); ?>
" alt ="画像">
                <?php endif; ?>
                </td>
                </tr>
                <tr>
                    <th>カテゴリー</th>
                    <td style="text-align: left;"><?php echo smarty_function_html_options(array('name' => 'banner_image_category_id','options' => $this->_tpl_vars['categoryList'],'selected' => $this->_tpl_vars['param']['banner_image_category_id']), $this);?>
</td>
                </tr>
                <tr>
                <th>名前</th>
                <td style="text-align: left;">
                    <input type="text" name="name" value="<?php echo $this->_tpl_vars['param']['name']; ?>
" size="20">
                </td>
                </tr>
                <tr>
                <th>コメント</th>
                <td style="text-align: left;">
                    <input type="text" name="comment" value="<?php echo $this->_tpl_vars['param']['comment']; ?>
" size="20">
                </td>
                </tr>
                <tr>
                <th>PATH</th>
                    <td style="text-align: left;"><?php echo $this->_tpl_vars['config']['define']['SITE_URL']; ?>
<?php echo $this->_tpl_vars['bannerPath']; ?>
<?php echo $this->_tpl_vars['param']['file_name']; ?>
.<?php echo $this->_tpl_vars['extensionTypeArray'][$this->_tpl_vars['param']['extension_type']]; ?>
</td>
                </tr>
                <tr>
                <th>FILE</th>
                <td style="text-align: left;">
                <input type="file" name="design_file">
                </td>
                </tr>
            </table>
            <div class="SubMenu">
                <input type="submit" name="action_banner_BannerAddExec" value="更 新" OnClick="return confirm('更新しますか？')" />
            </div>
        </form>
    <?php else: ?>
        <div class="warning ui-widget">
        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
        <p>
        <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
        該当データはありません
        </p>
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