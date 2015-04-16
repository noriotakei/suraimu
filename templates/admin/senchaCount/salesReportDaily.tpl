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
            {name:'order_cnt', type:'int'},
            {name:'ordering_pay_total', type:'int'},
            {name:'user'},
            {name:'user_price', type:'int'},
            {name:'sales_user'},
            {name:'sales_user_price', type:'int'},
            {name:'pay_total', type:'int'},
            {/literal}
            {foreach from=$payType key="payTypeKey" item="payTypeVal" name="payTypeLoop"}
                {ldelim}name:'pay_type_{$payTypeKey}'{rdelim}
                {if not $smarty.foreach.payTypeLoop.last},{/if}
            {/foreach}{literal}
        ],
        sortInfo: {field:'date', direction:'ASC'},
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
            header:'注文件数',
            sortable:true,
            dataIndex:'order_cnt',
            width: 80
        },
        {
            header:'注文金額',
            sortable:true,
            dataIndex:'ordering_pay_total',
            width: 100,
            renderer: Ext.util.Format.numberRenderer('0,000')
        },
        {
            header:'注文者数<br>(本登録｜会員解除)',
            sortable:false,
            dataIndex:'user',
            width: 150
        },
        {
            header:'注文単価',
            sortable:true,
            dataIndex:'user_price',
            width: 100,
            renderer: Ext.util.Format.numberRenderer('0,000')
        },
        {
            header:'売上合計',
            sortable:true,
            dataIndex:'pay_total',
            width: 100,
            renderer: Ext.util.Format.numberRenderer('0,000')
        },
        {
            header:'購入者数<br>(本登録｜会員解除)',
            sortable:false,
            dataIndex:'sales_user',
            width: 150
        },
        {
            header:'客単価',
            sortable:true,
            dataIndex:'sales_user_price',
            width: 100,
            renderer: Ext.util.Format.numberRenderer('0,000')
        },
        {/literal}
        {foreach from=$payType key="payTypeKey" item="payTypeVal" name="payTypeLoop"}
            {ldelim}
                header:'決済別売上<br>({$payTypeVal})',
                sortable:true,
                dataIndex:'pay_type_{$payTypeKey}',
                width: 190,
                renderer: Ext.util.Format.numberRenderer('0,000')
            {rdelim}
            {if not $smarty.foreach.payTypeLoop.last},{/if}
        {/foreach}{literal}
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
        title:'売り上げ(日毎)',
        height:300,
        width:'95%',
        frame:true,
        cm:column,
        store:store,
        stripeRows: true,
        columnLines: true,
        loadMask: true
    });
{/literal}

// -->
</script>
<div id="grid"></div>
<br><br><br>
