<section class="widget">
    <legend class="section">ข้อมูลบัญชีผู้ใช้งาน</legend>
    <div class="body">
        <table class="table">
            <tr>
                <td>Username</td>
                <td>
                    <?php if($employee['fb_login']){ ?>
                        <i class="fa fa-facebook-square"></i>
                    <?php } else { ?>
                        <i class="fa fa-envelope-o"></i>
                    <?php } ?>
                    <?php echo $employee['username']; ?>
                </td>
            </tr>
            <tr>
                <td>เข้าสู่ระบบล่าสุดเมื่อ</td>
                <td><?php echo date('M d, Y H:i:s',$employee['last_login']); ?></td>
            </tr>
        </table>
    </div>
</section>
<section class="widget">
    <legend class="section">ข้อมูลการแสดงผล</legend>
    <div class="body">
        <table class="table">
            <tr>
                <td>สถานะผู้หางาน</td>
                <td><?php echo $employee['custom']['working_status']?"ทำงานแล้ว":"กำลังหางาน"; ?></td>
            </tr>
            <tr>
                <td>เผยแพร่เรซูเม่อยู่?</td>
                <td><?php echo $employee['custom']['resume_published']?"ใช่":"ไม่ใช่"; ?></td>
            </tr>
            <tr>
                <td>เผยแพร่แฟ้มผลงานอยู่?</td>
                <td><?php echo $employee['custom']['portfolio_published']?"ใช่":"ไม่ใช่"; ?></td>
            </tr>
        </table>
    </div>
</section>
<section class="widget">
    <legend class="section">ข้อมูลส่วนตัว</legend>
    <div class="body">
        <table class="table">
            <tr>
                <td>ชื่อที่แสดงในระบบ</td>
                <td><?php echo $employee['employee_display_name']; ?></td>
            </tr>
            <tr>
                <td>ชื่อ</td>
                <td><?php echo $employee['employee_firstname']; ?></td>
            </tr>
            <tr>
                <td>สกุล</td>
                <td><?php echo $employee['employee_lastname']; ?></td>
            </tr>
            <tr>
                <td>ชื่อเล่น</td>
                <td><?php echo $employee['employee_nickname']; ?></td>
            </tr>
            <tr>
                <td>ตำแหน่งงานปัจจุบัน / ตำแหน่งที่ต้องการ</td>
                <td><?php echo $employee['employee_display_position']; ?></td>
            </tr>
            <tr>
                <td>ประเภทงานที่สนใจ</td>
                <td><?php
                    if($employee['employee_prefer'] == "fulltime") echo "งานประจำ";
                    else if($employee['employee_prefer'] == "freelance") echo "ฟรีแลนซ์";
                    ?></td>
            </tr>
            <tr>
                <td>เพศ</td>
                <td><?php
                    if($employee['employee_gender'] == "m") echo "ชาย";
                    else if($employee['employee_gender'] == "f") echo "หญิง";
                    ?></td>
            </tr>
            <tr>
                <td>วันเดือนปีเกิด</td>
                <td><?php
                    $bdate = strtotime($employee['employee_bdate']);
                    echo date('M d, Y',$bdate);
                    ?></td>
            </tr>
            <tr>
                <td>น้ำหนัก (kg)</td>
                <td><?php echo $employee['employee_weight']; ?></td>
            </tr>
            <tr>
                <td>ส่วนสูง (cm)</td>
                <td><?php echo $employee['employee_height']; ?></td>
            </tr>
            <tr>
                <td>ที่อยู่</td>
                <td><?php echo $employee['employee_addr']; ?></td>
            </tr>
            <tr>
                <td>จังหวัด</td>
                <td><?php echo $provinces[$employee['province_id']]; ?></td>
            </tr>
            <tr>
                <td>รหัสไปรษณีย์</td>
                <td><?php echo $employee['employee_zipcode']; ?></td>
            </tr>
            <tr>
                <td>ประเทศ</td>
                <td><?php echo $employee['employee_country']; ?></td>
            </tr>
            <tr>
                <td>หมายเลขโทรศัพท์</td>
                <td><?php echo $employee['employee_phone']; ?></td>
            </tr>
            <tr>
                <td>อีเมล</td>
                <td><?php echo $employee['employee_email']; ?></td>
            </tr>
        </table>
    </div>
</section>
<?php if(strlen($employee['employee_about'])) { ?>
<section class="widget">
    <legend class="section">เกี่ยวกับผู้หางาน</legend>
    <div class="body">
        <?php echo html_entity_decode($employee['employee_about']); ?>
    </div>
</section>
<?php } ?>
<?php if(count($employee['expect'])) { ?>
    <section class="widget">
        <legend class="section">ตำแหน่งงานที่ต้องการ</legend>
        <div class="body">
            <table class="table">
                <thead>
                <tr>
                    <th>ตำแหน่ง</th>
                    <th>เงินเดือนที่คาดหวัง</th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach($employee['expect'] as $e){ ?>
                        <tr>
                            <td><?php echo $e['expect_position']; ?></td>
                            <td><?php echo number_format($e['expect_salary'],0); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
<?php } ?>
<?php if(count($employee['experience'])) { ?>
    <section class="widget">
        <legend class="section">ประวัติการทำงาน</legend>
        <div class="body">
            <table class="table">
                <tbody>
                <?php foreach($employee['experience'] as $e){ ?>
                    <tr>
                        <td>
                            <strong><?php echo $e['exp_company']; ?></strong><br/>
                            <?php echo $e['exp_position']; ?>
                        </td>
                        <td class="right">
                            <?php echo $e['exp_start_year']?$e['exp_start_year']:""; ?>
                            <?php if($e['exp_start_year']){ ?>-<?php } ?>
                            <?php echo $e['exp_end_year']?$e['exp_end_year']:"ปัจจุบัน"; ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
<?php } ?>
<?php if(count($employee['school'])) { ?>
    <section class="widget">
        <legend class="section">ประวัติการศึกษา</legend>
        <div class="body">
            <table class="table">
                <tbody>
                <?php foreach($employee['school'] as $s){ ?>
                    <tr>
                        <td>
                            <strong><?php echo $s['school_name']; ?></strong><br/>
                            <?php echo $s['school_degree']; ?>
                        </td>
                        <td class="right">
                            <?php echo $s['school_start_year']?$s['school_start_year']:""; ?>
                            <?php if($s['school_start_year']){ ?>-<?php } ?>
                            <?php echo $s['school_end_year']?$s['school_end_year']:"ปัจจุบัน"; ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
<?php } ?>
<?php if(count($employee['comp_skills']) || count($employee['lang_skills']) || count($employee['other_skills'])) { ?>
<section class="widget">
    <legend class="section">ทักษะ</legend>
    <div class="body">
        <?php if(count($employee['comp_skills'])) { ?>
            <h4>ทักษะคอมพิวเตอร์</h4>
            <table class="table">
                <tbody>
                <?php foreach($employee['comp_skills'] as $s){ ?>
                    <tr>
                        <td>
                            <?php echo $s['skill_title']; ?>
                        </td>
                        <td class="right">
                            <?php echo $s['skill_level']; ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } ?>
        <?php if(count($employee['lang_skills'])) { ?>
            <h4>ทักษะภาษา</h4>
            <table class="table">
                <tbody>
                <?php foreach($employee['lang_skills'] as $s){ ?>
                    <tr>
                        <td>
                            <?php echo $s['skill_title']; ?>
                        </td>
                        <td class="right">
                            <?php echo $s['skill_level']; ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } ?>
        <?php if(count($employee['other_skills'])) { ?>
            <h4>ทักษะอื่นๆ</h4>
            <table class="table">
                <tbody>
                <?php foreach($employee['other_skills'] as $s){ ?>
                    <tr>
                        <td>
                            <?php echo $s['skill_title']; ?>
                        </td>
                        <td class="right">
                            <?php echo $s['skill_level']; ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</section>
<?php } ?>
<section class="widget">
    <a class="btn btn-default" href="<?php echo Uri::create('employee'); ?>">ย้อนกลับ</a>
    <div class="pull-right">
        <a class="btn btn-success" href="<?php echo Uri::create('employee/addStaffPick/'.$employee['id']); ?>">เพิ่มใน Staff Pick</a>
        <a class="btn btn-danger" href="<?php echo Uri::create('employee/delete/'.$employee['id']); ?>">ลบผู้ใช้งาน</a>
    </div>
</section>
<script type="text/javascript">



</script>