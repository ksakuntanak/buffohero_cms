<?php if ($jobs): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th style="width:20%;">ชื่อตำแหน่งงาน</th>
                <th style="width:20%;">ผู้ว่าจ้าง</th>
                <th style="width:10%;">ประเภทงาน</th>
                <th style="width:20%;">หมวดหมู่</th>
                <th style="width:10%;">สถานะ</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jobs['rows'] as $item): ?>
                <tr>
                    <td><?php echo $item['id']; ?></td>
                    <td><?php echo $item['job_title']; ?></td>
                    <td><?php echo $item['employer_name']; ?></td>
                    <td><?php
                        if($item['job_type'] == "fulltime") echo "Full-time";
                        else if($item['job_type'] == "project") echo "Project / Campaign";
                        else if($item['job_type'] == "contest") echo "Contest";
                    ?></td>
                    <td><?php echo $cats[$item['cat_id']]; ?></td>
                    <td>
                        <?php if($item['job_is_active'] == 2){ ?>
                            <i class="fa fa-check-circle color-green"> </i> เผยแพร่
                        <?php } else if($item['job_is_active'] == 1){ ?>
                            <i class="fa fa-circle color-orange"> </i> รอการตรวจสอบ
                        <?php } else if($item['job_is_active'] == 0) { ?>
                            <i class="fa fa-ban color-red"> </i> ระงับ
                        <?php } ?></td>
                    <td>
                        <?php echo Html::anchor('job/edit/' . $item['id'], '<i class="fa fa-wrench"></i> แก้ไขข้อมูล'); ?>&nbsp;&nbsp;						
                        <?php echo Html::anchor('job/delete/' . $item['id'], '<i class="fa fa-trash-o"></i> ลบข้อมูล', array('onclick' => "return confirm('Job #".$item['id']." will be deleted. Continue?')")); ?>
                    </td>
                </tr>
            <?php endforeach; ?>	
        </tbody>
    </table>

<?php else: ?>
    <p>ยังไม่มีตำแหน่งงานในระบบ</p>
<?php endif; ?>
<div class="clearfix">
<?php echo html_entity_decode($pagination); ?>
</div>
<?php echo Html::anchor('job/create', '<i class="fa fa-plus"></i> เพิ่มตำแหน่งงานใหม่', array('class' => 'btn btn-success')); ?>
<script type="text/javascript">

    var page = <?php echo $page; ?>;
    var totalPage = <?php echo $total_page; ?>;

    function toPage(next){
        window.location.href = "<?php echo Uri::create('job'); ?>/?page="+next;
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

