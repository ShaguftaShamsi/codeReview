<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tracking extends CI_Controller
{
    var $temp ='';
     
        function __construct() {
        parent::__construct();
    }

     

    public function index()
    {
      if($this->uri->segment(3) != null)
         {$data =array('check' =>$this->uri->segment(3),'token'=>$this->uri->segment(4));
         }
      else
     $data =array('check' =>$this->input->post('signUp/login'));
     //var_dump($data);
     $this->session->set_userdata($data);
     //print_r($this->session->all_userdata());
     $this->load->view('login.html');
    }
    /** User Login
     *  @acces  public
     *  @param  void
     * @return  void
    **/
    public function user_login()
    {    
          
        
         $check =$this->session->userdata('check');
         echo "$check";
         print_r($this->session->all_userdata());
         $data['email'] =$this->input->post('email');
         $data['password'] =$this->input->post('password');
         $this->form_validation->set_rules('email',' Email','trim|redqired|valid_email');
         $this->form_validation->set_rules('password','Password','trim|redqired|min_length[4]|max_length[32]');
         if($this->form_validation->run() == False)
         {            
              $this->load->view('login.html',$data);
         }
         else
         {   
         $this->load->model('tracking_model');
         if($check  == 'Login')
             {    echo "addsads";
     print_r($this->session->all_userdata());
              $this->load->view('login.html');
              $data['email'] =$this->input->post('email');
              $data['password'] =$this->input->post('password'); 
              $result=$this->tracking_model->validate();
              if($result){
                   redirect('track');   
                         }
             else {
                             var_dump($result);
                    redirect('track/show_error');
             }
            }
            else 
            {     
            $this->load->view('login.html');
             $result=$this->tracking_model->insert_new_user($data); 
               if($result)
                {              
                 redirect('track');
               }
            }
      
}
}

  public function  user_logout()
  {
      $this->session->sess_destroy();
      $this->load->view('start_view.html');
  }
}
?>
