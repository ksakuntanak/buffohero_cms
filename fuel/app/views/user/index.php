<?php if ($users): ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>E-Mail</th>
            <th>กลุ่มผู้ใช้งาน</th>
            <th>เข้าสู่ระบบครั้งสุดท้ายเมื่อ</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $item): ?>
            <tr>
                <td><?php echo $item['id']; ?></td>
                <td><?php echo $item['username']; ?></td>
                <td><?php echo $item['email']; ?></td>
                <td><?php echo $groups[$item['group']]; ?></td>
                <td><?php echo date('Y-m-d H:i:s',$item['last_login']?$item['last_login']:0); ?></td>
                <td>
                    <?php echo Html::anchor('user/edit/' . $item['id'], '<i class="fa fa-wrench"></i> แก้ไขข้อมูล'); ?>&nbsp;&nbsp;
                    <?php echo Html::anchor('user/delete/' . $item['id'], '<i class="fa fa-trash-o"></i> ลบข้อมูล', array('onclick' => "return confirm('Job #".$item['id']." will be deleted. Continue?')")); ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php else: ?>
    <p>ยังไม่มีผู้ใช้งาน CMS ในระบบ</p>
<?php endif; ?>
<div class="clearfix">
    <?php echo html_entity_decode($pagination); ?>
</div>
<?php echo Html::anchor('user/create', '<i class="fa eicon-user-add"></i> เพิ่มผู้ใช้งาน CMS ใหม่', array('class' => 'btn btn-success')); ?>
<script type="text/javascript">

    var page = <?php echo $page; ?>;
    var totalPage = <?php echo $total_page; ?>;

    function toPage(next){
        window.location.href = "<?php echo Uri::create('user'); ?>/?page="+next;
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

