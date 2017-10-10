<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/10
 * Time: 上午11:38
 */

namespace Model\Admin;


use Core\Pinyin;
use Data\Common\DistrictModel;

class DistrictController extends BaseController
{
    /**
     * 区域信息管理
     */
    public function index(){
        global $_G,$_lang;

        $model = new DistrictModel();
        if ($this->checkFormSubmit()){
            $delete = $_GET['delete'];
            if ($delete) {
                foreach ($delete as $id){
                    $model->where(array('id'=>$id))->delete();
                }
            }

            $districtlist = $_GET['districtlist'];
            if ($districtlist) {
                $pinyin = new Pinyin();
                foreach ($districtlist as $id=>$district){
                    if ($district['name']){
                        if (!$district['letter']){
                            $district['letter'] = $pinyin->getFirstChar($district['name']);
                        }

                        if (!$district['pinyin']){
                            $district['pinyin'] = $pinyin->getPinyin($district['name']);
                        }
                        if ($id > 0){
                            $model->where(array('id'=>$id))->data($district)->save();
                        }else {
                            $province = intval($_GET['province']);
                            $city     = intval($_GET['city']);
                            $county   = intval($_GET['county']);
                            if ($county){
                                $district['fid'] = $county;
                                $district['level'] = 4;
                            }elseif ($city) {
                                $district['fid'] = $city;
                                $district['level'] = 3;
                            }elseif ($province){
                                $district['fid'] = $province;
                                $district['level'] = 2;
                            }else {
                                $district['fid'] = 0;
                                $district['level'] = 1;
                            }
                            $model->data($district)->add();
                        }
                    }
                }
            }
            $this->showSuccess('save_succeed');
        }else {
            $province = intval($_GET['province']);
            $city     = intval($_GET['city']);
            $county   = intval($_GET['county']);

            $provincelist = $citylist = $countylist = $districtlist = array();

            $provincelist = $model->where(array('fid'=>0))->order('displayorder ASC,id ASC')->select();
            $districtlist = $provincelist;

            if ($province) {
                $citylist = $model->where(array('fid'=>$province))->order('displayorder ASC,id ASC')->select();
                $districtlist = $citylist;
            }

            if ($city) {
                $countylist = $model->where(array('fid'=>$city))->order('displayorder ASC,id ASC')->select();
                $districtlist = $countylist;
            }


            if ($county) {
                $districtlist = $model->where(array('fid'=>$county))->order('displayorder ASC,id ASC')->select();
            }

            include template('common/district');
        }
    }
}