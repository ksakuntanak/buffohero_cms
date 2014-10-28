<?php if ($contacts): ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>E-Mail</th>
            <th>หัวข้อ</th>
            <th>วันที่ส่ง</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($contacts as $item): ?>
            <tr>
                <td><?php echo $item['id']; ?></td>
                <td><?php echo $item['email']; ?></td>
                <td><?php echo $item['subject']; ?></td>
                <td><?php echo date('Y-m-d H:i:s',$item['created_at']); ?></td>
                <td>
                    <?php echo Html::anchor('contact/view/' . $item['id'], '<i class="fa fa-eye"></i> ดูข้อความ'); ?>&nbsp;&nbsp;
                    <?php echo Html::anchor('contact/delete/' . $item['id'], '<i class="fa fa-trash-o"></i> ลบข้อความ', array('onclick' => "return confirm('ข้อความ #".$item['id']." จะถูกลบออกจากระบบ ดำเนินการต่อ?')")); ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php else: ?>
    <p>ยังไม่มีข้อความติดต่อเราในระบบ</p>
<?php endif; ?>
<div class="clearfix">
    <?php echo html_entity_decode($pagination); ?>
</div>
<script type="text/javascript">

    var page = <?php echo $page; ?>;
    var totalPage = <?php echo $total_page; ?>;

    function toPage(next){
        window.location.href = "<?php echo Uri::create('contact'); ?>/?page="+next;
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