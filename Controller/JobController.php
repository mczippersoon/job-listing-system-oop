<?php
require_once '../Database/Dbconnection.php';
require_once '../models/Job.php';

class JobController
{
    private $job;
    private $userRole;
    private $userId;

    public function __construct()
    {
        session_start();
        $db = new DbConnection();
        $this->job = new Job($db->connect());
        $this->userRole = $_SESSION['role'] ?? null;
        $this->userId = $_SESSION['user_id'] ?? null;
    }

    public function handleRequest($action)
    {
        switch ($action) {
            case 'add':
                $this->addJob();
                break;
            case 'edit':
                $this->editJob();
                break;
            case 'update':
                $this->updateJob();
                break;
            case 'delete':
                $this->deleteJob();
                break;
            default:
                $this->viewJobs();
                break;
        }
    }

    private function addJob()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $this->job->add($title, $description, $this->userId);
            header('Location: jobs.php');
        } else {
            include '../html/add_job_form.php';
        }
    }

    private function editJob()
    {
        $id = $_GET['id'];
        $job = $this->job->getById($id);

        if ($this->userRole === 'admin' || $job['user_id'] == $this->userId) {
            include '../html/edit_job_form.php';
        } else {
            echo "Unauthorized";
        }
    }

    private function updateJob()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];

            $job = $this->job->getById($id);
            if ($this->userRole === 'admin' || $job['user_id'] == $this->userId) {
                $this->job->update($id, $title, $description);
                header('Location: jobs.php');
            } else {
                echo "Unauthorized";
            }
        }
    }

    private function deleteJob()
    {
        $id = $_GET['id'];
        $job = $this->job->getById($id);

        if ($this->userRole === 'admin' || $job['user_id'] == $this->userId) {
            $this->job->delete($id);
            header('Location: jobs.php');
        } else {
            echo "Unauthorized";
        }
    }

    private function viewJobs()
    {
        if ($this->userRole === 'admin') {
            $jobs = $this->job->getAll();
        } else {
            $jobs = $this->job->getByUserId($this->userId);
        }
        include '../html/jobs_list.php';
    }
}

?>
