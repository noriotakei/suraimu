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
    var store = new Ext.data.JsonStore({
        url:'index.php',
        autoDestroy: true,
        id:'mystore',
        method: 'post',
        root:'rows',
        baseParams:{/literal}{$jsonParam}{literal},
        fields:[
            {name:'name'},
            {name:'cnt', type:'int'},
            {name:'rate', type:'float'}
        ],
        autoLoad: true
    });

    var column = new Ext.grid.ColumnModel({
        defaults: {
             sortable: true,
             width: 100,
             align: 'right'
         },
        columns: [{
            header:'前回アクセスまでの期間',
            sortable:false,
            dataIndex:'name',
            width: 100
        },
        {
            header:'人数',
            sortable:true,
            dataIndex:'cnt',
            width: 80,
            renderer: Ext.util.Format.numberRenderer('0,000')
        },
        {
            header:'割合',
            sortable:true,
            dataIndex:'rate',
            width: 80,
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
        title:'アクティブ会員リスト',
        autoHeight: true,
        width:500,
        cm:column,
        store:store,
        frame:true,
        stripeRows: true,
        columnLines: true,
        loadMask: true
    });
{/literal}

// -->
</script>
<div id="grid"></div>