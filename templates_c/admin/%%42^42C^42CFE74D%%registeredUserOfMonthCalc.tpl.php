<?php /* Smarty version 2.6.26, created on 2014-08-08 18:30:10
         compiled from /home/suraimu/templates/admin/senchaCount/registeredUserOfMonthCalc.tpl */ ?>
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
    Ext.Ajax.timeout = 120000;
    var store = new Ext.data.JsonStore({
        url:\'index.php\',
        root:\'rows\',
        autoDestroy: true,
        id:\'mystore\',
        method: \'post\',
        totalProperty:\'total\',
        baseParams:'; ?>
<?php echo $this->_tpl_vars['jsonParam']; ?>
<?php echo ',
        fields:[
            {name:\'date\'},
            {name:\'all_user\', type:\'int\'},
            {name:\'pre_user\', type:\'int\'},
            {name:\'user\', type:\'int\'},
            {name:\'quit_user\', type:\'int\'},
            {name:\'order_cnt\', type:\'int\'},
            {name:\'pay_total\'},
            {name:\'user_price\', type:\'int\'}
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
            width: 120
        },
        {
            header:\'合計<br>会員人数\',
            sortable:true,
            dataIndex:\'all_user\',
            width: 100
        },
        {
            header:\'仮登録<br>会員人数\',
            sortable:true,
            dataIndex:\'pre_user\',
            width: 100
        },
        {
            header:\'本登録<br>会員人数\',
            sortable:true,
            dataIndex:\'user\',
            width: 100
        },
        {
            header:\'登録解除<br>会員人数\',
            sortable:true,
            dataIndex:\'quit_user\',
            width: 120,
            sortable:true
        },
        {
            header:\'注文件数\',
            sortable:true,
            dataIndex:\'order_cnt\',
            width: 80
        },
        {
            header:\'注文金額 / 入金額\',
            sortable:false,
            dataIndex:\'pay_total\',
            width: 140
        },
        {
            header:\'平均注文単価<br>(注文額÷注文件数)\',
            sortable:true,
            dataIndex:\'user_price\',
            width: 140,
            renderer: Ext.util.Format.numberRenderer(\'0,000\')
        }
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
<?php echo 'ユーザー登録数(月間)\',
        height: 800,
        width:1000,
        cm:column,
        frame:true,
        store:store,
        stripeRows: true,
        columnLines: true,
        loadMask: true
    });
'; ?>


// -->
</script>
<div id="grid"></div>