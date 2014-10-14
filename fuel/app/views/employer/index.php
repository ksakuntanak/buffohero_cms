<?php try { ?>
<?php if($employers['total']){ ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>ชื่อผู้จ้างงาน</th>
            <th>เข้าระบบล่าสุด</th>
            <th>สถานะ</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($employers['rows'] as $item): ?>
            <tr>
                <td><?php echo $item['id']; ?></td>
                <td>
                    <?php if($item['fb_login']){ ?>
                        <i class="fa fa-facebook-square"></i>
                    <?php } else { ?>
                        <i class="fa fa-envelope-o"></i>
                    <?php } ?>
                    <?php echo $item['username']; ?>
                </td>
                <td><?php echo $item['employer_name']; ?></td>
                <td><?php echo date('M d, Y H:i:s',$item['last_login']); ?></td>
                <td><?php echo $item['employer_is_active']?"ปกติ":"ระงับ"; ?></td>
                <td>
                    <?php echo Html::anchor('employer/edit/'.$item['id'],'<i class="fa fa-pencil"></i> แก้ไขข้อมูล'); ?>&nbsp;&nbsp;
                    <?php echo Html::anchor('employer/delete/'. $item['id'],'<i class="fa fa-trash-o"></i> ลบผู้ใช้งาน', array('onclick' => "return confirm('ข้อมูลอื่นๆ เกี่ยวกับผู้จ้างงานคนนี้จะถูกลบทิ้งด้วย ดำเนินการต่อ?')")); ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php } else { ?>
    <p>ยังไม่มีผู้ใช้งานประเภทผู้จ้างงานในระบบ</p>
<?php } ?>
<div class="clearfix">
    <?php echo html_entity_decode($pagination); ?>
</div>
<script type="text/javascript">

    var page = <?php echo $page; ?>;
    var totalPage = <?php echo $total_page; ?>;

    function toPage(next){
        window.location.href = "<?php echo Uri::create('employer'); ?>/?page="+next;
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
<?php } catch(Exception $e) {
    die($e->getMessage());
} ?>