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
        root:'rows',
        autoDestroy: true,
        id:'mystore',
        method: 'post',
        totalProperty:'total',
        baseParams:{/literal}{$jsonParam}{literal},
        fields:[
            {name:'date'},
            {name:'quit_cnt', type:'int'}
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
            header:'日付',
            sortable:true,
            dataIndex:'date',
            width: 150
        },
        {
            header:'退会数',
            sortable:true,
            dataIndex:'quit_cnt',
            width: 80
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
        title:'{/literal}{$month}{literal}退会者人数(月間)',
        autoHeight: true,
        width:300,
        cm:column,
        frame:true,
        store:store,
        stripeRows: true,
        columnLines: true,
        loadMask: true
    });
{/literal}
// -->
</script>
<div id="grid"></div>
