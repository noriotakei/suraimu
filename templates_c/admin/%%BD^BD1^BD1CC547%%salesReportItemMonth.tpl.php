<?php /* Smarty version 2.6.26, created on 2014-08-15 19:44:12
         compiled from /home/suraimu/templates/admin/senchaCount/salesReportItemMonth.tpl */ ?>
<?php echo '
<style type="text/css"><!--
.x-grid3-cell-inner, .x-grid3-hd-inner {
white-space : normal ! important;
orverfloaw: auto;
}
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
            {name:\'item_category_id\'},
            {name:\'item_category_name\'},
            {name:\'item_id\'},
            {name:\'item_name\'},
            {name:\'price\', type:\'int\'},
            {name:\'ordering_cnt\', type:\'int\'},
            {name:\'total_pay\', type:\'int\'}
        ],
        sortInfo: {field:\'item_id\', direction:\'ASC\'},
        autoLoad: true
    });

    var column = new Ext.grid.ColumnModel({
        defaults: {
             sortable: true,
             width: 100,
             align: \'right\'
         },
        columns: [
        {
            header:\'カテゴリID\',
            sortable:true,
            dataIndex:\'item_category_id\',
            width: 80
        },
        {
            header:\'カテゴリ名\',
            sortable:true,
            dataIndex:\'item_category_name\',
            width: 150
        },
        {
            header:\'商品ID\',
            sortable:true,
            dataIndex:\'item_id\',
            width: 70,
            renderer: function (val, metaData, record) {
                var link;
                if (!isNaN(val) && val) {
                    link = \'<a href="./?action_itemManagement_ItemData=1&iid=\' + val + \'" target=_blank>\' + val + \'<\\/a>\'
                } else {
                    link = val;
                }
                return link;
            }
        },
        {
            header:\'商品\',
            sortable:true,
            dataIndex:\'item_name\',
            width: 400,
             align: \'left\'
        },
        {
            header:\'価格\',
            sortable:true,
            dataIndex:\'price\',
            width: 100,
            renderer: Ext.util.Format.numberRenderer(\'0,000\')
        },
        {
            header:\'件数\',
            sortable:true,
            dataIndex:\'ordering_cnt\',
            width: 50
        },
        {
            header:\'合計\',
            sortable:true,
            dataIndex:\'total_pay\',
            width: 150,
            renderer: Ext.util.Format.numberRenderer(\'0,000\')
        }
    ]});

    // フィルター用
    var tbar = [
        \'カテゴリID:\',
        {
            xtype:\'textfield\',
            emptyText:\'ｶﾝﾏで複数可\',
            listeners:{
                valid:function(field){
                    var cond = field.getValue();
                    store.load({
                        params:{
                            item_category_id:cond
                        }
                    });
                }
            }
        },
        \'商品ID:\',
        {
            xtype:\'textfield\',
            emptyText:\'ｶﾝﾏで複数可\',
            listeners:{
                valid:function(field){
                    var cond = field.getValue();
                    store.load({
                        params:{
                            item_id:cond
                        }
                    });
                }
            }
        }
    ];

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
<?php echo '当月登録商品別売り上げ(月間)\',
        height:800,
        width:1100,
        cm:column,
        store:store,
        frame:true,
        stripeRows: true,
        columnLines: true,
        loadMask: true,
        tbar:tbar
    });

'; ?>


// -->
</script>
<div id="grid"></div>