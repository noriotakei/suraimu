<?php /* Smarty version 2.6.26, created on 2014-08-08 18:50:36
         compiled from /home/suraimu/templates/admin/senchaCount/informationStatusCntOfDay.tpl */ ?>
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
    var dispcnt = 30;
    var store = new Ext.data.JsonStore({
        url:\'index.php\',
        autoDestroy: true,
        id:\'mystore\',
        method: \'post\',
        root:\'rows\',
        totalProperty:\'total\',
        baseParams:'; ?>
<?php echo $this->_tpl_vars['jsonParam']; ?>
<?php echo ',
        fields:[
            {name:\'create_date\'},
            {name:\'id\'},
            {name:\'name\'},
            {name:\'cnt\', type:\'int\'}
        ],
        sortInfo: {field:\'cnt\', direction:\'DESC\'},
        remoteSort: true,
        autoLoad: {params: {start: 0, limit: dispcnt}}
    });

    var expander = new Ext.ux.grid.RowExpander({
            tpl : new Ext.Template(
                \'<table border="0" cellspacing="0" cellpadding="0" width="700"><tr><td><b>情報名:</b> {name}</td></tr></table>\'
            )
        });

    var column = new Ext.grid.ColumnModel({
        defaults: {
             sortable: true,
             width: 100,
             align: \'right\'
         },
        columns: [
        expander,
        {
            header:\'閲覧日付\',
            sortable:true,
            dataIndex:\'create_date\',
            width: 180
        },
        {
            header:\'ID\',
            sortable:true,
            dataIndex:\'id\',
            width: 80,
            renderer: function (val, metaData, record) {
                return \'<a href="./?action_informationStatus_informationData=1&isid=\' + val + \'" target=_blank>\' + val + \'<\\/a>\';
            }
        },
        {
            header:\'管理用情報名\',
            sortable:false,
            dataIndex:\'name\',
            width: 300,
             align: \'left\'
        },
        {
            header:\'閲覧回数\',
            sortable:true,
            dataIndex:\'cnt\',
            width: 80
        }
    ]});

    // フィルター用
    var tbar = [
        \'情報ID:\',
        {
            xtype:\'textfield\',
            emptyText:\'ｶﾝﾏで複数可\',
            listeners:{
                valid:function(field){
                    var cond = field.getValue();
                    store.load({
                        params:{
                            id:cond,
                            start: 0,
                            limit: dispcnt
                        }
                    });
                }
            }
        }
    ];

    var bbar = new Ext.PagingToolbar({
        store:store,
        pageSize:dispcnt,
        displayInfo: true,
        displayMsg: \'{2}件中、{0}～{1}件目表示中\',
        emptyMsg: \'データなし\',
        plugins: new Ext.ux.SlidingPager()
    });

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
        title:\'情報閲覧回数リスト(日毎)\',
        height:800,
        width: 700,
        cm:column,
        plugins: expander,
        store:store,
        frame:true,
        stripeRows: true,
        columnLines: true,
        loadMask: true,
        tbar:tbar,
        bbar:bbar
    });
'; ?>


// -->
</script>
<div id="grid"></div>