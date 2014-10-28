<?php

class Controller_Job extends Controller_Common {

    public function before() {
        parent::before();
        $this->theme = \Theme::instance();
    }

    public function action_index() {

        $page = Input::get('page')?Input::get('page'):1;
        $query = Input::get('query')?Input::get('query'):"";
        
        /*if (strlen($query)) {
            $data['jobs'] = DB::select('*')->from('jobs')
                ->where('job_title','LIKE','%'.$query.'%')
                ->order_by('created_at','desc')
                ->limit(30)->offset(($page-1)*30)
                ->execute()->as_array();
        } else {
            $data['jobs'] = DB::select('*')->from('jobs')
                ->order_by('created_at','desc')
                ->limit(30)->offset(($page-1)*30)
                ->execute()->as_array();
        }*/

        $data['jobs'] = Model_Job::get_jobs($page,$query);

        $total_rec = $data['jobs']['total'];

        $data['total_page'] = ceil($total_rec/30);
        $data['page'] = $page;

        $config = array(
            'pagination_url' => "",
            'total_items'    => $total_rec,
            'per_page'       => 30,
            'uri_segment'    => 2,
            'current_page'		 => $page
        );
        $pagination = Pagination::forge('pagenav',$config);
        $data['pagination'] = $pagination->render();

        $cats = Model_Category::get_categories();

        $this->theme->set_template('index');

        $this->theme->get_template()->set_global('current_menu', "Jobs", false);
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการตำแหน่งงานทั้งหมดในระบบ", false);

        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Jobs", 'icon' => "fa-briefcase", 'link' => "", 'active' => true)
        ));

        $this->theme->get_template()->set_global('query',$query,false);
        $this->theme->get_template()->set_global('cats',$cats,false);

        $this->theme->set_partial('sidebar','common/sidebar');

        $this->theme->set_partial('content', 'job/index')->set($data);

    }

    public function action_view($id = null) {

        is_null($id) and Response::redirect('job');

        if (!$data['job'] = Model_Job::find($id)) {
            Session::set_flash('error', 'Could not find job #' . $id);
            Response::redirect('job');
        }

        $this->template->title = "Job";
        $this->template->content = View::forge('job/view', $data);

    }

    public function action_create() {

        if (Input::method() == 'POST') {

            $val = Model_Job::validate('create');

            /*$val->add_field('employer_name', 'Employer Name', 'required|max_length[255]');
            $val->add_field('employer_tel', 'Employer Tel', 'required');
            $val->add_field('employer_email', 'Employer E-Mail', 'required|valid_email');*/

            if(Input::post('job_type') == "fulltime"){
                $val->add_field('job_title_fulltime', 'Job Title', 'required|max_length[255]');
                $val->add_field('job_salary', 'Salary', 'required|max_length[255]');
            } else if(Input::post('job_type') == "project"){
                $val->add_field('job_title_project', 'Job Title', 'required|max_length[255]');
                //$val->add_field('job_budget_type', 'Price offer', 'required');
                $val->add_field('job_budget', 'Budget', 'required|max_length[255]');
            } else if(Input::post('job_type') == "contest"){
                $val->add_field('job_title_contest', 'Job Title', 'required|max_length[255]');
                $val->add_field('job_prize', 'Prize', 'required|max_length[255]');
            }

            // $employer_id = 0;

            if ($val->run()) {

                $error = false;

                // $employer_photo = "";
                $job_attachment = "";

                /* upload employer logo */
                /*$file = Input::file('employer_photo_file');

                $allowList = array(".jpeg", ".jpg", ".png");

                $path = realpath(DOCROOT."/../../uploads/profile_photo/employer/").DS;

                if($file['size'] > 0){

                    $ext = strtolower(substr($file['name'],strrpos($file['name'],".")));

                    if(!in_array($ext,$allowList)){
                        Session::set_flash('error', 'ชนิดของไฟล์ภาพไม่ถูกต้อง');
                        $error = true;
                    }

                    $filename = md5(time()).$ext;

                    if(@copy($file['tmp_name'],$path.$filename)){
                        $employer_photo = $filename;
                    } else {
                        Session::set_flash('error', 'ไม่สามารถอัพโหลดไฟล์ภาพได้ โปรดลองใหม่อีกครั้ง');
                        $error = true;
                    }

                }*/
                /* */

                /* upload job attachment */
                $file = Input::file('job_attachment_file');

                $allowList = array(".pdf", ".doc");

                $path = realpath(DOCROOT."/../../uploads/job_attachment/").DS;

                if($file['size'] > 0){

                    $ext = strtolower(substr($file['name'],strrpos($file['name'],".")));

                    if(!in_array($ext,$allowList)){
                        Session::set_flash('error', 'ชนิดของไฟล์แนบไม่ถูกต้อง');
                        $error = true;
                    }

                    $filename = md5(time());

                    if(@copy($file['tmp_name'],$path.$filename."-o".$ext)){

                        $employer_photo = $filename.$ext;

                        /* retina */
                        parent::create_cropped_thumbnail($path.$filename."-o".$ext, 466, 360,"@2x");
                        /* */

                        /* normal */
                        parent::create_cropped_thumbnail($path.$filename."-o".$ext, 466, 360);
                        /* */

                    } else {
                        Session::set_flash('error', 'ไม่สามารถอัพโหลดไฟล์ภาพได้ โปรดลองใหม่อีกครั้ง');
                        $error = true;
                    }

                }
                /* */

                if(!$error){

                    /*$old_employer = DB::select('*')->from('employers')
                        ->where('employer_name','=',Input::post('employer_name'))
                        ->execute()->as_array();

                    if(count($old_employer)){

                        $employer_id = $old_employer[0]['id'];

                    } else {

                        $employer = Model_Employer::forge(array(
                            'user_id' => 0,
                            'province_id' => Input::post('province_id'),
                            'employer_name' => Input::post('employer_name'),
                            'employer_desc' => Input::post('employer_desc'),
                            'employer_addr' => Input::post('employer_addr'),
                            'employer_tel' => Input::post('employer_tel'),
                            'employer_fax' => Input::post('employer_fax'),
                            'employer_email' => Input::post('employer_email'),
                            'employer_website' => Input::post('employer_website'),
                            'employer_photo' => $employer_photo,
                            'created_at' => time()
                        ));

                        if($employer->save()){
                            $employer_id = $employer->id;
                        }

                    }*/

                    $config = array(
                        'employer_id' => Input::post('employer_id'),
                        'job_desc' => Input::post('job_desc'),
                        'job_type' => Input::post('job_type'),
                        'cat_id' => Input::post('cat_id'),
                        'subcat_id' => Input::post('subcat_id'),
                        'job_qualifications' => Input::post('job_qualifications'),
                        'job_skills' => Input::post('job_skills'),
                        'job_tags' => Input::post('job_tags'),
                        'job_attachment' => $job_attachment,
                        'job_is_featured' => Input::post('job_is_featured'),
                        'job_is_urgent' => Input::post('job_is_urgent'),
                        'job_is_active' => Input::post('job_is_active'),
                        'job_is_paid' => 1,
                        'created_at' => time(),
                        'expired_at' => time() + (30*24*60*60)
                    );

                    if(Input::post('job_type') == "fulltime"){
                        $config['job_title'] = Input::post('job_title_fulltime');
                        $config['job_areas'] = Input::post('job_areas');
                        $config['job_position'] = Input::post('job_position');
                        $config['job_welfare'] = Input::post('job_welfare');
                        $config['job_salary'] = Input::post('job_salary');
                    } else if(Input::post('job_type') == "project"){
                        $config['job_title'] = Input::post('job_title_project');
                        $config['job_budget_type'] = 'fixed';
                        $config['job_budget'] = Input::post('job_budget');
                    } else if(Input::post('job_type') == "contest"){
                        $config['job_title'] = Input::post('job_title_contest');
                        $config['job_prize'] = Input::post('job_prize');
                    }

                    $job = Model_Job::forge($config);

                    if ($job and $job->save()){

                        /* generate tags */
                        $title = $job->job_title;
                        $title_tags = parent::split_tags($title);

                        if($job->employer_id){
                            $employer = Model_Employer::find($job->employer_id);
                            $company_tags = parent::split_tags($employer->employer_name);
                        } else {
                            $company_tags = array();
                        }

                        $tags = array_merge($title_tags,$company_tags);

                        foreach($tags as $t){

                            $t = strtolower(trim($t));

                            if(!strlen($t) || $t == " ") continue;

                            $tag = Model_JobTag::get_tag($job->id,$t);

                            if(!$tag){

                                $tag = Model_JobTag::forge(array(
                                    'job_id' => $job->id,
                                    'tag_name' => $t,
                                    'created_at' => time()
                                ));

                                $tag->save();

                            }

                        }
                        /* */

                        /* generate ref. no. */
                        if(!strlen($job->ref_no)){
                            $job->job_tags = implode(",",Model_JobTag::get_tags_by_job($job->id));
                            $job->ref_no = "J".str_pad($job->id,7,"0",STR_PAD_LEFT);
                            $job->save();
                        }

                        $qualifications = explode(",",Input::post('job_qualifications'));

                        foreach($qualifications as $q){

                            if(!strlen(trim($q))) continue;

                            $qual = Model_JobQualification::get_qualification($job->id,trim($q));

                            if(!$qual){

                                $qual = Model_JobQualification::forge(array(
                                    'job_id' => $job->id,
                                    'qualification_title' => trim($q),
                                    'created_at' => time()
                                ));

                                $qual->save();

                            }

                        }

                        $skills = explode(",",Input::post('job_skills'));

                        foreach($skills as $s){

                            if(!strlen(trim($s))) continue;

                            $skill = Model_JobSkill::get_skill($job->id,trim($s));

                            if(!$skill){

                                $skill = Model_JobSkill::forge(array(
                                    'job_id' => $job->id,
                                    'skill_title' => trim($s),
                                    'created_at' => time()
                                ));

                                $skill->save();

                            }

                        }

                        Session::set_flash('success', 'Added job #' . $job->id . '.');
                        Response::redirect('job');

                    } else {
                        Session::set_flash('error', 'Could not save job.');
                    }

                }

            } else {
                $msg = '<ul>';
                foreach ($val->error() as $field => $error){
                    $msg .= '<li>'.$error->get_message().'</li>';
                }
                $msg .= '</ul>';
                Session::set_flash('error', $msg);
            }

        }
        $this->theme->set_template('edit');
        $this->theme->get_template()->set_global('current_menu', "Jobs", false);
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการตำแหน่งงานทั้งหมดในระบบ", false);

        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Jobs", 'icon' => "fa-briefcase", 'link' => Uri::create('job/index'), 'active' => false),
            array('title' => "Create", 'icon' => "", 'link' => "", 'active' => true)
        ));

        $this->theme->get_template()->set_global('cats', Model_Category::get_categories(), false);
        $this->theme->get_template()->set_global('subcats', json_encode(Model_Subcategory::get_all_subcats()), false);

        $this->theme->get_template()->set_global('current_subcats', array(), false);

        $this->theme->get_template()->set_global('provinces', Model_Province::get_provinces("th"), false);
        $this->theme->get_template()->set_global('employers', Model_Employer::get_employers_for_dropdown(), false);

        $this->theme->get_template()->set_global('page_specific_js', "form_job.js", false);

        $this->theme->set_partial('sidebar','common/sidebar');

        $this->theme->set_partial('left', 'job/create');

    }

    public function action_edit($id = null) {

        try {

        is_null($id) and Response::redirect('job');

        $this->theme->set_template('edit');
        $this->theme->get_template()->set_global('current_menu', "Jobs", false);
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการตำแหน่งงานทั้งหมดในระบบ", false);

        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Jobs", 'icon' => "fa-briefcase", 'link' => Uri::create('job/index'), 'active' => false),
            array('title' => "Edit", 'icon' => "", 'link' => "", 'active' => true)
        ));

        if (!$job = Model_Job::find($id)) {
            Session::set_flash('error', 'Could not find job #' . $id);
            Response::redirect('job');
        }

        // $employer = Model_Employer::find($job->employer_id);

        if(Input::method() == 'POST') {

            $val = Model_Job::validate('edit');

            /*$val->add_field('employer_name', 'Employer Name', 'required|max_length[255]');
            $val->add_field('employer_tel', 'Employer Tel', 'required');
            $val->add_field('employer_email', 'Employer E-Mail', 'required|valid_email');*/

            if(Input::post('job_type') == "fulltime"){
                $val->add_field('job_title_fulltime', 'Job Title', 'required|max_length[255]');
                $val->add_field('job_salary', 'Salary', 'required|max_length[255]');
            } else if(Input::post('job_type') == "project"){
                $val->add_field('job_title_project', 'Job Title', 'required|max_length[255]');
                //$val->add_field('job_budget_type', 'Price offer', 'required');
                $val->add_field('job_budget', 'Budget', 'required|max_length[255]');
            } else if(Input::post('job_type') == "contest"){
                $val->add_field('job_title_contest', 'Job Title', 'required|max_length[255]');
                $val->add_field('job_prize', 'Prize', 'required|max_length[255]');
            }

            if ($val->run()) {

                $error = false;

                // $employer_photo = "";
                $job_attachment = "";

                /* upload employer logo */
                /* $file = Input::file('employer_photo_file');

                $allowList = array(".jpeg", ".jpg", ".png");

                $path = realpath(DOCROOT."/../../uploads/profile_photo/employer/").DS;

                if($file['size'] > 0){

                    $ext = strtolower(substr($file['name'],strrpos($file['name'],".")));

                    if(!in_array($ext,$allowList)){
                        Session::set_flash('error', 'ชนิดของไฟล์ภาพไม่ถูกต้อง');
                        $error = true;
                    }

                    $filename = md5(time());

                    if(@copy($file['tmp_name'],$path.$filename."-o".$ext)){
                        $employer_photo = $filename.$ext;
                        parent::create_cropped_thumbnail($path.$filename."-o".$ext, 466, 360,"@2x");
                        parent::create_cropped_thumbnail($path.$filename."-o".$ext, 466, 360);
                    } else {
                        Session::set_flash('error', 'ไม่สามารถอัพโหลดไฟล์ภาพได้ โปรดลองใหม่อีกครั้ง');
                        $error = true;
                    }

                } */
                /* */

                /*if(strlen($employer_photo) && strlen($employer->employer_photo)){

                    $old_ext = strtolower(substr($employer->employer_photo,strrpos($employer->employer_photo,".")));

                    $old_filename = substr($employer->employer_photo,0,strrpos($employer->employer_photo,"."));

                    @unlink($path.$old_filename.$old_ext);
                    @unlink($path.$old_filename."@2x".$old_ext);
                    @unlink($path.$old_filename."-o".$old_ext);

                }*/

                /* upload job attachment */
                $file = Input::file('job_attachment_file');

                $allowList = array(".pdf", ".doc");

                $path = realpath(DOCROOT."/../../uploads/job_attachment/").DS;

                if($file['size'] > 0){

                    $ext = strtolower(substr($file['name'],strrpos($file['name'],".")));

                    if(!in_array($ext,$allowList)){
                        Session::set_flash('error', 'ชนิดของไฟล์แนบไม่ถูกต้อง');
                        $error = true;
                    }

                    $filename = md5(time()).$ext;

                    if(@copy($file['tmp_name'],$path.$filename)){
                        $job_attachment = $filename;
                    } else {
                        Session::set_flash('error', 'ไม่สามารถอัพโหลดไฟล์ได้ โปรดลองใหม่อีกครั้ง');
                        $error = true;
                    }

                }
                /* */

                if(!$error){

                    /*$employer->province_id = Input::post('province_id');
                    $employer->employer_name = Input::post('employer_name');
                    $employer->employer_desc = Input::post('employer_desc');
                    $employer->employer_addr = Input::post('employer_addr');
                    $employer->employer_tel = Input::post('employer_tel');
                    $employer->employer_fax = Input::post('employer_fax');
                    $employer->employer_email = Input::post('employer_email');
                    $employer->employer_website = Input::post('employer_website');
                    if(strlen($employer_photo)) $employer->employer_photo = $employer_photo;

                    $employer->save();*/

                    $job->employer_id = Input::post('employer_id');
                    $job->job_desc = Input::post('job_desc');
                    $job->job_type = Input::post('job_type');
                    $job->cat_id = Input::post('cat_id');
                    $job->subcat_id = Input::post('subcat_id');
                    $job->job_qualifications = Input::post('job_qualifications');
                    $job->job_skills = Input::post('job_skills');
                    $job->job_tags = Input::post('job_tags');
                    if(strlen($job_attachment)) $job->job_attachment = $job_attachment;
                    $job->job_is_featured = Input::post('job_is_featured');
                    $job->job_is_urgent = Input::post('job_is_urgent');
                    $job->job_is_active = Input::post('job_is_active');

                    if(Input::post('job_type') == "fulltime"){
                        $job->job_title = Input::post('job_title_fulltime');
                        $job->job_areas = Input::post('job_areas');
                        $job->job_position = Input::post('job_position');
                        $job->job_welfare = Input::post('job_welfare');
                        $job->job_salary = Input::post('job_salary');
                    } else if(Input::post('job_type') == "project"){
                        $job->job_title = Input::post('job_title_project');
                        $job->job_budget = Input::post('job_budget');
                    } else if(Input::post('job_type') == "contest"){
                        $job->job_title = Input::post('job_title_contest');
                        $job->job_prize = Input::post('job_prize');
                    }

                    if ($job->save()) {

                        /* generate tags */
                        $title = $job->job_title;
                        $title_tags = parent::split_tags($title);

                        if($job->employer_id){
                            $employer = Model_Employer::find($job->employer_id);
                            $company_tags = parent::split_tags($employer->employer_name);
                        } else {
                            $company_tags = array();
                        }

                        $tags = array_merge($title_tags,$company_tags);

                        foreach($tags as $t){

                            $t = strtolower(trim($t));

                            if(!strlen($t) || $t == " ") continue;

                            $tag = Model_JobTag::get_tag($job->id,$t);

                            if(!$tag){

                                $tag = Model_JobTag::forge(array(
                                    'job_id' => $job->id,
                                    'tag_name' => $t,
                                    'created_at' => time()
                                ));

                                $tag->save();

                            }

                        }
                        /* */

                        /* generate ref. no. */
                        if(!strlen($job->ref_no)){
                            $job->job_tags = implode(",",Model_JobTag::get_tags_by_job($job->id));
                            $job->ref_no = "J".str_pad($job->id,7,"0",STR_PAD_LEFT);
                            $job->save();
                        }

                        $qualifications = explode(",",Input::post('job_qualifications'));

                        foreach($qualifications as $q){

                            if(!strlen(trim($q))) continue;

                            $qual = Model_JobQualification::get_qualification($job->id,trim($q));

                            if(!$qual){

                                $qual = Model_JobQualification::forge(array(
                                    'job_id' => $job->id,
                                    'qualification_title' => trim($q),
                                    'created_at' => time()
                                ));

                                $qual->save();

                            }

                        }

                        $skills = explode(",",Input::post('job_skills'));

                        foreach($skills as $s){

                            if(!strlen(trim($s))) continue;

                            $skill = Model_JobSkill::get_skill($job->id,trim($s));

                            if(!$skill){

                                $skill = Model_JobSkill::forge(array(
                                    'job_id' => $job->id,
                                    'skill_title' => trim($s),
                                    'created_at' => time()
                                ));

                                $skill->save();

                            }

                        }

                        Session::set_flash('success', 'Updated job #' . $id);
                        Response::redirect('job');

                    } else {
                        Session::set_flash('error', 'Could not update job #' . $id);
                    }

                }

            } else {

                $msg = '<ul>';

                foreach ($val->error() as $field => $error){
                    $msg .= '<li>'.$error->get_message().'</li>';
                }
                $msg .= '</ul>';
                Session::set_flash('error', $msg);

            }

        }

        $this->theme->get_template()->set_global('job', $job, false);
        // $this->theme->get_template()->set_global('employer', $employer, false);

        $this->theme->get_template()->set_global('cats', Model_Category::get_categories(), false);
        $this->theme->get_template()->set_global('subcats', json_encode(Model_Subcategory::get_all_subcats()), false);

        $current_subcats = Model_Subcategory::get_subcats_by_category($job->cat_id);

        $this->theme->get_template()->set_global('current_subcats', $current_subcats, false);

        $this->theme->get_template()->set_global('provinces', Model_Province::get_provinces("th"), false);
        $this->theme->get_template()->set_global('employers', Model_Employer::get_employers_for_dropdown(), false);

        $this->theme->get_template()->set_global('page_specific_js', "form_job.js", false);

        $this->theme->set_partial('sidebar','common/sidebar');

        $this->theme->set_partial('left', 'job/edit');

        } catch(Exception $e){
            die($e->getMessage());
        }

    }

    public function action_delete($id = null) {
        is_null($id) and Response::redirect('job');
        if ($job = Model_Job::find($id)) {
            $job->delete();
            Session::set_flash('success', 'Deleted job #' . $id);
        } else {
            Session::set_flash('error', 'Could not delete job #' . $id);
        }
        Response::redirect('job');
    }

    public function after($response) {
        if (empty($response) or !$response instanceof Response) {
            $response = \Response::forge(\Theme::instance()->render());
        }
        return parent::after($response);
    }

}
