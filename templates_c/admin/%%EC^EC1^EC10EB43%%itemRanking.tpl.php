<?php /* Smarty version 2.6.26, created on 2014-08-26 12:06:48
         compiled from /home/suraimu/templates/admin/senchaCount/itemRanking.tpl */ ?>
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
            {name:\'item_category_id\'},
            {name:\'item_category_name\'},
            {name:\'item_id\'},
            {name:\'item_name\'},
            {name:\'sales_start_datetime\'},
            {name:\'sales_end_datetime\'},
            {name:\'item_cnt\', type:\'int\'},
            {name:\'order_cnt\', type:\'int\'},
            {name:\'price\', type:\'int\'},
            {name:\'order_price\', type:\'int\'},
            {name:\'item_access_key\'},
            {name:\'buy_persent\'}
        ],
        sortInfo: {field:\'price\', direction:\'DESC\'},
        remoteSort: true,
        autoLoad: {params: {start: 0, limit: dispcnt}}
    });

    var expander = new Ext.ux.grid.RowExpander({
            tpl : new Ext.Template(
                \'<table border="0" cellspacing="0" cellpadding="0" width="700"><tr><td><b>商品名:</b>{item_name}</td></tr></table>\'
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
            width: 50,
            renderer: function (val, metaData, record) {
                return \'<a href="./?action_informationStatus_InformationSearchList=1&search_html_text_type[]=1&search_html_text_type[]=2&search_html_text_type[]=3&search_html_text_type[]=4\'
                + \'&search_type=6&search_html_text=\' + record.data[\'item_access_key\'] + \'" target=_blank>\' + val + \'<\\/a>\';
            }
        },
        {
            header:\'商品名\',
            sortable:true,
            dataIndex:\'item_name\',
            width: 250,
            align: \'left\'
        },
        {
            header:\'注文回数\',
            sortable:true,
            dataIndex:\'order_cnt\',
            width: 80
        },
        {
            header:\'注文金額\',
            sortable:true,
            dataIndex:\'order_price\',
            width: 100,
            renderer: function (val, metaData, record) {
                if (!val) {
                    return 0;
                } else {
                    return Ext.util.Format.number(val, \'0,000\');
                }
            }
        },
        {
            header:\'購入回数\',
            sortable:true,
            dataIndex:\'item_cnt\',
            width: 80
        },
        {
            header:\'購入金額\',
            sortable:true,
            dataIndex:\'price\',
            width: 100,
            renderer: function (val, metaData, record) {
                if (!val) {
                    return 0;
                } else {
                    return Ext.util.Format.number(val, \'0,000\');
                }
            }
        },
        {
            header:\'購入率\',
            sortable:true,
            dataIndex:\'buy_persent\',
            width: 80,
            renderer: function (val, metaData, record) {
                if (!val) {
                    return 0;
                } else {
                    return Ext.util.Format.number(val, \'0.0\') + \'%\';
                }
            }
        },
        {
            header:\'表示開始日時\',
            sortable:false,
            dataIndex:\'sales_start_datetime\',
            width: 120
        },
        {
            header:\'表示終了日時\',
            sortable:false,
            dataIndex:\'sales_end_datetime\',
            width: 120
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
                            item_id:cond,
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
        title:\'商品ランキング\',
        height: 800,
        width: 1300,
        plugins: expander,
        cm: column,
        store: store,
        stripeRows: true,
        columnLines: true,
        frame:true,
        loadMask: true,
        tbar: tbar,
        bbar: bbar
    });
'; ?>


// -->
</script>
<div id="grid"></div>