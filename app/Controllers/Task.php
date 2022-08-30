<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\TaskModel;

use App\Models\TaskprojectModel; //pngil class lain file
//use App\Models\ListprojectModel; //pngil class lain file

class Task extends BaseController
{
	
    protected $taskModel;
	protected $taskprojectModel; //variable baru
	//protected $listprojectModel; //variable baru
    protected $validation;
	
	public function __construct()
	{
	    $this->taskModel = new TaskModel();
		$this->taskprojectModel = new taskprojectModel(); //object baru
       	$this->validation =  \Config\Services::validation();
		
		$session = session();
		if(!$session->get('username') || $session->get('username')=="") {
			header("Location: /login");	//redirect
			exit(); //or can use die;
		}
		
	}
	
	public function index()
	{
		$data = [
                'controller'    	=> 'task',
                'title'     		=> 'task'				
			];
		
		return view('task', $data);
			
	}

	public function getProjectList()
	{
		$response = array();		
		//$data = array();
		//$result = $this->listprojectModel->select('id, project_name')->findAll();
		$result = $this->taskprojectModel->select('*')->findAll();
		
		foreach ($result as $key => $value) {
							
			$data[$key] = array(
				'id' => $value->id,
				'project_name' => $value->project_name,
			);
		} 

		return $this->response->setJSON($data);		
	}
	
	public function getAll()
	{	
		//$includeArchive = isset($_POST['includeArchive']) ? $_POST['includeArchive'] : 0;
		
		$includeArchive = $this->request->getPost('includeArchive');
		
		$strArchive = "archive = 0"; 
		if($includeArchive=="true") $strArchive = "archive is not null"; 
			
 		$response = array();		
		
	    $data['data'] = array();
		
		$result = $this->taskModel
		->select('task.*,  task.id as id, task_status.status_name as status_name, users.fullname as fullname, task_project.project_name as project')
		->join('task_status', 'task_status.status_id = task.task_status')
		->join('users', 'users.id = task.assigned_to')
		->join('task_project', 'task_project.id = task.project')
		->where($strArchive)
		->orderby('task.date_assign', 'DESC')
		->orderby('task.id', 'DESC')
		->findAll();
		
		$i = 1;
		foreach ($result as $key => $value) {
							
			$ops = '<div class="btn-group">';
			//$ops .= '	<button type="button" class="btn btn-sm btn-info" data-id="'. $value->id .'" onclick="edit('. $value->id .')"> <i class="fa fa-edit">'.$value->id.'</i></button>';
			$ops .= '	<button type="button" class="btn btn-sm btn-info" title="Edit" data-toggle="modal" id="'.$value->id.'" data-target="#edit-modal" onClick="edit(this.id)"> <i class="fa fa-edit"></i></button>';
			
			if ($value->archive==0)
				$ops .= '	<button type="button" class="btn btn-sm btn-success" title="Archive" onclick="archive('. $value->id .', &#39;'. $value->title .'&#39;)"><i class="fa fa-archive"></i></button>';
			else
				$ops .= '	<button type="button" class="btn btn-sm btn-primary" title="Undo Archive" onclick="undoarchive('. $value->id .', &#39;'. $value->title .'&#39;)"><i class="fa fa-file-archive-o"></i></button>';
			
			$ops .= '	<button type="button" class="btn btn-sm btn-danger" title="Delete" onclick="remove('. $value->id .', &#39;'. $value->title .'&#39;)"><i class="fa fa-trash"></i></button>';
			$ops .= '</div>';
			
			$archive = ""; 
			
			if ($value->archive==1) $archive = " (Archived)"; 
			
			$data['data'][$key] = array(
				//$value->id,
				$i,
				$value->project,
				$value->module,
				$value->title,
				//$value->description,
				$value->status_name . $archive,
				$value->order,
				$value->date_assign,
				$value->date_due,
				$value->date_finish,
				$value->fullname,

				$ops,
				
			);
			$i++; 
		} 
		
		return $this->response->setJSON($data);		
	}
	
	public function getOne()
	{
 		$response = array();
		$id = $this->request->getPost('id');	
		$result = $this->taskModel
						->where('id', $id)
						->findAll();
		
		foreach ($result as $key => $value) {
			//echo $value->project;
			
			$result2 = $this->taskprojectModel
						->where('id', $value->project)
						->findAll();
		
			/* foreach ($result2 as $key2 => $value2) {
				$project = $value2->project_name;
			} */
			
			//echo $project;
				
			$data = array(
					'id'		=> $value->id,
					'project'	=> $value->project,
					'module'	=> $value->module,
					'title' 	=> $value->title,
					'description'=> $value->description,
					'task_status'=> $value->task_status,
					'order'		=> $value->order,
					'dateAssign'=> $value->date_assign,
					'dateDue'	=> $value->date_due,
					'dateFinish'=> $value->date_finish,
					'assigned_to'=> $value->assigned_to,
			);
		}
		return $this->response->setJSON($data);		
	}	
	
	

	public function add()
	{
        $response = array();

        $fields['id'] = $this->request->getPost('id');
        $fields['project'] = $this->request->getPost('project');
        $fields['module'] = $this->request->getPost('module');
        $fields['title'] = $this->request->getPost('title');
        $fields['description'] = $this->request->getPost('description');
        $fields['task_status'] = $this->request->getPost('task_status');
        $fields['order'] = $this->request->getPost('order');
        $fields['date_assign'] = $this->request->getPost('dateAssign');
        $fields['date_due'] = $this->request->getPost('dateDue');
        $fields['date_finish'] = $this->request->getPost('date_finish');
        $fields['assigned_to'] = $this->request->getPost('assigned_to');


        $this->validation->setRules([
            'project' => ['label' => 'Project', 'rules' => 'permit_empty|max_length[255]'],
            'module' => ['label' => 'Module', 'rules' => 'permit_empty|max_length[255]'],
            'title' => ['label' => 'Title', 'rules' => 'permit_empty|max_length[255]'],
            'description' => ['label' => 'Description', 'rules' => 'permit_empty|max_length[2000]'],
            'task_status' => ['label' => 'Task status', 'rules' => 'permit_empty|max_length[255]'],
            'order' => ['label' => 'Order', 'rules' => 'permit_empty|numeric|max_length[11]'],
            'date_assign' => ['label' => 'Date assign', 'rules' => 'permit_empty|valid_date'],
            'date_due' => ['label' => 'Date due', 'rules' => 'permit_empty|valid_date'],
            'date_finish' => ['label' => 'Date finish', 'rules' => 'permit_empty|valid_date'],
            'assigned_to' => ['label' => 'Assigned to', 'rules' => 'permit_empty|max_length[11]'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
			
        } else {

            if ($this->taskModel->insert($fields)) {
												
                $response['success'] = true;
                $response['messages'] = 'Data has been inserted successfully';	
				
            } else {
				
                $response['success'] = false;
                $response['messages'] = 'Insertion error!';
				
            }
        }
		
        return $this->response->setJSON($response);
	}

	public function edit()
	{

        $response = array();
		
        $fields['id'] = $this->request->getPost('id');
        $fields['project'] = $this->request->getPost('project');
        $fields['module'] = $this->request->getPost('module');
        $fields['title'] = $this->request->getPost('title');
        $fields['description'] = $this->request->getPost('description');
        $fields['task_status'] = $this->request->getPost('task_status');
        $fields['order'] = $this->request->getPost('order');
        $fields['date_assign'] = $this->request->getPost('dateAssign');
        $fields['date_due'] = $this->request->getPost('dateDue');
        $fields['date_finish'] = $this->request->getPost('date_finish');
        $fields['assigned_to'] = $this->request->getPost('assigned_to');
		
		if ($fields['task_status']=="3") {
			if ($fields['date_finish']=='') {
				$fields['date_finish'] = date("Y-m-d"); 
			}
		}

        $this->validation->setRules([
            'project' => ['label' => 'Project', 'rules' => 'permit_empty|max_length[255]'],
            'module' => ['label' => 'Module', 'rules' => 'permit_empty|max_length[255]'],
            'title' => ['label' => 'Title', 'rules' => 'permit_empty|max_length[255]'],
            'description' => ['label' => 'Description', 'rules' => 'permit_empty|max_length[2000]'],
            'task_status' => ['label' => 'Task status', 'rules' => 'permit_empty|max_length[255]'],
            'order' => ['label' => 'Order', 'rules' => 'permit_empty|numeric|max_length[11]'],
            'date_assign' => ['label' => 'Date assign', 'rules' => 'permit_empty|valid_date'],
            'date_due' => ['label' => 'Date due', 'rules' => 'permit_empty|valid_date'],
            'date_finish' => ['label' => 'Date finish', 'rules' => 'permit_empty|valid_date'],
            'assigned_to' => ['label' => 'Assigned to', 'rules' => 'permit_empty|max_length[11]'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
			
        } else {

            if ($this->taskModel->update($fields['id'], $fields)) {
				
                $response['success'] = true;
                $response['messages'] = 'Successfully updated';	
				
            } else {
				
                $response['success'] = false;
                $response['messages'] = 'Update error!';
				
            }
        }
		
        return $this->response->setJSON($response);
		
	}
	
	public function remove()
	{
		$response = array();
		
		$id = $this->request->getPost('id');
		
		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
			
		} else {	
		
			if ($this->taskModel->where('id', $id)->delete()) {
								
				$response['success'] = true;
				$response['messages'] = 'Deletion succeeded';	
				
			} else {
				
				$response['success'] = false;
				$response['messages'] = 'Deletion error!';
				
			}
		}	
	
        return $this->response->setJSON($response);		
	}	
	
	public function archive()
	{
		$response = array();
		
		$id = $this->request->getPost('id');
		
		if (!$this->validation->check($id, 'required|numeric')) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		} 
		else {
			
			$this->taskModel
			->whereIn('id', [$id])
			->set(['archive' => 1])
			->update();
			
			$response['success'] = true;
			$response['messages'] = 'Archive succeeded';
			
			/*try {
				$task = $this->taskModel->find($id);
				$task->archive    = 1;
				$this->taskModel->save($task);
				
				$response['success'] = true;
				$response['messages'] = 'Archive succeeded';
			} 
			catch(Exception $e) {
				$response['success'] = false;
				$response['messages'] = 'Archive error!';
			} */
		}	
	
        return $this->response->setJSON($response);		
	}	
		
	public function undoarchive()
	{
		$response = array();
		
		$id = $this->request->getPost('id');
		
		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
			
		} 
		else {
			$data = [
				'archive' => 0
			]; 
			
			if ($this->taskModel->update($id, $data)){
				$response['success'] = true;
				$response['messages'] = 'Undo archive succeeded';	
			} 
			else {
				$response['success'] = false;
				$response['messages'] = 'Undo archive error!';
			}
		}	
	
        return $this->response->setJSON($response);		
	}	
		
}	