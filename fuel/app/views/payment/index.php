<h3>รายการชำระเงินที่กำลังดำเนินการอยู่</h3>
<?php if (count($active_payments)){ ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Ref.No.</th>
            <th style="width:20%;">ชื่อผู้ว่าจ้าง</th>
            <th style="width:20%;">จำนวนบัฟที่ซื้อ</th>
            <th style="width:20%;">สถานะ</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($active_payments as $item){ ?>
            <tr>
                <td><?php echo $item['ref_no']; ?></td>
                <td><?php echo $item['employer_name']; ?></td>
                <td><?php echo $item['buff_amount']; ?></td>
                <td><?php
                    if($item['status'] == 1) echo '<i class="fa fa-circle-o" style="color:#FC0;"></i> รอหลักฐานการชำระเงิน';
                    else if($item['status'] == 2) echo '<i class="fa fa-circle-o" style="color:#FC0;"></i> รอตรวจสอบการชำระเงิน';
                    ?></td>
                <td>
                    <?php echo Html::anchor('payment/view/' . $item['id'], '<i class="fa fa-eye"></i> ดูรายละเอียด'); ?>&nbsp;&nbsp;
                    <?php echo Html::anchor('payment/delete/' . $item['id'], '<i class="fa fa-trash-o"></i> ลบรายการ', array('onclick' => "return confirm('รายการ #".$item['id']." จะถูกลบ ต้องการทำต่อ?')")); ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <div style="text-align:center;">
        <a class="btn btn-info" href="<?php echo Uri::create('payment/active/'); ?>">ดูรายการชำระเงินที่อยู่ระหว่างการดำเนินการทั้งหมด</a>
    </div>
<?php } else { ?>
    <p>ยังไม่มีรายการชำระเงินที่อยู่ระหว่างการดำเนินการในระบบ</p>
<?php } ?>
<h3>รายการชำระเงินที่ดำเนินการเสร็จแล้ว</h3>
<?php if (count($closed_payments)){ ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Ref.No.</th>
            <th style="width:20%;">ชื่อผู้ว่าจ้าง</th>
            <th style="width:20%;">จำนวนบัฟที่ซื้อ</th>
            <th style="width:20%;">สถานะ</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($closed_payments as $item){ ?>
            <tr>
                <td><?php echo $item['ref_no']; ?></td>
                <td><?php echo $item['employer_name']; ?></td>
                <td><?php echo $item['buff_amount']; ?></td>
                <td><?php
                    if($item['status'] == 0) echo '<i class="fa fa-minus-circle" style="color:#C30;"></i> ยกเลิก';
                    else if($item['status'] == 3) echo '<i class="fa fa-check-circle" style="color:#4cae4c;"></i> เสร็จสิ้น';
                    ?></td>
                <td>
                    <?php echo Html::anchor('payment/view/' . $item['id'], '<i class="fa fa-eye"></i> ดูรายละเอียด'); ?>&nbsp;&nbsp;
                    <?php echo Html::anchor('payment/delete/' . $item['id'], '<i class="fa fa-trash-o"></i> ลบรายการ', array('onclick' => "return confirm('รายการ #".$item['id']." จะถูกลบ ต้องการทำต่อ?')")); ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <div style="text-align:center;">
        <a class="btn btn-info" href="<?php echo Uri::create('payment/closed/'); ?>">ดูรายการชำระเงินที่ดำเนินการเสร็จแล้วทั้งหมด</a>
    </div>
<?php } else { ?>
    <p>ยังไม่มีรายการชำระเงินที่ดำเนินการเสร็จแล้วในระบบ</p>
<?php } ?>