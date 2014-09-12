<?php if($employees['total']){ ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>วันที่</th>
            <th>ชื่อ - สกุล</th>
            <th>สถานะ</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($employees['rows'] as $item): ?>
            <tr>
                <td><?php echo $item['pick_date']; ?></td>
                <td><?php echo $item['employee_display_name']; ?></td>
                <td><?php echo $item['pick_is_active']?"เผยแพร่":"ระงับ"; ?></td>
                <td>
                    <?php echo Html::anchor('employee/view/' . $item['employee_id'], '<i class="fa fa-eye"></i> ดูข้อมูล'); ?>&nbsp;&nbsp;
                    <?php echo Html::anchor('employee/deleteStaffPick/' . $item['id'], '<i class="fa fa-trash-o"></i> ลบ Staff Pick', array('onclick' => "return confirm('Staff Pick นี้จะถูกลบทิ้ง ดำเนินการต่อ?')")); ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php } else { ?>
    <p>ยังไม่มีผู้หางานที่เป็น Staff Pick ในระบบ</p>
<?php } ?>
<div class="clearfix">
    <?php echo html_entity_decode($pagination); ?>
</div>
<script type="text/javascript">

    var page = <?php echo $page; ?>;
    var totalPage = <?php echo $total_page; ?>;

    function toPage(next){
        window.location.href = "<?php echo Uri::create('employee/staffPicks'); ?>/?page="+next;
    }

    function firstPage(){
        toPage(1);
    }

    function prevPage(){
        var next = page - 1;
        if(next < 1) next = 1;
        toPage(next);
    }

    function nextPage(){
        var next = page + 1;
        if(next > totalPage) next = totalPage;
        toPage(next);
    }

    function lastPage(){
        toPage(totalPage);
    }

</script>