<?php /* Smarty version 2.6.26, created on 2015-03-11 12:52:29
         compiled from /home/suraimu/templates/admin/senchaCount/paymentCountSinceOpenSite.tpl */ ?>
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
        autoDestroy: true,
        id:\'mystore\',
        method: \'post\',
        root:\'rows\',
        baseParams:'; ?>
<?php echo $this->_tpl_vars['jsonParam']; ?>
<?php echo ',
        fields:[
            {name:\'order_cnt\'},
            {name:\'user_cnt\', type:\'int\'},
            {name:\'pay_total\', type:\'int\'},
            {name:\'user_price\', type:\'int\'},
            {name:\'pay_total_rate\', type:\'float\'},
            {name:\'user\', type:\'int\'},
            {name:\'user_cnt_rate\', type:\'float\'},
            {name:\'quit_user\', type:\'int\'},
            {name:\'quit_user_rate\', type:\'float\'},
            {name:\'paid_date\'}
        ],
        autoLoad: true
    });

    var column = new Ext.grid.ColumnModel({
        defaults: {
             sortable: true,
             width: 100,
             align: \'right\'
         },
        columns: [{
            header:\'入金回数\',
            sortable:true,
            dataIndex:\'order_cnt\',
            width: 80
        },
        {
            header:\'購入人数\',
            sortable:true,
            dataIndex:\'user_cnt\',
            width: 80,
            renderer: function (val, metaData, record) {
                if (!val) {
                    return 0;
                } else {
                    return val;
                }
            }
        },
        {
            header:\'購入額\',
            sortable:true,
            dataIndex:\'pay_total\',
            width: 100,
            renderer: Ext.util.Format.numberRenderer(\'0,000\')
        },
        {
            header:\'1人当りの<br>平均購入額\',
            sortable:true,
            dataIndex:\'user_price\',
            width: 100,
            renderer: Ext.util.Format.numberRenderer(\'0,000\')
        },
        {
            header:\'---\',
            sortable:true,
            dataIndex:\'pay_total_rate\',
            width: 80,
            renderer: function (val, metaData, record) {
                return Ext.util.Format.number(val, \'0,0.00%\');
            }
        },
        {
            header:\'購入会員数\',
            sortable:true,
            dataIndex:\'user\',
            width: 80,
            renderer: function (val, metaData, record) {
                if (!val) {
                    return 0;
                } else {
                    return val;
                }
            }
        },
        {
            header:\'---\',
            sortable:true,
            dataIndex:\'user_cnt_rate\',
            width: 80,
            renderer: function (val, metaData, record) {
                return Ext.util.Format.number(val, \'0,0.00%\');
            }
        },
        {
            header:\'退会会員数\',
            sortable:true,
            dataIndex:\'quit_user\',
            width: 80,
            renderer: function (val, metaData, record) {
                if (!val) {
                    return 0;
                } else {
                    return val;
                }
            }
        },
        {
            header:\'---\',
            sortable:true,
            dataIndex:\'quit_user_rate\',
            width: 80,
            renderer: function (val, metaData, record) {
                return Ext.util.Format.number(val, \'0,0.00%\');
            }
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
            },
            forceFit: true
        },
        renderTo:\'grid\',
        id:\'my-grid\',
        title:\'入金回数(ｻｲﾄｵｰﾌﾟﾝ時からの累計)\',
        autoHeight:true,
        width:800,
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
<div id="grid"></div>s