<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/7
 * Time: 下午12:00
 */

namespace Model\Seller;


class AnalyseController extends BaseController
{
    function __construct()
    {
        parent::__construct();
        G('menu', 'analyse');
    }

    /**
     * 门店销售统计
     */
    public function index(){
        global $_G,$_lang;

        $i = 0;
        $days = $days_data = array();
        while ($i < 30){
            $days[] = date('Ymd', strtotime("-$i day"));
            $days_data[] = date('m/d', strtotime("-$i day"));
            $i++;
        }
        $days = array_reverse($days);
        $record_list = shop_get_record_list(array('shop_id'=>$this->shop_id, 'datestamp'=>array('IN', implodeids($days))), 0);

        $datalist = array();
        foreach ($days as $day){
            $datalist[$day] = array(
                'shop_id'=>$this->shop_id,
                'order_num'=>0,
                'visit_num'=>0,
                'turnovers'=>0
            );
        }
        foreach ( $record_list as $record){
            $datalist[$record['datestamp']] = array(
                'order_num'=>$record['order_num'],
                'visit_num'=>$record['visit_num'],
                'turnovers'=>$record['turnovers']
            );
        }
        unset($i, $days, $day, $record_list, $record);
        $visit_data = $order_data = $turnovers_data = array();
        foreach ($datalist as $data){
            $visit_data[] = intval($data['visit_num']);
            $order_data[] = intval($data['order_num']);
            $turnovers_data[] = floatval($data['turnovers']);
        }
        $days_json = json_encode(array_reverse($days_data));
        $visit_json = json_encode($visit_data);
        $order_json = json_encode($order_data);
        $turnovers_json = json_encode($turnovers_data);

        include template('analyse');
    }
}