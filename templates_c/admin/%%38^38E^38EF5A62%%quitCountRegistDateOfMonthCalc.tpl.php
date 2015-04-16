<?php /* Smarty version 2.6.26, created on 2014-10-27 17:46:08
         compiled from /home/suraimu/templates/admin/senchaCount/quitCountRegistDateOfMonthCalc.tpl */ ?>
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
            {name:\'regist_cnt\', type:\'int\'},
            {name:\'quit_cnt\', type:\'int\'},
            {name:\'remain_total_cnt\', type:\'int\'},
            {name:\'survival_rate\', type:\'float\'}
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
            header:\'日付\',
            sortable:true,
            dataIndex:\'date\',
            width: 120
        },
        {
            header:\'登録人数\',
            sortable:true,
            dataIndex:\'regist_cnt\',
            width: 80
        },
        {
            header:\'退会者数\',
            sortable:true,
            dataIndex:\'quit_cnt\',
            width: 80
        },
        {
            header:\'残会員数\',
            sortable:true,
            dataIndex:\'remain_total_cnt\',
            width: 80
        },
        {
            header:\'会員残留率\',
            sortable:true,
            dataIndex:\'survival_rate\',
            width: 80,
            renderer: function (val, metaData, record) {
                return Ext.util.Format.number(val, \'0,0.0%\');
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
        title:\''; ?>
<?php echo $this->_tpl_vars['month']; ?>
<?php echo '登録日毎退会者数(月間)\',
        autoHeight: true,
        width:450,
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
