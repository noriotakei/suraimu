{literal}
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
            {name:'id'},
            {name:'ordering_id', type:'int'},
            {name:'user_id', type:'int'},
            {name:'receive_money', type:'int'},
            {name:'telno'},
            {name:'bank_name'},
            {name:'branch_name'},
            {name:'fkoza'},
            {name:'is_manual'},
            {name:'create_datetime'}
        ],
        sortInfo: {field:'id', direction:'ASC'},
        autoLoad: true
    });

    var column = new Ext.grid.ColumnModel({
        defaults: {
             sortable: true,
             width: 100,
             align: 'left'
         },
        columns: [{
            header:'ID',
            sortable:true,
            dataIndex:'id',
            width: 80
        },
        {
            header:'注文ID',
            sortable:true,
            dataIndex:'ordering_id',
            width: 80,
            renderer: function (val, metaData, record) {
                var link;
                if (!isNaN(val) && val) {
                    link = '<a href="./?action_ordering_OrderingData=1&ordering_id=' + val + '" target=_blank>' + val + '<\/a>'
                } else {
                    link = val;
                }
                return link;
            }
        },
        {
            header:'ユーザーID',
            sortable:true,
            dataIndex:'user_id',
            width: 80,
            renderer: function (val, metaData, record) {
                var link;
                if (!isNaN(val) && val) {
                    link = '<a href="./?action_user_Detail=1&user_id=' + val + '" target=_blank>' + val + '<\/a>'
                } else {
                    link = val;
                }
                return link;
            }
        },
        {
            header:'入金金額',
            sortable:true,
            dataIndex:'receive_money',
            width: 100,
            align: 'right',
            renderer: Ext.util.Format.numberRenderer('0,000')
        },
        {
            header:'入力振込み人名',
            sortable:false,
            dataIndex:'telno',
            width: 100,
            sortable:true
        },
        {
            header:'銀行名',
            sortable:false,
            dataIndex:'bank_name',
            width: 150
        },
        {
            header:'支店名',
            sortable:false,
            dataIndex:'branch_name',
            width: 150
        },
        {
            header:'振込先口座',
            sortable:false,
            dataIndex:'fkoza',
            width: 80
        },
        {
            header:'処理方法',
            sortable:true,
            dataIndex:'is_manual',
            width: 80,
            renderer: function (val, metaData, record) {
                return (val ? '手動' : '自動');
            }
        },
        {
            header:'BAS処理日時',
            sortable:true,
            dataIndex:'create_datetime',
            width: 150
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
            }
        },
        renderTo:'grid',
        id:'my-grid',
        title:'エラー銀行振込ログリスト',
        height:800,
        width:1060,
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
