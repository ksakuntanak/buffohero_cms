<section class="widget">
    <legend class="section">ข้อมูลบัญชีผู้ใช้งาน</legend>
    <div class="body">
        <table class="table">
            <tr>
                <td>E-Mail</td>
                <td><?php echo $contact->email; ?></td>
            </tr>
            <tr>
                <td>หัวข้อ</td>
                <td><?php echo $contact->subject; ?></td>
            </tr>
            <tr>
                <td>ข้อความ</td>
                <td><?php echo $contact->message; ?></td>
            </tr>
            <tr>
                <td>ส่งข้อความเมื่อ</td>
                <td><?php echo date('B d, Y H:i:s',$contact->created_at); ?></td>
            </tr>
        </table>
    </div>
</section>
<section class="widget">
    <a class="btn btn-default" href="<?php echo Uri::create('contact'); ?>">ย้อนกลับ</a>
    <div class="pull-right">
        <a class="btn btn-info" href="mailto:<?php echo $contact->email; ?>">ตอบกลับข้อความนี้ทาง E-Mail</a>
        <a class="btn btn-danger" href="<?php echo Uri::create('contact/delete/'.$contact->id); ?>">ลบผู้ใช้งาน</a>
    </div>
</section>