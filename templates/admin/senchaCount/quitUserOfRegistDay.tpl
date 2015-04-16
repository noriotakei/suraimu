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
            {name:'user_id'},
            {name:'regist_datetime'},
            {name:'quit_datetime'},
            {name:'pc_device'},
            {name:'mb_device'},
            {name:'regist_status'}
        ],
        sortInfo: {field:'quit_datetime', direction:'ASC'},
        autoLoad: true
    });

    var column = new Ext.grid.ColumnModel({
        defaults: {
             sortable: true,
             width: 100,
             align: 'right'
         },
        columns: [{
            header:'ユーザーID',
            sortable:true,
            dataIndex:'user_id',
            width: 80,
            renderer: function (val, metaData, record) {
                return '<a href="./?action_user_Detail=1&user_id=' + val + '" target=_blank>' + val + '<\/a>';
            }
        },
        {
            header:'会員登録日',
            sortable:true,
            dataIndex:'regist_datetime',
            width: 150
        },
        {
            header:'会員退会日',
            sortable:true,
            dataIndex:'quit_datetime',
            width: 150
        },
        {
            header:'PCデバイス',
            sortable:true,
            dataIndex:'pc_device',
            width: 80
        },
        {
            header:'MBデバイス',
            sortable:true,
            dataIndex:'mb_device',
            width: 80,
            sortable:true
        },
        {
            header:'ステータス',
            sortable:true,
            dataIndex:'regist_status',
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
        title:'退会者人数(登録日)',
        height:800,
        width:700,
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