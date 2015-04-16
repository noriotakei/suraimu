<?php /* Smarty version 2.6.26, created on 2014-08-15 10:01:51
         compiled from /home/suraimu/templates/admin/senchaCount/activeUser2Calc.tpl */ ?>
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
            {name:\'name\'},
            {name:\'cnt\', type:\'int\'},
            {name:\'rate\', type:\'float\'}
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
            header:\'前回アクセスまでの期間\',
            sortable:false,
            dataIndex:\'name\',
            width: 100
        },
        {
            header:\'人数\',
            sortable:true,
            dataIndex:\'cnt\',
            width: 80,
            renderer: Ext.util.Format.numberRenderer(\'0,000\')
        },
        {
            header:\'割合\',
            sortable:true,
            dataIndex:\'rate\',
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
        title:\'アクティブ会員リスト2\',
        autoHeight: true,
        width:500,
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