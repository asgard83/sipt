<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
class Nu extends Controller
{
    var $content = "";
    function Nu()
    {
        parent::Controller();
    }

    function index()
    {
        $appname = 'Sistem Informasi Pelaporan Terpadu | versi 1.0';
        if ($this->newsession->userdata('LOGGED_IN') == TRUE) {
            if ($this->content == "") $this->content = $this->load->view('welcome_message', '', true);
                $data = array('_appname_' => $appname,
                              '_name_' => $this->newsession->userdata('SESS_NAMA_USER'),
                              '_header_' => $this->load->view('header/home', '', true),
                              '_content_' => $this->content
                );
                $this->parser->parse('home-new', $data);
        }else{
            $data = array('_appname_' => $appname,
                          '_header_' => $this->load->view('header/login', '', true)
            );
            $this->parser->parse('login', $data);
        }
    }

}
?>