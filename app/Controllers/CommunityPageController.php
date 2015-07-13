<?php

namespace App\Controllers;

use App\Controllers\Base\CommunityPageBaseController;
use App\Interfaces\PhotoRepositoryInterface;
use App\Repositories\CommunityCategoryRepository;
use App\Repositories\CommunityMemberRepository;
use App\Repositories\CommunityRepository;
use App\Repositories\ConnectionRepository;
use App\Repositories\CustomFieldRepository;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use App\Controllers\Xcrud;

/* Adam Endvy */

class CommunityPageController extends CommunityPageBaseController
{
    public function __construct(
        CustomFieldRepository $customFieldRepository,
        PostRepository $postRepository,
        CommunityCategoryRepository $categoryRepository,
        PhotoRepositoryInterface $photoRepositoryInterface,
        ConnectionRepository $connectionRepository,
        CommunityMemberRepository $communityMemberRepository,
        CommunityRepository $communityRepository,
        UserRepository $userRepository
    )
    {
        parent::__construct();
        $this->customFiedRepository = $customFieldRepository;
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
        $this->photo = $photoRepositoryInterface;
        $this->connectionRepository = $connectionRepository;
        $this->memberRepository = $communityMemberRepository;
        $this->userRepository = $userRepository;
        $this->communityRepostory = $communityRepository;
    }

    public function index()
    {
        if (!$this->exists()) {
            return $this->notFound();
        }
        return $this->render('community.page.index', [
            'posts' => $this->postRepository->lists('community-'.$this->community->id)
        ], [
            'title' => $this->setTitle(''),
        ]);
    }

    public function category($slug, $category)
    {
        if (!$this->exists()) {
            return $this->notFound();
        }

        $category = $this->categoryRepository->get($category, $this->community->id);

        if (empty($category)) return \Redirect::to($this->community->present()->url());

        return $this->render("community.page.category", [
            'posts' => $this->postRepository->lists('communitycategory-'.$category->id),
            'typeId' => $category->id
        ], ['title' => $this->setTitle($category->title)]);
    }

    public function edit()
    {
        if (!$this->exists()) {
            return $this->notFound();
        }

        if (!$this->community->present()->isAdmin()) return \Redirect::to($this->community->present()->url());

        $message = null;
        if ($val = \Input::get('val')) {

            $validator = \Validator::make($val, [
                'title' => 'required'
            ]);

            if (!$validator->fails()) {
                $save = $this->communityRepository->save($val, $this->community);

                if ($save) {
                    //send to this community home
                    return \Redirect::to($this->community->present()->url());
                } else {
                    $message = trans('community.save-error');
                }
            } else {
                $message = $validator->messages()->first();
            }
        }

        return $this->render('community.page.edit', ['fields' => $this->customFiedRepository->listAll('community'), 'message' => $message ], [
            'title' => $this->setTitle(trans('global.edit'))
        ]);
    }

    public function design()
    {
        if (!$this->exists() or !\Config::get('page-design')) {
            return $this->notFound();
        }

        if (!$this->community->present()->isAdmin()) return \Redirect::to($this->community->present()->url());

        $message = null;
        if ($val = \Input::get('val')) {
            $this->userRepository->saveDesign($val);
            $message = trans('community.design-save');
        }

        return $this->render('community.page.design', ['user' => $this->community->user, 'message' => $message ], [
            'title' => $this->setTitle(trans('community.design'))
        ]);
    }

    public function addCategory()
    {
        $id = \Input::get('id');
        $name = \Input::get('text');

        $category = $this->categoryRepository->add($id, $name);

        if ($category) {
            return json_encode([
                'title' => $category->title,
                'url' => $category->community->present()->url('category/'.$category->slug),
                'status' => 1
            ]);
        } else {
            return json_encode([
                'status' => 0,
                'message' => trans('community.category-create-error')
            ]);
        }


    }

    public function deleteCategory($id)
    {
        $this->categoryRepository->delete($id);

        return '1';
    }

    public function about()
    {
        if (!$this->exists()) {
            return $this->notFound();
        }

        return $this->render('community.page.about', [], ['title' => $this->setTitle(trans('global.about'))]);
    }

    public function invite()
    {
        if (!$this->exists()) {
            return $this->notFound();
        }

        if (!$this->community->present()->canInvite()) return \Redirect::to(\URL::previous());

        return $this->render('community.page.invite', ['connections' => $this->connectionRepository->getFriends()], ['title' => $this->setTitle('Invite Members')]);

    }

    public function members()
    {
        if (!$this->exists()) {
            return $this->notFound();
        }

        return $this->render('community.page.members', ['members' => $this->memberRepository->listUsers($this->community->id)], ['title' => $this->setTitle('Members')]);
    }

    public function join($id)
    {
        $this->communityRepository->join($id);

        return '1';
    }


    public function uploadCover()
    {
        $result = json_encode([
            'status' => 'error',
            'message' => 'Insufficient image width/Height, MinWidth : 100px and MinHeight :  100px'
        ]);

        if (!\Input::hasFile('img')) return json_encode([
            'status' => 'error',
            'message' => trans('photo.error', ['size' => formatBytes()])
        ]);

        $file = \Input::file('img');

        if (!$this->photo->imagesMetSizes($file)) return json_encode([
            'status' => 'error',
            'message' => trans('photo.error', ['size' => formatBytes()])
        ]);

        list($width, $height) = getimagesize($file->getRealPath());

        if ($width < 100 or $height < 100) {
            return $result;
        }
        if ($width < 1000) {
            //let use direct upload like that
            $imageRepo = $this->photo->image;
            $image = $imageRepo->load($file)->setPath('temp/')->offCdn();
            $image = $image->resize(800, 500, 'fill', 'up');;

            //if ($image->hasError()) return $result;

            $image = $image->result();
            $image = str_replace('%d', '800', $image);
        }  else {
            $image = $this->photo->upload($file, [
                'path' => 'temp/',
                'width' => 600,
                'fit' => 'inside',
                'scale' => 'down',
                'cdn' => false
            ]);

            if (!$image) return $result;
            $image = str_replace('_%d_', '_600_', $image);
        }




        if ($image) {

            list($width, $height) = getimagesize(base_path().'/'.$image);
            return json_encode([
                'status' => 'success',
                'url' => \URL::to($image),

            ]);
        }

        return $result;
    }

    public function cropCover()
    {
        $top = \Input::get('imgY1');
        $left = \Input::get('imgX1');
        $cWidth = \Input::get('cropW');
        $cHeight = \Input::get('cropH');
        $file = \Input::get('imgUrl');
        $file = str_replace( [\URL::to(''), '//'],[ '', '/'], $file);
        $id = \Input::get('id');

        $image = $this->photo->cropImage(base_path('').$file, 'cover/', $left, $top, $cWidth, $cHeight, false);
        $image = str_replace('%d', 'original', $image->result());

        /**make sure to delete the original image***/
        $this->photo->delete($file);

        if (!empty($image)) {
            /**
             * Update user profile cover
             */
            $this->communityRepository->updateLogo($id, $image);
            return json_encode([
                'status' => 'success',
                'url' => \Image::url($image),
            ]);
        } else {
            return json_encode([
                'status' => 'error',
                'message' => 'Error ',
            ]);
        }


    }


    // Manajemen Organisasi

    public function asatidz($slug)
    {
        if (!$this->exists()) {
            return $this->notFound();
        }

        $community = $this->communityRepostory->get($slug);
        XcrudConfig::$editor_url = '/app/editors/ckeditor/ckeditor.js';

        if ($this->community->present()->isAdmin())
        {

            $data = Xcrud::get_instance()->table('inti_community_asatidz')
                ->columns('astatidz_name,contact_person,address')
                ->fields('astatidz_name,contact_person,address')
                ->column_name('astatidz_name', 'Nama Ustadz')
                ->column_name('contact_person', 'Kontak')
                ->column_name('address', 'Alamat')
                ->label('astatidz_name', 'Nama Ustadz')
                ->label('contact_person', 'Kontak')
                ->label('address', 'Alamat')
                ->pass_var('community_id', $community->id )
                ->change_type('address','textarea')
                ->where("inti_community_asatidz.community_id = '".$community->id."'")
                ->unset_title()
                ->unset_limitlist()
                ->unset_view()
                //->unset_edit()
                //->unset_remove()
                //->unset_csv()
                ->limit(10);
        }else{

            $data = Xcrud::get_instance()->table('inti_community_asatidz')
                ->columns('astatidz_name,contact_person,address')
                ->fields('astatidz_name,contact_person,address')
                ->column_name('astatidz_name', 'Nama Ustadz')
                ->column_name('contact_person', 'Kontak')
                ->column_name('address', 'Alamat')
                ->label('astatidz_name', 'Nama Ustadz')
                ->label('contact_person', 'Kontak')
                ->label('address', 'Alamat')
                ->pass_var('community_id', $community->id )
                ->change_type('address','textarea')
                ->where("inti_community_asatidz.community_id = '".$community->id."'")
                ->unset_title()
                ->unset_limitlist()
                ->unset_view()
                ->unset_edit()
                ->unset_remove()
                ->unset_add()
                ->limit(10);
        }

        return $this->render('community.page.manage', ['data' => $data, 'header' => 'Daftar Asatidz'], ['title' => $this->setTitle(trans('global.about'))]);
    }


    // Manajemen Organisasi

    public function khotbah($slug)
    {
        if (!$this->exists()) {
            return $this->notFound();
        }

        $community = $this->communityRepostory->get($slug);

        XcrudConfig::$editor_url = '/app/editors/ckeditor/ckeditor.js';

        if ($this->community->present()->isAdmin())
        {
            $data = Xcrud::get_instance()->table('inti_community_khotbah')
                ->columns('date,astatidz_id,Kontak,description')
                ->fields('date,astatidz_id,description')
                ->relation('astatidz_id','inti_community_asatidz','id','astatidz_name','community_id = '.$community->id)
                ->subselect('Kontak','SELECT contact_person FROM inti_community_asatidz WHERE id = {astatidz_id}')
                ->column_name('astatidz_id', 'Nama Ustadz')
                ->column_name('date', 'Tanggal')
                ->column_name('description', 'Keterangan')
                ->label('astatidz_id', 'Nama Ustadz')
                ->label('date', 'Tanggal')
                ->label('description', 'Keterangan')
                ->pass_var('community_id', $community->id )
                ->change_type('description','textarea')
                ->where("inti_community_khotbah.community_id = '".$community->id."'")
                ->unset_title()
                ->unset_limitlist()
                ->unset_view()
                //->unset_edit()
                //->unset_remove()
                //->unset_csv()
                ->limit(10);
        }else{
            $data = Xcrud::get_instance()->table('inti_community_khotbah')
                ->columns('date,astatidz_id,Kontak,description')
                ->fields('date,astatidz_id,description')
                ->relation('astatidz_id','inti_community_asatidz','id','astatidz_name','community_id = '.$community->id)
                ->subselect('Kontak','SELECT contact_person FROM inti_community_asatidz WHERE id = {astatidz_id}')
                ->column_name('astatidz_id', 'Nama Ustadz')
                ->column_name('date', 'Tanggal')
                ->column_name('description', 'Keterangan')
                ->label('astatidz_id', 'Nama Ustadz')
                ->label('date', 'Tanggal')
                ->label('description', 'Keterangan')
                ->pass_var('community_id', $community->id )
                ->change_type('description','textarea')
                ->where("inti_community_khotbah.community_id = '".$community->id."'")
                ->unset_title()
                ->unset_limitlist()
                ->unset_view()
                ->unset_edit()
                ->unset_remove()
                ->unset_add()
                ->limit(10);

        }

        return $this->render('community.page.manage', ['data' => $data, 'header' => 'Jadwal Ustadz Khotbah Jum\'at'], ['title' => $this->setTitle(trans('global.about'))]);
    }



    // Manajemen Organisasi

    public function structure($slug)
    {
        if (!$this->exists()) {
            return $this->notFound();
        }

        $community = $this->communityRepostory->get($slug);

        XcrudConfig::$editor_url = '/app/editors/ckeditor/ckeditor.js';

        if ($this->community->present()->isAdmin())
        {
            $data = Xcrud::get_instance()->table('inti_community_structure')
                ->columns('user_id,position,job_desc')
                ->fields('user_id,position,job_desc')
                ->relation('user_id','inti_view_community_members','user_id','fullname','community_id = '.$community->id)
                //->fk_relation('user_id','community_id','inti_community_members','community_id','user_id','inti_users','id','fullname')
                ->column_name('user_id', 'Nama Pengurus')
                ->label('user_id', 'Nama Pengurus')
                ->label('position', 'Jabatan')
                ->label('job_desc', 'Deskripsi Tugas')
                ->label('created_at', 'Tanggal Dibuat')
                ->pass_var('community_id', $community->id )
                ->where("inti_community_structure.community_id = '".$community->id."'")
                ->unset_title()
                ->unset_limitlist()
                ->unset_view()
                //->unset_edit()
                //->unset_remove()
                ->unset_csv()
                ->limit(10);
        }else{
            $data = Xcrud::get_instance()->table('inti_community_structure')
                ->columns('user_id,position,job_desc')
                ->fields('user_id,position,job_desc')
                ->relation('user_id','inti_view_community_members','user_id','fullname','community_id = '.$community->id)
                //->fk_relation('user_id','community_id','inti_community_members','community_id','user_id','inti_users','id','fullname')
                ->column_name('user_id', 'Nama Pengurus')
                ->label('user_id', 'Nama Pengurus')
                ->label('position', 'Jabatan')
                ->label('job_desc', 'Deskripsi Tugas')
                ->label('created_at', 'Tanggal Dibuat')
                ->pass_var('community_id', $community->id )
                ->where("inti_community_structure.community_id = '".$community->id."'")
                ->unset_title()
                ->unset_limitlist()
                ->unset_view()
                ->unset_edit()
                ->unset_remove()
                ->unset_add()
                ->unset_csv()
                ->limit(10);
        }

        return $this->render('community.page.manage', ['data' => $data, 'header' => 'Daftar Struktur Organisasi'], ['title' => $this->setTitle(trans('global.about'))]);
    }

    // Manajemen Organisasi 

    public function workprogram($slug)
    {
        if (!$this->exists()) {
            return $this->notFound();
        }

        $community = $this->communityRepostory->get($slug);

        if ($this->community->present()->isAdmin())
        {

            $data = Xcrud::get_instance()->table('inti_community_workprogram')
                ->columns('program_name,classification,task,coordinator,description')
                ->fields('program_name,classification,task,coordinator,description')
                ->relation('coordinator','inti_view_community_members','user_id','fullname','community_id = '.$community->id)
                ->column_name('program_name', 'Nama Program')
                ->column_name('classification', 'Klasifikasi')
                ->column_name('task', 'Pekerjaan yang muncul')
                ->column_name('coordinator', 'Penanggung Jawab')
                ->column_name('description', 'Keterangan')
                ->label('program_name', 'Nama Program')
                ->label('classification', 'Klasifikasi')
                ->label('task', 'Pekerjaan')
                ->label('coordinator', 'Penanggung Jawab')
                ->label('description', 'Keterangan')
                ->pass_var('community_id', $community->id )
                ->where("inti_community_workprogram.community_id = '".$community->id."'")
                ->unset_title()
                ->unset_limitlist()
                ->unset_view()
                ->unset_edit()
                //->unset_remove()
                ->unset_csv()
                ->limit(10);
        }else{
            $data = Xcrud::get_instance()->table('inti_community_workprogram')
                ->columns('program_name,classification,task,coordinator,description')
                ->fields('program_name,classification,task,coordinator,description')
                ->relation('coordinator','inti_view_community_members','user_id','fullname','community_id = '.$community->id)
                ->column_name('program_name', 'Nama Program')
                ->column_name('classification', 'Klasifikasi')
                ->column_name('task', 'Pekerjaan yang muncul')
                ->column_name('coordinator', 'Penanggung Jawab')
                ->column_name('description', 'Keterangan')
                ->label('program_name', 'Nama Program')
                ->label('classification', 'Klasifikasi')
                ->label('task', 'Pekerjaan')
                ->label('coordinator', 'Penanggung Jawab')
                ->label('description', 'Keterangan')
                ->pass_var('community_id', $community->id )
                ->where("inti_community_workprogram.community_id = '".$community->id."'")
                ->unset_title()
                ->unset_limitlist()
                ->unset_view()
                ->unset_edit()
                ->unset_remove()
                ->unset_add()
                //->unset_remove()
                ->unset_csv()
                ->limit(10);
        }

        return $this->render('community.page.manage', ['data' => $data, 'header' => 'Program Kerja'], ['title' => $this->setTitle(trans('global.about'))]);
    }


    // Manajemen Organisasi 

    public function event($slug)
    {
        if (!$this->exists()) {
            return $this->notFound();
        }

        $community = $this->communityRepostory->get($slug);

        if ($this->community->present()->isAdmin())
        {
            $data = Xcrud::get_instance()->table('inti_community_event')
                ->columns('event_name,description,location,datetime')
                ->fields('event_name,description,location,datetime')
                ->column_name('event_name', 'Nama Kegiatan')
                ->column_name('description', 'Deskripsi')
                ->column_name('location', 'Tempat')
                ->column_name('datetime', 'Waktu dan Tanggal')
                ->label('event_name', 'Nama Kegiatan')
                ->label('description', 'Deskripsi')
                ->label('location', 'Tempat')
                ->label('datetime', 'Waktu dan Tanggal')
                ->pass_var('community_id', $community->id )
                ->where("inti_community_event.community_id = '".$community->id."'")
                ->unset_title()
                ->unset_limitlist()
                ->unset_view()
                ->unset_edit()
                //->unset_remove()
                ->unset_csv()
                ->order_by('id','desc')
                ->limit(10);
        }else{
            $data = Xcrud::get_instance()->table('inti_community_event')
                ->columns('event_name,description,location,datetime')
                ->fields('event_name,description,location,datetime')
                ->column_name('event_name', 'Nama Kegiatan')
                ->column_name('description', 'Deskripsi')
                ->column_name('location', 'Tempat')
                ->column_name('datetime', 'Waktu dan Tanggal')
                ->label('event_name', 'Nama Kegiatan')
                ->label('description', 'Deskripsi')
                ->label('location', 'Tempat')
                ->label('datetime', 'Waktu dan Tanggal')
                ->pass_var('community_id', $community->id )
                ->where("inti_community_event.community_id = '".$community->id."'")
                ->unset_title()
                ->unset_limitlist()
                ->unset_view()
                ->unset_edit()
                ->unset_remove()
                ->unset_add()
                ->unset_csv()
                ->order_by('id','desc')
                ->limit(10);   
        }

        return $this->render('community.page.manage', ['data' => $data, 'header' => 'Agenda Kegiatan' ], ['title' => $this->setTitle(trans('global.about'))]);
    }

    // Manajemen Organisasi 

    public function attendance($slug)
    {
        if (!$this->exists()) {
            return $this->notFound();
        }

        $community = $this->communityRepostory->get($slug);

        if ($this->community->present()->isAdmin())
        {

            $data = Xcrud::get_instance()->table('inti_community_attendance')
                ->columns('workprogram_id,member_id,datetime')
                ->fields('workprogram_id,member_id,datetime')
                ->relation('member_id','inti_view_community_members','user_id','fullname','community_id = '.$community->id,'fullname',true)
                ->relation('workprogram_id','inti_community_workprogram','id','program_name','community_id = '.$community->id)
                ->column_name('workprogram_id', 'Nama Program')
                ->column_name('member_id', 'Anggota')
                ->column_name('datetime', 'Tanggal')
                ->label('workprogram_id', 'Nama Program')
                ->label('member_id', 'Anggota')
                ->label('datetime', 'Tanggal')
                ->pass_var('community_id', $community->id )
                ->where("inti_community_attendance.community_id = '".$community->id."'")
                ->unset_title()
                ->unset_limitlist()
                ->unset_view()
                //->unset_edit()
                //->unset_remove()
                ->unset_csv()
                ->limit(10);
        }else{
            $data = Xcrud::get_instance()->table('inti_community_attendance')
                ->columns('workprogram_id,member_id,datetime')
                ->fields('workprogram_id,member_id,datetime')
                ->relation('member_id','inti_view_community_members','user_id','fullname','community_id = '.$community->id,'fullname',true)
                ->relation('workprogram_id','inti_community_workprogram','id','program_name','community_id = '.$community->id)
                ->column_name('workprogram_id', 'Nama Program')
                ->column_name('member_id', 'Anggota')
                ->column_name('datetime', 'Tanggal')
                ->label('workprogram_id', 'Nama Program')
                ->label('member_id', 'Anggota')
                ->label('datetime', 'Tanggal')
                ->pass_var('community_id', $community->id )
                ->where("inti_community_attendance.community_id = '".$community->id."'")
                ->where("inti_community_attendance.member_id like '%".\Auth::user()->id."%'")
                ->unset_title()
                ->unset_limitlist()
                ->unset_view()
                ->unset_edit()
                ->unset_remove()
                ->unset_add()
                ->unset_csv()
                ->limit(10);
        }

        return $this->render('community.page.manage', ['data' => $data, 'header' => 'Daftar Kehadiran'], ['title' => $this->setTitle(trans('global.about'))]);
    }

    // Manajemen Organisasi 

    public function point($slug)
    {
        if (!$this->exists()) {
            return $this->notFound();
        }

        $community = $this->communityRepostory->get($slug);

        if ($this->community->present()->isAdmin())
        {
            $data = Xcrud::get_instance()->table('inti_community_points')
                ->columns('workprogram_id,member_id,point,date,description')
                ->fields('workprogram_id,member_id,point,date,description')
                ->relation('member_id','inti_view_community_members','user_id','fullname','community_id = '.$community->id,'fullname',true)
                ->relation('workprogram_id','inti_community_workprogram','id','program_name','community_id = '.$community->id)
                ->column_name('workprogram_id', 'Nama Program')
                ->column_name('member_id', 'Anggota')
                ->column_name('date', 'Tanggal')
                ->column_name('description', 'Keterangan')
                ->label('workprogram_id', 'Nama Program')
                ->label('member_id', 'Anggota')
                ->label('date', 'Tanggal')
                ->label('description', 'Keterangan')
                ->pass_var('community_id', $community->id )
                ->where("inti_community_points.community_id = '".$community->id."'")
                ->unset_title()
                ->unset_limitlist()
                ->unset_view()
                ->sum('point')
                //->unset_edit()
                //->unset_remove()
                ->unset_csv()
                ->limit(10);
        }else{
            $data = Xcrud::get_instance()->table('inti_community_points')
                ->columns('workprogram_id,member_id,point,date,description')
                ->fields('workprogram_id,member_id,point,date,description')
                ->relation('member_id','inti_view_community_members','user_id','fullname','community_id = '.$community->id,'fullname',true)
                ->relation('workprogram_id','inti_community_workprogram','id','program_name','community_id = '.$community->id)
                ->column_name('workprogram_id', 'Nama Program')
                ->column_name('member_id', 'Anggota')
                ->column_name('date', 'Tanggal')
                ->column_name('description', 'Keterangan')
                ->label('workprogram_id', 'Nama Program')
                ->label('member_id', 'Anggota')
                ->label('date', 'Tanggal')
                ->label('description', 'Keterangan')
                ->pass_var('community_id', $community->id )
                ->where("inti_community_points.community_id = '".$community->id."'")
                ->where("inti_community_points.member_id like '%".\Auth::user()->id."%'")
                ->unset_title()
                ->unset_limitlist()
                ->unset_view()
                ->sum('point')
                ->unset_edit()
                ->unset_remove()
                ->unset_add()
                ->unset_csv()
                ->limit(10);
        }

        return $this->render('community.page.manage', ['data' => $data, 'header' => 'Daftar Poin Anggota (SSKM)'], ['title' => $this->setTitle(trans('global.about'))]);
    }

    // Manajemen Organisasi 

    public function donation($slug)
    {
        if (!$this->exists()) {
            return $this->notFound();
        }

        $community = $this->communityRepostory->get($slug);

        if ($this->community->present()->isAdmin())
        {

            $data = Xcrud::get_instance()->table('inti_community_donations')
                ->columns('donor_name,address,telp,email,date,amount')
                ->fields('donor_name,address,telp,email,date,amount')
                ->column_name('donor_name', 'Nama Donatur')
                ->column_name('address', 'Alamat')
                ->column_name('telp', 'Telp')
                ->column_name('email', 'Email')
                ->column_name('date', 'Tanggal')
                ->column_name('amount', 'Jumlah')
                ->label('donor_name', 'Nama Donatur')
                ->label('address', 'Alamat')
                ->label('telp', 'Telp')
                ->label('email', 'Email')
                ->label('date', 'Tanggal')
                ->label('amount', 'Jumlah')
                ->pass_var('community_id', $community->id )
                ->where("inti_community_donations.community_id = '".$community->id."'")
                ->change_type('amount', 'price', '0', array('prefix'=>'Rp ', 'separator'=>'.', 'point'=>','))
                ->field_callback('amount','nice_input_jumlah_uang', app_path().'/config/function.php')
                ->before_insert('save_donation', app_path().'/config/function.php')
                ->unset_title()
                ->unset_limitlist()
                ->unset_view()
                ->sum('amount')
                ->unset_edit()
                //->unset_remove()
                ->unset_csv()
                ->order_by('id','desc')
                ->limit(10);
        }else{
            $data = Xcrud::get_instance()->table('inti_community_donations')
                ->columns('donor_name,address,telp,email,date,amount')
                ->fields('donor_name,address,telp,email,date,amount')
                ->column_name('donor_name', 'Nama Donatur')
                ->column_name('address', 'Alamat')
                ->column_name('telp', 'Telp')
                ->column_name('email', 'Email')
                ->column_name('date', 'Tanggal')
                ->column_name('amount', 'Jumlah')
                ->label('donor_name', 'Nama Donatur')
                ->label('address', 'Alamat')
                ->label('telp', 'Telp')
                ->label('email', 'Email')
                ->label('date', 'Tanggal')
                ->label('amount', 'Jumlah')
                ->pass_var('community_id', $community->id )
                ->where("inti_community_donations.community_id = '".$community->id."'")
                ->change_type('amount', 'price', '0', array('prefix'=>'Rp ', 'separator'=>'.', 'point'=>','))
                ->field_callback('amount','nice_input_jumlah_uang', app_path().'/config/function.php')
                ->before_insert('save_donation', app_path().'/config/function.php')
                ->unset_title()
                ->unset_limitlist()
                ->unset_view()
                ->sum('amount')
                ->unset_edit()
                ->unset_remove()
                ->unset_add()
                ->unset_csv()
                ->order_by('id','desc')
                ->limit(10);
        }

        return $this->render('community.page.manage', ['data' => $data, 'header' => 'Hasil Donasi'], ['title' => $this->setTitle(trans('global.about'))]);
    }

}