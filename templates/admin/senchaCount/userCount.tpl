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

    var store = new Ext.data.GroupingStore({
        url:'index.php',
        autoDestroy: true,
        id:'mystore',
        method: 'post',
        root:'rows',
        baseParams:{/literal}{$jsonParam}{literal},
        reader: new Ext.data.JsonReader({
                    // ルートノード設定
                    root: 'rows',
                    id: 'id',
                    fields:[
                            {name:'name'},
                            {name:'count', type:'int'},
                            {name:'persent'},
                            {name:'group'}
                        ]
                }),
        groupField:'group',
        autoLoad: true
    });

    var column = new Ext.grid.ColumnModel({
        defaults: {
             width: 100,
             align: 'right',
             sortable:false
         },
        columns: [
        {
            header:'グループ',
            width: 100,
            dataIndex:'group',
            sortable:true,
            align: 'left'
        },
        {
            header:'項目',
            width: 100,
            groupable: false,
            dataIndex:'name',
            align: 'left'
        },
        {
            header:'人数',
            dataIndex:'count',
            groupable: false,
            width: 50,
            renderer: Ext.util.Format.numberRenderer('0,000')
        },
        {
            header:'割合',
            dataIndex:'persent',
            groupable: false,
            width: 60,
            renderer: function (val, metaData, record) {
                return Ext.util.Format.number(val, '0,0.00%');
            }
        }
    ]});

    new Ext.grid.GridPanel({
        viewConfig: {
            templates: {
                cell: new Ext.Template(
                '<td class="x-grid3-col x-grid3-cell x-grid3-td-{id} x-selectable {css}" style="{style}" tabIndex="0" {cellAttr}>',
                '<div class="x-grid3-cell-inner x-grid3-col-{id}" {attr}>{value}</div>',
                '</td>'
                )
            },
            forceFit: true
        },
        renderTo:'grid',
        id:'my-grid',
        title:'会員数合計',
        autoHeight:true,
        width: 400,
        cm:column,
        frame:true,
        store:store,
        stripeRows: true,
        columnLines: true,
        loadMask: true,
        view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text}',
            hideGroupedColumn: true,
            templates: {
                cell: new Ext.Template(
                '<td class="x-grid3-col x-grid3-cell x-grid3-td-{id} x-selectable {css}" style="{style}" tabIndex="0" {cellAttr}>',
                '<div class="x-grid3-cell-inner x-grid3-col-{id}" {attr}>{value}</div>',
                '</td>'
                )
            }
        })
    });
{/literal}

// -->
</script>

<div id="grid"></div>