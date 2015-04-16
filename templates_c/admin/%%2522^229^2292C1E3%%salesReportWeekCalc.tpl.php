<?php /* Smarty version 2.6.26, created on 2014-08-09 10:57:29
         compiled from /home/suraimu/templates/admin/senchaCount/salesReportWeekCalc.tpl */ ?>
<?php echo '
<style type="text/css"><!--
.x-selectable, .x-selectable * {
-moz-user-select: text!important;
-khtml-user-select: text!important;
}
-->
</style>
'; ?>

<script language="JavaScript">
<!--
<?php echo '
    var store = new Ext.data.JsonStore({
        url:\'index.php\',
        root:\'rows\',
        totalProperty:\'total\',
        autoDestroy: true,
        id:\'mystore\',
        method: \'post\',
        baseParams:'; ?>
<?php echo $this->_tpl_vars['jsonParam']; ?>
<?php echo ',
        fields:[
            {name:\'date\'},
            {name:\'order_cnt\', type:\'int\'},
            {name:\'ordering_pay_total\', type:\'int\'},
            {name:\'user\'},
            {name:\'user_price\', type:\'int\'},
            {name:\'sales_user\'},
            {name:\'sales_user_price\', type:\'int\'},
            {name:\'pay_total\', type:\'int\'},
            '; ?>

            <?php $_from = $this->_tpl_vars['payType']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['payTypeLoop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['payTypeLoop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['payTypeKey'] => $this->_tpl_vars['payTypeVal']):
        $this->_foreach['payTypeLoop']['iteration']++;
?>
                {name:'pay_type_<?php echo $this->_tpl_vars['payTypeKey']; ?>
', type:'int'}
                <?php if (! ($this->_foreach['payTypeLoop']['iteration'] == $this->_foreach['payTypeLoop']['total'])): ?>,<?php endif; ?>
            <?php endforeach; endif; unset($_from); ?><?php echo '
        ],
        sortInfo: {field:\'date\', direction:\'ASC\'},
        autoLoad: true
    });

    var column = new Ext.grid.ColumnModel({
        defaults: {
             sortable: true,
             width: 100,
             align: \'right\'
         },
        columns: [{
            header:\'日付\',
            sortable:true,
            dataIndex:\'date\',
            width: 130,
            align: \'left\'
        },
        {
            header:\'注文件数\',
            sortable:true,
            dataIndex:\'order_cnt\',
            width: 80
        },
        {
            header:\'注文金額\',
            sortable:true,
            dataIndex:\'ordering_pay_total\',
            width: 100,
            renderer: Ext.util.Format.numberRenderer(\'0,000\')
        },
        {
            header:\'注文者数<br>(本登録｜会員解除)\',
            sortable:false,
            dataIndex:\'user\',
            width: 150
        },
        {
            header:\'注文単価\',
            sortable:true,
            dataIndex:\'user_price\',
            width: 100,
            renderer: Ext.util.Format.numberRenderer(\'0,000\')
        },
        {
            header:\'売上合計\',
            sortable:true,
            dataIndex:\'pay_total\',
            width: 100,
            sortable:true,
            renderer: Ext.util.Format.numberRenderer(\'0,000\')
        },
        {
            header:\'購入者数<br>(本登録｜会員解除)\',
            sortable:false,
            dataIndex:\'sales_user\',
            width: 150
        },
        {
            header:\'客単価\',
            sortable:true,
            dataIndex:\'sales_user_price\',
            width: 100,
            renderer: Ext.util.Format.numberRenderer(\'0,000\')
        },
        '; ?>

        <?php $_from = $this->_tpl_vars['payType']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['payTypeLoop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['payTypeLoop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['payTypeKey'] => $this->_tpl_vars['payTypeVal']):
        $this->_foreach['payTypeLoop']['iteration']++;
?>
            {
                header:'決済別売上<br>(<?php echo $this->_tpl_vars['payTypeVal']; ?>
)',
                sortable:true,
                dataIndex:'pay_type_<?php echo $this->_tpl_vars['payTypeKey']; ?>
',
                width: 190,
                renderer: Ext.util.Format.numberRenderer('0,000')
            }
            <?php if (! ($this->_foreach['payTypeLoop']['iteration'] == $this->_foreach['payTypeLoop']['total'])): ?>,<?php endif; ?>
        <?php endforeach; endif; unset($_from); ?><?php echo '
    ]});

    new Ext.grid.GridPanel({
        viewConfig: {
            templates: {
                cell: new Ext.Template(
                \'<td class="x-grid3-col x-grid3-cell x-grid3-td-{id} x-selectable {css}" style="{style}" tabIndex="0" {cellAttr}>\',
                \'<div class="x-grid3-cell-inner x-grid3-col-{id}" {attr}>{value}</div>\',
                \'</td>\'
                )
            }
        },
        renderTo:\'grid\',
        id:\'my-grid\',
        title:\''; ?>
<?php echo $this->_tpl_vars['month']; ?>
<?php echo '売り上げ(週間)\',
        height: 400,
        width:\'95%\',
        cm:column,
        store:store,
        frame:true,
        stripeRows: true,
        columnLines: true,
        loadMask: true
    });
'; ?>

// -->
</script>
<div id="grid"></div>