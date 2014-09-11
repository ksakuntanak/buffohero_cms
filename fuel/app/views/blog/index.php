<?php if ($blogs): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>หัวข้อบล็อก</th>
                <th>วันที่เขียน</th>
                <th>วันที่เผยแพร่</th>
                <th>สถานะ</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($blogs as $item): ?>		
                <tr>
                    <td><?php echo $item['id']; ?></td>
                    <td><?php echo $item['blog_title']; ?></td>
                    <td><?php echo date('Y-m-d H:i:s',$item['created_at']); ?></td>
                    <td><?php echo date('Y-m-d H:i:s',$item['published_at']); ?></td>
                    <td><?php echo $item['blog_published']?"<i class=\"fa fa-check-circle color-green\"> </i> เผยแพร่":"<i class=\"fa fa-ban color-red\"> </i> ระงับ"; ?></td>
                    <td>
                        <?php echo Html::anchor('blog/edit/' . $item['id'], '<i class="fa fa-wrench"></i> แก้ไขข้อมูล'); ?>&nbsp;&nbsp;						
                        <?php echo Html::anchor('blog/delete/' . $item['id'], '<i class="fa fa-trash-o"></i> ลบข้อมูล', array('onclick' => "return confirm('Job #".$item['id']." will be deleted. Continue?')")); ?>
                    </td>
                </tr>
            <?php endforeach; ?>	
        </tbody>
    </table>

<?php else: ?>
    <p>ยังไม่มีบล็อกในระบบ</p>
<?php endif; ?>
<div class="clearfix">
<?php echo html_entity_decode($pagination); ?>
</div>
<?php echo Html::anchor('blog/create', '<i class="fa fa-plus"></i> เพิ่มบล็อกใหม่', array('class' => 'btn btn-success')); ?>
<script type="text/javascript">

    var page = <?php echo $page; ?>;
    var totalPage = <?php echo $total_page; ?>;

    function toPage(next){
        window.location.href = "<?php echo Uri::create('blog'); ?>/?page="+next;
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

