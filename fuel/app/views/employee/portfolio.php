<?php if(count($portfolios)){ ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>รูปภาพ</th>
            <th>ชื่อภาพ</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($portfolios as $item): ?>
            <tr>
                <td><?php echo $item['id']; ?></td>
                <td>
                    <div style="width:120px;height:120px;overflow:hidden;">
                        <img src="//buffohero.com/uploads/portfolio/<?php echo $item['port_photo']; ?>" style="width:120px;">
                    </div>
                </td>
                <td><?php echo $item['port_title']; ?></td>
                <td>
                    <?php //echo Html::anchor('employee/editPortfolio/' . $item['id'], '<i class="fa fa-pencil"></i> แก้ไขชื่อภาพ'); ?>
                    <?php echo Html::anchor('employee/deletePortfolio/' . $item['id'], '<i class="fa fa-trash-o"></i> ลบรูปภาพ', array('onclick' => "return confirm('รูปภาพนี้จะถูกลบ ดำเนินการต่อ?')")); ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php } else { ?>
    <p>ยังไม่มีรูปภาพใน Portfolio</p>
<?php } ?>