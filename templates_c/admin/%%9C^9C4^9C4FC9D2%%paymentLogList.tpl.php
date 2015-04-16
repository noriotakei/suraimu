<?php /* Smarty version 2.6.26, created on 2014-08-08 17:21:21
         compiled from /home/suraimu/templates/admin/senchaCount/paymentLogList.tpl */ ?>
<?php echo '
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
        baseParams:'; ?>
<?php echo $this->_tpl_vars['jsonParam']; ?>
<?php echo ',
        fields:[
            {name:\'create_datetime\'},
            {name:\'ordering_create_datetime\'},
            {name:\'ordering_id\'},
            {name:\'item\'},
            {name:\'user_id\', type:\'int\'},
            {name:\'pay_type\'},
            {name:\'receive_money\', type:\'int\'},
            {name:\'is_cancel\'},
            {name:\'is_manual\'}
        ],
        autoLoad: true
    });

    var column = new Ext.grid.ColumnModel({
        defaults: {
             sortable: true,
             width: 100,
             align: \'right\'
         },
        columns: [{
            header:\'入金日時\',
            sortable:true,
            dataIndex:\'create_datetime\',
            width: 150
        },
        {
            header:\'注文日時\',
            sortable:true,
            dataIndex:\'ordering_create_datetime\',
            width: 150
        },
        {
            header:\'注文ID\',
            sortable:true,
            dataIndex:\'ordering_id\',
            width: 80,
            renderer: function (val, metaData, record) {
                var link;
                if (!isNaN(val) && val) {
                    link = \'<a href="./?action_ordering_OrderingData=1&ordering_id=\' + val + \'" target=_blank>\' + val + \'<\\/a>\'
                } else {
                    link = val;
                }
                return link;
            }
        },
        {
            header:\'商品\',
            sortable:false,
            dataIndex:\'item\',
            align: \'left\',
            width:300
        },
        {
            header:\'金額\',
            sortable:true,
            dataIndex:\'receive_money\',
            width: 100,
            renderer: Ext.util.Format.numberRenderer(\'0,000\')
        },
        {
            header:\'ユーザーID\',
            sortable:true,
            dataIndex:\'user_id\',
            width: 100,
            sortable:true,
            renderer: function (val, metaData, record) {
                if (!isNaN(val) && val) {
                    return \'<a href="./?action_user_Detail=1&user_id=\' + val + \'" target=_blank>\' + val + \'<\\/a>\';
                } else {
                    return \'\';
                }
            }
        },
        {
            header:\'支払い種別\',
            sortable:true,
            dataIndex:\'pay_type\',
            width: 100
        },
        {
            header:\'キャンセル\',
            sortable:true,
            dataIndex:\'is_cancel\',
            width: 80,
            renderer: function (val, metaData, record) {
                return (val ? \'キャンセル\' : \'\');
            }
        },
        {
            header:\'処理方法\',
            sortable:true,
            dataIndex:\'is_manual\',
            width: 80,
            renderer: function (val, metaData, record) {
                if (!isNaN(val) && val !== \'\') {
                    return (val  ? \'手動\' : \'自動\');
                } else {
                    return \'\';
                }
            }
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
        title:\'入金ログリスト\',
        height:800,
        width:1200,
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