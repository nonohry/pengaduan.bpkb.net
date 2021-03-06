<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class List_ticket extends CI_Controller{

    public $message;
    private $tipe;

    function __construct(){
        parent::__construct();
        backHandle();
        $c = $this->uri->rsegment(1);
        $this->load->model("$c"."_model",$c);
    }

    function gettipe(){
      return $this->tipe = $this->session->userdata('tipe');
    }

    function index(){
      $check = $this->userauth->checkmenu();
      $menu = $this->userauth->generate_menu($this->gettipe());
      $c = $this->uri->rsegment(1);
      $data = array(
        "menus" => $menu,
        "user" =>$this->userauth->getdatauser(),
        "title" =>strtoupper(str_replace("_"," ",$c)),
        "btn" =>$check,
        "departement" => $this->db->get("ticket_departement")->result(),
        "status" => $this->db->get("ticket_status")->result()
      );
      $this->template->load("main_template", "page/page_$c", $data);
    }

    function dataajax(){
      $dept_id = $this->input->post('dept_id');
      $status_id = $this->input->post('status_id');
       echo $this->list_ticket->dataajax($dept_id,$status_id);
    }

    function detail(){
      $this->userauth->checkmenu();
      methodpage();
      $id = $this->input->post("id");
      $data = $this->list_ticket->detail($id);
      echo json_encode($data);
    }

    function save(){
      $this->userauth->checkmenu();
      methodpage();
      $data = $this->fungsi->accept_data(array_keys($_POST));
      echo $this->list_ticket->save($data);
    }

    function delete(){
      $this->userauth->checkmenu();
      methodpage();
      $id = $this->input->post("id");
      $data = $this->list_ticket->delete($id);
    }

    
}
