{literal}
<style type="text/css"><!--
.x-selectable, .x-selectable * {
-moz-user-select: text!important;
-khtml-user-select: text!important;
}
-->
</style>
{/literal}
<script language="JavaScript">
<!--
{literal}
    var dispcnt = 30;
    var store = new Ext.data.JsonStore({
        url:'index.php',
        autoDestroy: true,
        id:'mystore',
        method: 'post',
        root:'rows',
        totalProperty:'total',
        baseParams:{/literal}{$jsonParam}{literal},
        fields:[
            {name:'id'},
            {name:'name'},
            {name:'display_start_datetime'},
            {name:'display_end_datetime'},
            {name:'cnt', type:'int'}
        ],
        sortInfo: {field:'cnt', direction:'DESC'},
        remoteSort: true,
        autoLoad: {params: {start: 0, limit: dispcnt}}
    });

    var expander = new Ext.ux.grid.RowExpander({
            tpl : new Ext.Template(
                '<table border="0" cellspacing="0" cellpadding="0" width="700"><tr><td><b>情報名:</b> {name}</td></tr></table>'
            )
        });

    var column = new Ext.grid.ColumnModel({
        defaults: {
             sortable: true,
             width: 100,
             align: 'right'
         },
        columns: [
        expander,
        {
            header:'ID',
            sortable:true,
            dataIndex:'id',
            width: 80,
            renderer: function (val, metaData, record) {
                return '<a href="./?action_informationStatus_informationData=1&isid=' + val + '" target=_blank>' + val + '<\/a>';
            }
        },
        {
            header:'管理用情報名',
            sortable:false,
            dataIndex:'name',
            width: 300,
            align: 'left'
        },
        {
            header:'閲覧回数',
            sortable:true,
            dataIndex:'cnt',
            width: 80
        },
        {
            header:'表示開始日時',
            sortable:false,
            dataIndex:'display_start_datetime',
            width: 150
        },
        {
            header:'表示終了日時',
            sortable:false,
            dataIndex:'display_end_datetime',
            width: 150
        }
    ]});

    // フィルター用
    var tbar = [
        '情報ID:',
        {
            xtype:'textfield',
            emptyText:'ｶﾝﾏで複数可',
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
        displayMsg: '{2}件中、{0}～{1}件目表示中',
        emptyMsg: 'データなし',
        plugins: new Ext.ux.SlidingPager()
    });

    new Ext.grid.GridPanel({
        viewConfig: {
            templates: {
                cell: new Ext.Template(
                '<td class="x-grid3-col x-grid3-cell x-grid3-td-{id} x-selectable {css}" style="{style}" tabIndex="0" {cellAttr}>',
                '<div class="x-grid3-cell-inner x-grid3-col-{id}" {attr}>{value}</div>',
                '</td>'
                )
            }
        },
        renderTo:'grid',
        id:'my-grid',
        title:'情報ランキング',
        height:800,
        width: 800,
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
{/literal}

// -->
</script>
<div id="grid"></div>
