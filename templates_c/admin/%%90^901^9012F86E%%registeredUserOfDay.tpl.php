<?php /* Smarty version 2.6.26, created on 2014-10-25 05:37:04
         compiled from /home/suraimu/templates/admin/senchaCount/registeredUserOfDay.tpl */ ?>
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
            {name:\'user_id\'},
            {name:\'pre_regist_datetime\'},
            {name:\'regist_datetime\'},
            {name:\'media_cd\'},
            {name:\'pc_ip_address\'},
            {name:\'mb_ip_address\'},
            {name:\'mb_serial_number\'},
            {name:\'pc_device\'},
            {name:\'mb_device\'},
            {name:\'regist_status\'}
        ],
        sortInfo: {field:\'user_id\', direction:\'ASC\'},
        remoteSort: true,
        autoLoad: {params: {start: 0, limit: 30}}
    });

    var column = new Ext.grid.ColumnModel([
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
            width: 100
        },
        {
            header:\'PCIPアドレス\',
            sortable:false,
            dataIndex:\'pc_ip_address\',
            width: 100,
            sortable:true
        },
        {
            header:\'MBIPアドレス\',
            sortable:false,
            dataIndex:\'mb_ip_address\',
            width: 100
        },
        {
            header:\'固体識別番号\',
            sortable:false,
            dataIndex:\'mb_serial_number\',
            width: 200
        },
        {
            header:\'PCデバイス\',
            sortable:false,
            dataIndex:\'pc_device\',
            width: 80
        },
        {
            header:\'MBデバイス\',
            sortable:false,
            dataIndex:\'mb_device\',
            width: 80
        },
        {
            header:\'ステータス\',
            sortable:false,
            dataIndex:\'regist_status\',
            width: 80
        }
    ]);

    var bbar = new Ext.PagingToolbar({
        store:store,
        pageSize:30,
        displayInfo: true,
        displayMsg: \'{2}件中、{0}～{1}件目表示中\',
        emptyMsg: \'データなし\',
        plugins: new Ext.ux.SlidingPager()
    });

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
        title:\'ユーザー登録数(日毎)\',
        height:800,
        width:1200,
        cm:column,
        frame:true,
        store:store,
        stripeRows: true,
        columnLines: true,
        loadMask: true,
        bbar:bbar
    });
'; ?>


// -->
</script>

<div id="grid"></div>