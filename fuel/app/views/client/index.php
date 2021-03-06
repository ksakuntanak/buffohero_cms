<?php if ($clients): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Logo</th>
                <th>ชื่อลูกค้า</th>
                <th>วันที่เพิ่ม</th>
                <th>สถานะ</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clients as $item): ?>
                <tr>
                    <td><?php echo $item['id']; ?></td>
                    <td>
                        <div style="width:165px;height:64px;overflow:hidden;">
                            <img src="<?php echo $path.$item['client_photo']; ?>" style="width:165px;" />
                        </div>
                    </td>
                    <td><?php echo $item['client_title']; ?></td>
                    <td><?php echo date('Y-m-d H:i:s',$item['created_at']); ?></td>
                    <td><?php echo $item['client_active']?"<i class=\"fa fa-check-circle color-green\"> </i> ปกติ":"<i class=\"fa fa-ban color-red\"> </i> ระงับ"; ?></td>
                    <td>
                        <?php echo Html::anchor('client/edit/' . $item['id'], '<i class="fa fa-wrench"></i> แก้ไขข้อมูล'); ?>&nbsp;&nbsp;						
                        <?php echo Html::anchor('client/delete/' . $item['id'], '<i class="fa fa-trash-o"></i> ลบข้อมูล', array('onclick' => "return confirm('Client #".$item['id']." will be deleted. Continue?')")); ?>
                    </td>
                </tr>
            <?php endforeach; ?>	
        </tbody>
    </table>

<?php else: ?>
    <p>ยังไม่มีลูกค้าในระบบ</p>
<?php endif; ?>
<div class="clearfix">
<?php echo html_entity_decode($pagination); ?>
</div>
<?php echo Html::anchor('client/create', '<i class="fa fa-plus"></i> เพิ่มลูกค้าใหม่', array('class' => 'btn btn-success')); ?>
<script type="text/javascript">

    var page = <?php echo $page; ?>;
    var totalPage = <?php echo $total_page; ?>;

    function toPage(next){
        window.location.href = "<?php echo Uri::create('client'); ?>/?page="+next;
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

