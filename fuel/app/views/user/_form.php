<div class="body">
    <?php echo Form::open(array("class" => "form-horizontal")); ?>
    <?php echo Form::hidden('profile_fields', Input::post('profile_fields', isset($user) ? $user->profile_fields : '')); ?>
    <?php echo Form::hidden('last_login', Input::post('last_login', isset($user) ? $user->last_login : '')); ?>
    <?php echo Form::hidden('login_hash', Input::post('login_hash', isset($user) ? $user->login_hash : '')); ?>
    <?php echo Form::hidden('group', Input::post('group', 100)); ?>
    <?php echo Form::fieldset_open(); ?>
    <div class="form-group">
        <?php echo Form::label('Username <span class="required">*</span>', 'username', array('class' => 'control-label')); ?>
        <div class="controls form-group">
            <?php echo Form::input('username', Input::post('username', isset($user) ? $user->username : ''), array('class' => 'form-control', 'placeholder' => 'ระบุ Username')); ?>
            <span class="help-block">ความยาว 8 - 20 ตัวอักษร</span>
        </div>
    </div>
    <div class="form-group">
        <?php echo Form::label('Password'.($menu=="create"?'<span class="required">*</span>':''), 'password', array('class' => 'control-label')); ?>
        <div class="controls form-group">
            <?php echo Form::input('password', Input::post('password', ''), array('class' => 'form-control', 'placeholder' => 'ระบุ Password', 'type' => 'password')); ?>
            <?php if($menu == "edit") { ?><span class="help-block">ถ้าต้องการเปลี่ยน Password ให้กรอกช่องนี้</span><?php } ?>
            <span class="help-block">ความยาว 8 - 20 ตัวอักษร</span>
        </div>
    </div>
    <div class="form-group">
        <?php echo Form::label('Re-type Password'.($menu=="create"?'<span class="required">*</span>':''), 'password_re', array('class' => 'control-label')); ?>
        <div class="controls form-group">
            <?php echo Form::input('password_re', Input::post('password_re', ''), array('class' => 'form-control', 'placeholder' => 'ระบุ Password อีกครั้ง', 'type' => 'password')); ?>
            <span class="help-block">กรอก Password เดียวกันกับช่องข้างบน</span>
        </div>
    </div>
    <div class="form-group">
        <?php echo Form::label('E-Mail <span class="required">*</span>', 'email', array('class' => 'control-label')); ?>
        <div class="controls form-group">
            <?php echo Form::input('email', Input::post('email', isset($user) ? $user->email : ''), array('class' => 'form-control', 'placeholder' => 'E-Mail')); ?>
        </div>
    </div>
    <div class="form-actions">
        <?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-success')); ?>
        <?php echo Form::button('clear', 'Cancel', array('class' => 'btn btn-default')); ?>
    </div>
    <?php echo Form::fieldset_close(); ?></fieldset>
    <?php echo Form::close(); ?>
</div>