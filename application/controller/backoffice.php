<?php
if(!isset($_SESSION['username'])){ header('Location:'.URL); return; };
if($_SESSION['role']!='backoffice') { header('Location:'.URL); return; };
/**
 * //echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit(); debug sql
 */
class backoffice extends Controller
{


    public function index(){ 
        header('Location:'.URL.$_SESSION['role'].'/contracts');
    }

    function contracts(){   
        if (isset($_GET['export'])){
            if ($_GET['export']==true) {
                $this->model->getContracts('export');
                return;
            }
        }
        $operatorsAll=$this->model->getUsersByRoleAll('operator');
        $operators=$this->model->getUsersByRole('operator');
        $supervisors=$this->model->getUsersByRole('supervisor');
        $output=$this->model->getContracts();
        $contracts=$output[1];
        $pages=ceil($output[0]/100);
        $cnt_nr=$output[2];
        $campaigns=$this->model->getCampaigns();
        $statuses=$this->model->getStatuses();
        require APP . 'view/backoffice/header.php';
        require APP . 'view/backoffice/contracts.php';
        require APP . 'view/backoffice/footer.php';
    }
    
    public function createContract(){ 
        if(isset($_POST['create_contract'])){
            $this->model->createContract();
            return;
        }
        $operators   =  $this->model->getUsersByRole('operator');
        $supervisors   =  $this->model->getUsersByRole('supervisor');
        $campaigns=$this->model->getCampaigns();
        require APP . 'view/backoffice/header.php';
        require APP . 'view/backoffice/createContract.php';
        require APP . 'view/backoffice/footer.php';
    }

    public function editContract($contract_id){ 
        if(isset($_POST['edit_contract'])){
            $this->model->editContract($contract_id);
            return;
        }
        $operatorsAll=$this->model->getUsersByRoleAll('operator');
        $operators   =  $this->model->getUsersByRole('operator');
        $supervisors =  $this->model->getUsersByRole('supervisor');
        $contract    =  $this->model->getContractById($contract_id);
        $statuses=$this->model->getStatuses();
        $campaigns=$this->model->getCampaigns();

        if ($contract->status_id==2) {
            echo 'Not permited!';
            return; 
        }
        require APP . 'view/backoffice/header.php';
        require APP . 'view/backoffice/editContract.php';
        require APP . 'view/backoffice/footer.php';
    }

    public function viewContract($contract_id){ 
        //if (!isset($_SESSION['edit_contract'])) {
            $this->model->countOpenContract($contract_id);
        //}
        $operatorsAll=  $this->model->getUsersByRoleAll('operator');
        $operators   =  $this->model->getUsersByRole('operator');
        $supervisors =  $this->model->getUsersByRole('supervisor');
        $contract    =  $this->model->getContractById($contract_id);
        $changelog   =  $this->model->getChangelog($contract_id);
        $statuses=$this->model->getStatuses();
        $campaigns=$this->model->getCampaigns();
        require APP . 'view/backoffice/header.php';
        require APP . 'view/backoffice/viewContract.php';
        require APP . 'view/backoffice/footer.php';
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

    public function users($showHours=false,$date=null){
        if ($showHours=='workhours') {
            $users=$this->model->getUsers();
            require APP . 'view/backoffice/header.php';
            require APP . 'view/backoffice/workhours.php';
            require APP . 'view/backoffice/footer.php';
            return;
        }elseif(!$showHours){ 
            $users=$this->model->getUsers();
            require APP . 'view/backoffice/header.php';
            require APP . 'view/backoffice/users.php';
            require APP . 'view/backoffice/footer.php';
        }else header('location:'.APP);
    }

    public function viewUser($user_id){ 
        $contracts=$this->model->getContractsByUser($user_id);
        require APP . 'view/backoffice/header.php';
        require APP . 'view/backoffice/viewUser.php';
        require APP . 'view/backoffice/footer.php';

    }
    
    public function createUser(){ 
        if(isset($_POST['create_user'])){
            $this->model->createUser();
            return;
        }
        require APP . 'view/backoffice/header.php';
        require APP . 'view/backoffice/createUser.php';
        require APP . 'view/backoffice/footer.php';
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
        $supervisors   =  $this->model->getUsersByRole('supervisor');
        require APP . 'view/backoffice/header.php';
        if(!isset($user->user_id)){
            echo "No user found!";
        } else {
            require APP . 'view/backoffice/editUser.php'; 
        }
        require APP . 'view/backoffice/footer.php';
    }
////////////////////////////////////////////////////////

    public function statuses(){
            $statuses=$this->model->getStatuses();
            require APP . 'view/backoffice/header.php';
            require APP . 'view/backoffice/statuses.php';
            require APP . 'view/backoffice/footer.php';
    }

    public function createStatus(){ 
        if(isset($_POST['create_status'])){
            $this->model->createStatus();
            return;
        }
        require APP . 'view/backoffice/header.php';
        require APP . 'view/backoffice/createStatus.php';
        require APP . 'view/backoffice/footer.php';
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
        require APP . 'view/backoffice/header.php';
        if(!isset($status->status_id)){
            echo "No status found!";
        } else {
            require APP . 'view/backoffice/editStatus.php'; 
        }
        require APP . 'view/backoffice/footer.php';
    }
//////////////////////////////////////////////////////////////

    public function campaigns(){
            $campaigns=$this->model->getCampaigns();
            require APP . 'view/backoffice/header.php';
            require APP . 'view/backoffice/campaigns.php';
            require APP . 'view/backoffice/footer.php';
    }

    public function createCampaign(){ 
        if(isset($_POST['create_campaign'])){
            $this->model->createCampaign();
            return;
        }
        require APP . 'view/backoffice/header.php';
        require APP . 'view/backoffice/createCampaign.php';
        require APP . 'view/backoffice/footer.php';
    }

    public function editCampaign($campaign_id){ 
        if ($campaign_id==1) {
            header('Location: '.URL.$_SESSION['role'].'/campaigns');
            return;
        }
        if(isset($_POST['edit_campaign'])){
            $this->model->editCampaign($campaign_id);
            return;
        }
        if (isset($_GET['deleteCampaign'])) {
             $this->model->deleteCampaign($campaign_id);
            return;
        }
        $campaign=$this->model->getCampaign($campaign_id);
        require APP . 'view/backoffice/header.php';
        if(!isset($campaign->campaign_id)){
            echo "No campaign found!";
        } else {
            require APP . 'view/backoffice/editCampaign.php'; 
        }
        require APP . 'view/backoffice/footer.php';
    }
//////////////////////////////////////////////////////////////
}
