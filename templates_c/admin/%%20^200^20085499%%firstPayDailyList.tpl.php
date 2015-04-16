<?php /* Smarty version 2.6.26, created on 2014-08-19 18:35:55
         compiled from /home/suraimu/templates/admin/senchaCount/firstPayDailyList.tpl */ ?>
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
            {name:\'user_id\', type:\'int\'},
            {name:\'first_pay_datetime\'},
            {name:\'pre_regist_datetime\'},
            {name:\'regist_datetime\'},
            {name:\'media_cd\'},
            {name:\'total_payment\', type:\'int\'},
            {name:\'buy_count\', type:\'int\'},
            {name:\'pc_device\'},
            {name:\'mb_device\'},
            {name:\'regist_status\'}
        ],
        autoLoad: true
    });

    var column = new Ext.grid.ColumnModel({
        defaults: {
             sortable: true,
             width: 100,
             align: \'right\'
         },
        columns: [
        new Ext.grid.RowNumberer(),
        {
            header:\'ID\',
            sortable:true,
            dataIndex:\'user_id\',
            width: 80,
            renderer: function (val, metaData, record) {
                return \'<a href="./?action_user_Detail=1&user_id=\' + val + \'" target=_blank>\' + val + \'<\\/a>\';
            }
        },
        {
            header:\'初入金日時\',
            sortable:true,
            dataIndex:\'first_pay_datetime\',
            width: 150
        },
        {
            header:\'会員仮登録日\',
            sortable:true,
            dataIndex:\'pre_regist_datetime\',
            width: 150
        },
        {
            header:\'会員登録日\',
            sortable:true,
            dataIndex:\'regist_datetime\',
            width: 150
        },
        {
            header:\'広告コード\',
            sortable:false,
            dataIndex:\'media_cd\',
            width: 100,
            sortable:true
        },
        {
            header:\'合計購入金額\',
            sortable:true,
            dataIndex:\'total_payment\',
            width: 100,
            renderer: Ext.util.Format.numberRenderer(\'0,000\')
        },
        {
            header:\'購入回数\',
            sortable:true,
            dataIndex:\'buy_count\',
            width: 80
        },
        {
            header:\'PCデバイス\',
            sortable:true,
            dataIndex:\'pc_device\',
            width: 80
        },
        {
            header:\'MBデバイス\',
            sortable:true,
            dataIndex:\'mb_device\',
            width: 80
        },
        {
            header:\'ステータス\',
            sortable:true,
            dataIndex:\'regist_status\',
            width: 80
        }
    ]});

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
        title:\'初入金者一覧(日毎)\',
        height:800,
        width:1100,
        cm:column,
        frame:true,
        store:store,
        stripeRows: true,
        columnLines: true,
        loadMask: true
    });
'; ?>


// -->
</script>

<div id="grid"></div>