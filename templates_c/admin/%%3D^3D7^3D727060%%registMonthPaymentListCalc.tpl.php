<?php /* Smarty version 2.6.26, created on 2014-08-15 10:01:40
         compiled from /home/suraimu/templates/admin/senchaCount/registMonthPaymentListCalc.tpl */ ?>
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
        autoDestroy: true,
        id:\'mystore\',
        method: \'post\',
        totalProperty:\'total\',
        baseParams:'; ?>
<?php echo $this->_tpl_vars['jsonParam']; ?>
<?php echo ',
        fields:[
            {name:\'date\'},
            {name:\'user\', type:\'int\'},
            {name:\'quit_user\', type:\'int\'},
            {name:\'total_payment\', type:\'int\'},
            {name:\'all_user\', type:\'int\'}
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
            header:\'本登録<br>入金会員人数\',
            sortable:true,
            dataIndex:\'user\',
            width: 80
        },
        {
            header:\'登録解除<br>入金会員人数\',
            sortable:true,
            dataIndex:\'quit_user\',
            width: 80
        },
        {
            header:\'合計入金<br>会員人数\',
            sortable:true,
            dataIndex:\'all_user\',
            width: 80
        },
        {
            header:\'入金金額\',
            sortable:true,
            dataIndex:\'total_payment\',
            width: 100,
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
            },
            forceFit: true
        },
        renderTo:\'grid\',
        id:\'my-grid\',
        title:\'当月登録入金者(期間指定で登録日縛りができます)\',
        autoHeight: true,
        width:550,
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
