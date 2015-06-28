<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class survey extends CI_Controller {

    function __construct() {
        //load the library
        parent::__construct();
        $this->load->library("auth");
         $this->load->helper(array('form'));
        //this is how we protect it
        if( ! $this->auth->logged_in())
        {
            redirect("admin/login");  //for example
        }
    }
    
	public function index()
	{
	   $this->load->model('Survey_model');
	   if(isset($_POST['qaction']) && $_POST['qaction'] == "delque")
       {
            $qid = $_POST['qid'];
            $this->Survey_model->row_delete($qid);
       }
       if (isset($_GET['sid']) ){
        $sid = $_GET['sid'];
       $results = $this->Survey_model->get_selected($sid);
       
       }
       else{
       $results = $this->Survey_model->get_all();
      }
      
       $data['results'] = $results;
       $data['body'] = 'AllSurveyQuestion';
       $this->load->view('template',$data);
    }
    
    public function add_question()
    {
       //set validation rules
        $this->load->library('form_validation');
        //$this->form_validation->set_rules('qtype', 'Question Type', 'required');
        $this->form_validation->set_rules('question', 'Question', 'required');
       // $this->form_validation->set_rules('qanswer', 'Answer', 'required');
        //$this->form_validation->set_rules('difficultylevel', 'Difficulty Level', 'trim|required|numeric');
        
        if ($this->form_validation->run() == TRUE)
        {
          $data = array(
                // 'type' => $this->input->post('qtype'),
                // 'subtype' => $this->input->post('qsubtype'),
                'question' => $this->input->post('question'),
                'option' =>  json_encode($this->input->post('choice')),
                //'answer' => $this->input->post('qanswer'),
                // 'difficulty_level' => $this->input->post('difficultylevel'),
                );
          $this->load->model('Survey_model');
           $this->Survey_model->insert($data);
           $data['message'] = 'Survey Question Added Successfully';
         }
          
       $this->load->model('Survey_model');
      // $data['all_parents'] = $this->questiontype_model->get_parent_type();
       $data['body'] = 'AddSurveyQuestion';
       $this->load->view('template',$data);
    }
    
    
    function ajaxget_subtype()
    {
        $parent_id = $_POST['parent_id'];        
        $this->load->model('questiontype_model');
      //  $all_parents = $this->questiontype_model->get_sub_type($parent_id);
        $result = json_encode($all_parents);
        print_r($result);
        die;
        
    }
    
     public function edit_question()
    {
        if(isset($_GET['qid']))
        $qid = $_GET['qid'];
        //set validation rules
        $this->load->library('form_validation');
       // $this->form_validation->set_rules('qtype', 'Question Type', 'required');
        $this->form_validation->set_rules('question', 'Question', 'required');
        //$this->form_validation->set_rules('difficultylevel', 'Difficulty Level', 'trim|required|numeric');
      //  $this->form_validation->set_rules('qanswer', 'Answer', 'required');
        
        if ($this->form_validation->run() == TRUE)
        {
            $data = array(
                //'type' => $this->input->post('qtype'),
                //'subtype' => $this->input->post('qsubtype'),
                'question' => $this->input->post('question'),
                'option' =>  json_encode($this->input->post('choice')),
                //'answer' => $this->input->post('qanswer'),
                //'difficulty_level' => $this->input->post('difficultylevel'),
                );
          $this->load->model('Survey_model');
          $qid = $this->input->post('qid');
           $res = $this->Survey_model->update_question($qid,$data);
           if($res)
           $data['message'] = 'Survey Question updated Successfully!';
           else
           $data['error_message'] = 'Error While updating Question';
        }
        
        
            if(isset($qid) && $qid != "")
            {
                
                $this->load->model('Survey_model');
                $squestion = $this->Survey_model->get_single($qid);
                if(!is_object($squestion))
                {
                    $data['error_message'] = "No Record Found";
                }
                else
                {
                    $data['data'] = $squestion;
                    $this->load->model('Survey_model');
                    //$data['all_parents'] = $this->Survey_model->get_parent_type();
                    //$data['all_childs'] = $this->Survey_model->get_sub_type($squestion->type); 
                }   
               
                print_r($data);
                $data['body'] = 'EditSurveyQuestion';
                $this->load->view('template',$data); 
            }
            else
            {
                redirect("survey-questions");
            }
        
        
         
    }


    // view Question

     public function view_question()
    {

        if(isset($_GET['qid']))
        $qid = $_GET['qid'];
        //set validation rules
        $this->load->library('form_validation');
        $this->form_validation->set_rules('qtype', 'Question Type', 'required');
        $this->form_validation->set_rules('question', 'Question', 'required');
        $this->form_validation->set_rules('difficultylevel', 'Difficulty Level', 'trim|required|numeric');
        //$this->form_validation->set_rules('qanswer', 'Answer', 'required');
        
        // if ($this->form_validation->run() == TRUE)
        // {
        //     $data = array(
        //         'type' => $this->input->post('qtype'),
        //         'subtype' => $this->input->post('qsubtype'),
        //         'question' => $this->input->post('question'),
        //         'option' =>  json_encode($this->input->post('choice')),
        //         'answer' => $this->input->post('qanswer'),
        //         'difficulty_level' => $this->input->post('difficultylevel'),
        //         );
        //   $this->load->model('questionmodel');
        //   $qid = $this->input->post('qid');
        //    $res = $this->questionmodel->update_question($qid,$data);
        //    if($res)
        //    $data['message'] = 'Question updated Successfully!';
        //    else
        //    $data['error_message'] = 'Error While updating Question';
        // }
        
        
            if(isset($qid) && $qid != "")
            {
                
                $this->load->model('Survey_model');
                $squestion = $this->Survey_model->get_single($qid);
                if(!is_object($squestion))
                {
                    $data['error_message'] = "No Record Found";
                }
                else
                {
                    $data['data'] = $squestion;
                    $this->load->model('Survey_model');
                    //$data['all_parents'] = $this->Survey_model->get_parent_type();
                    //$data['all_childs'] = $this->Survey_model->get_sub_type($squestion->type); 
                }   
               
                
                $data['body'] = 'ViewSurveyQuestion';
                $this->load->view('template',$data); 

            }
            else
            {
                redirect("survey-questions");
            }
        
        
         
    }

    
    
 }
?>