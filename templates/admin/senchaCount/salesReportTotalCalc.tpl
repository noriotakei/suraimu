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
            {name:'payment_month'},
            {name:'pay_total_0', type:'int'},
            {name:'sales_count_0', type:'int'},
            {name:'sales_user_0', type:'int'},
            {name:'sales_user_avg_0', type:'int'},
            {name:'pay_total_31', type:'int'},
            {name:'sales_count_31', type:'int'},
            {name:'sales_user_31', type:'int'},
            {name:'sales_user_avg_31', type:'int'},
            {name:'pay_total_61', type:'int'},
            {name:'sales_count_61', type:'int'},
            {name:'sales_user_61', type:'int'},
            {name:'sales_user_avg_61', type:'int'},
            {name:'pay_total_91', type:'int'},
            {name:'sales_count_91', type:'int'},
            {name:'sales_user_91', type:'int'},
            {name:'sales_user_avg_91', type:'int'},
            {name:'pay_total', type:'int'},
            {name:'pre_user', type:'int'},
            {name:'user', type:'int'},
            {name:'quit_user', type:'int'}
        ],
        autoLoad: true
    });

    var column = new Ext.grid.ColumnModel({
        defaults: {
             sortable: false,
             width: 100,
             align: 'right'
         },
        columns: [{
            header:'年月',
            sortable: false,
            dataIndex:'payment_month',
            width: 150
        },
        {
            header:'入金回数<br>(登録経過日数0-30)',
            sortable: false,
            dataIndex:'sales_count_0',
            width: 150,
            renderer: Ext.util.Format.numberRenderer('0,000')
        },
        {
            header:'入金者数<br>(登録経過日数0-30)',
            sortable:false,
            dataIndex:'sales_user_0',
            width: 150,
            renderer: Ext.util.Format.numberRenderer('0,000')
        },
        {
            header:'入金金額<br>(登録経過日数0-30)',
            sortable: false,
            dataIndex:'pay_total_0',
            width: 150,
            renderer: Ext.util.Format.numberRenderer('0,000')
        },
        {
            header:'入金割合<br>(登録経過日数0-30)',
            sortable: false,
            dataIndex:'sales_user_avg_0',
            width: 150,
            renderer: Ext.util.Format.numberRenderer('0.00')
        },
        {
            header:'入金回数<br>(登録経過日数31-60)',
            sortable: false,
            dataIndex:'sales_count_31',
            width: 150,
            renderer: Ext.util.Format.numberRenderer('0,000')
        },
        {
            header:'入金者数<br>(登録経過日数31-60)',
            sortable:false,
            dataIndex:'sales_user_31',
            width: 150,
            renderer: Ext.util.Format.numberRenderer('0,000')
        },
        {
            header:'入金金額<br>(登録経過日数31-60)',
            sortable: false,
            dataIndex:'pay_total_31',
            width: 150,
            renderer: Ext.util.Format.numberRenderer('0,000')
        },
        {
            header:'入金割合<br>(登録経過日数31-60)',
            sortable: false,
            dataIndex:'sales_user_avg_31',
            width: 150,
            renderer: Ext.util.Format.numberRenderer('0.00')
        },
        {
            header:'入金回数<br>(登録経過日数61-90)',
            sortable: false,
            dataIndex:'sales_count_61',
            width: 150,
            renderer: Ext.util.Format.numberRenderer('0,000')
        },
        {
            header:'入金者数<br>(登録経過日数61-90)',
            sortable:false,
            dataIndex:'sales_user_61',
            width: 150,
            renderer: Ext.util.Format.numberRenderer('0,000')
        },
        {
            header:'入金金額<br>(登録経過日数61-90)',
            sortable: false,
            dataIndex:'pay_total_61',
            width: 150,
            renderer: Ext.util.Format.numberRenderer('0,000')
        },
        {
            header:'入金割合<br>(登録経過日数61-90)',
            sortable: false,
            dataIndex:'sales_user_avg_61',
            width: 150,
            renderer: Ext.util.Format.numberRenderer('0.00')
        },
        {
            header:'入金回数<br>(登録経過日数91-)',
            sortable: false,
            dataIndex:'sales_count_91',
            width: 150,
            renderer: Ext.util.Format.numberRenderer('0,000')
        },
        {
            header:'入金者数<br>(登録経過日数91-)',
            sortable:false,
            dataIndex:'sales_user_91',
            width: 150,
            renderer: Ext.util.Format.numberRenderer('0,000')
        },
        {
            header:'入金金額<br>(登録経過日数91-)',
            sortable: false,
            dataIndex:'pay_total_91',
            width: 150,
            renderer: Ext.util.Format.numberRenderer('0,000')
        },
        {
            header:'入金割合<br>(登録経過日数91-)',
            sortable: false,
            dataIndex:'sales_user_avg_91',
            width: 150,
            renderer: Ext.util.Format.numberRenderer('0.00')
        },
        {
            header:'入金合計',
            sortable: false,
            dataIndex:'pay_total',
            width: 100,
            renderer: Ext.util.Format.numberRenderer('0,000')
        },
        {
            header:'仮登録数',
            sortable: false,
            dataIndex:'pre_user',
            width: 100,
            renderer: Ext.util.Format.numberRenderer('0,000')
        },
        {
            header:'本登録数',
            sortable:false,
            dataIndex:'user',
            width: 100,
            renderer: Ext.util.Format.numberRenderer('0,000')
        },
        {
            header:'会員解除数',
            sortable: false,
            dataIndex:'quit_user',
            width: 100,
            renderer: Ext.util.Format.numberRenderer('0,000')
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
        title:'全体売り上げ(月間)',
        height: 800,
        width:'95%',
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
