<!--section class="widget">
    <form id="search-form" class="navbar-form" role="search" onsubmit="return false;">
        <input name="query" type="search" class="search-query" placeholder="ค้นหาจากชื่อ" value="<?php echo $query; ?>">
    </form>
</section-->
<?php if ($employers): ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>ชื่อบริษัทผู้ว่าจ้าง</th>
            <th>เข้าระบบล่าสุด</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($employers as $item): ?>
            <tr>
                <td><?php echo $item['id']; ?></td>
                <td><?php echo $item['username']; ?></td>
                <td><?php echo $item['employer_name']; ?></td>
                <td><?php echo date('Y-m-d H:i:s',$item['last_login']?$item['last_login']:null); ?></td>
                <td>
                    <?php //echo Html::anchor('employer/view/' . $item['id'], '<i class="fa fa-eye"></i> View'); ?>&nbsp;&nbsp;
                    <?php echo Html::anchor('employer/edit/' . $item['id'], '<i class="fa fa-wrench"></i> แก้ไขข้อมูล'); ?>&nbsp;&nbsp;
                    <?php echo Html::anchor('employer/delete/' . $item['id'], '<i class="fa fa-trash-o"></i> ลบข้อมูล', array('onclick' => "return confirm('Job #".$item['id']." will be deleted. Continue?')")); ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php else: ?>
    <p>ยังไม่มีผู้ใช้งานประเภทผู้ว่าจ้างในระบบ</p>
<?php endif; ?>
<div class="clearfix">
    <?php echo html_entity_decode($pagination); ?>
</div>
<?php echo Html::anchor('employer/create', '<i class="fa eicon-user-add"></i> เพิ่มผู้ใช้งานประเภทผู้ว่าจ้างใหม่', array('class' => 'btn btn-success')); ?>