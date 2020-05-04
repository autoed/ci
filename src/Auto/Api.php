<?php
namespace Auto;

trait Api
{
    /**
     * API
     * @notice this just for ci
     * User:  fomo3d.wiki
     * Email: fomo3d.wiki@gmail.com
     * Date: 2020/5/4
     */
    public function api()
    {
        $this->load->view('api', array('notice'=>'You should know , this api is useful !'));
    }
}