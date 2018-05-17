<?php
if(!isset($_SESSION['username'])){ header('Location:'.URL); return; };
/**
 * //echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit(); debug sql
 */
class admin extends Controller
{


    public function index(){ 
        header('Location:'.URL.$_SESSION['role'].'/contracts');
    }

    function contracts()
    {	$operators   =  $this->model->getUsersByRole('operator');
    	$contracts=$this->model->getContracts();
        $statuses=$this->model->getStatuses();
   		require APP . 'view/admin/header.php';
        require APP . 'view/admin/contracts.php';
        require APP . 'view/admin/footer.php';
    }
    
    public function createContract(){ 
        if(isset($_POST['create_contract'])){
            $this->model->createContract();
            return;
        }
        $operators   =  $this->model->getUsersByRole('operator');
        require APP . 'view/admin/header.php';
        require APP . 'view/admin/createContract.php';
        require APP . 'view/admin/footer.php';
    }

    public function editContract($contract_id){ 
        if(isset($_POST['edit_contract'])){
            $this->model->editContract($contract_id);
            return;
        }
        $operators   =  $this->model->getUsersByRole('operator');
        $contract    =  $this->model->getContractById($contract_id);
        $statuses=$this->model->getStatuses();
        require APP . 'view/admin/header.php';
        require APP . 'view/admin/editContract.php';
        require APP . 'view/admin/footer.php';
    }

    public function viewContract($contract_id){ 
        $operators   =  $this->model->getUsersByRole('operator');
    	$contract=$this->model->getContractById($contract_id);
        require APP . 'view/admin/header.php';
        require APP . 'view/admin/viewContract.php';
        require APP . 'view/admin/footer.php';
    }

    //////////-documents-//////////////
    public function uploadDocuments(){ 
    	$this->model->uploadDocuments();
    }
    public function getDocuments($contract_id){ 
    	$this->model->getDocuments($contract_id);
    }
    public function getDocument($document_id){ 
    	$this->model->getDocument($document_id);
    }
	/////////////////////////////////

    //////////-audio-//////////////
    public function uploadAudios(){ 
    	$this->model->uploadAudios();
    }
    public function getAudios($contract_id){ 
    	$this->model->getAudios($contract_id);
    }
    public function getAudio($audio_id){ 
    	$this->model->getAudio($audio_id);
    }
	/////////////////////////////////

    public function users($showHours=false){
        if ($showHours=='workhours') {
            $users=$this->model->getUsers();
            require APP . 'view/admin/header.php';
            require APP . 'view/admin/workhours.php';
            require APP . 'view/admin/footer.php';
            return;
        }elseif(!$showHours){ 
        $users=$this->model->getUsers();
            require APP . 'view/admin/header.php';
            require APP . 'view/admin/users.php';
            require APP . 'view/admin/footer.php';
        }else header('location:'.APP);
    }

    public function viewUser($user_id){ 
        $contracts=$this->model->getContractsByUser($user_id);
        require APP . 'view/admin/header.php';
        require APP . 'view/admin/viewUser.php';
        require APP . 'view/admin/footer.php';

    }
    
    public function createUser(){ 
        if(isset($_POST['create_user'])){
            $this->model->createUser();
            return;
        }
        require APP . 'view/admin/header.php';
        require APP . 'view/admin/createUser.php';
        require APP . 'view/admin/footer.php';
    }

    public function editUser($user_id){ 
        if(isset($_POST['edit_user'])){
            $this->model->editUser($user_id);
            return;
        }
        if (isset($_GET['deleteUser'])) {
             $this->model->deleteUser($user_id);
            return;
        }
        $user=$this->model->getUser($user_id);
        require APP . 'view/admin/header.php';
        if(!isset($user->user_id)){
            echo "No user found!";
        } else {
            require APP . 'view/admin/editUser.php'; 
        }
        require APP . 'view/admin/footer.php';
    }

    public function statuses(){
            $statuses=$this->model->getStatuses();
            require APP . 'view/admin/header.php';
            require APP . 'view/admin/statuses.php';
            require APP . 'view/admin/footer.php';
    }

    public function createStatus(){ 
        if(isset($_POST['create_status'])){
            $this->model->createStatus();
            return;
        }
        require APP . 'view/admin/header.php';
        require APP . 'view/admin/createStatus.php';
        require APP . 'view/admin/footer.php';
    }

    public function editStatus($status_id){ 
        if ($status_id==1) {
            header('Location: '.URL.$_SESSION['role'].'/statuses');
            return;
        }
        if(isset($_POST['edit_status'])){
            $this->model->editStatus($status_id);
            return;
        }
        if (isset($_GET['deleteStatus'])) {
             $this->model->deleteStatus($status_id);
            return;
        }
        $status=$this->model->getStatus($status_id);
        require APP . 'view/admin/header.php';
        if(!isset($status->status_id)){
            echo "No status found!";
        } else {
            require APP . 'view/admin/editStatus.php'; 
        }
        require APP . 'view/admin/footer.php';
    }
}
