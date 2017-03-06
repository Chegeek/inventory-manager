<?php
namespace App\Controllers;

use \App\System\App;
use \App\System\FormValidator;
use \App\System\Settings;
use \App\Controllers\Controller;
use \App\Models\ReportsModel;
use \DateTime;

class ReportsController extends Controller {

    public function all() {
        $model = new ReportsModel();
        $data  = $model->all();

        $this->render('pages/admin/reports.twig', [
            'title'       => 'Reports',
            'description' => 'Reports - Just a simple inventory management system.',
            'page'        => 'reports',
            'reports'  => $data
        ]);
    }

    public function add() {
        if(!empty($_POST)) {
            $title     = isset($_POST['title']) ? $_POST['title'] : '';
            $validator = new FormValidator();
            $validator->notEmpty('title', $title, "Your title must not be empty");

            if($validator->isValid()) {
                $model = new ReportsModel();
                $file  = $model->generate();
                $model->create([
                    'title'       => $title,
                    'file'        => $file,
                    'user'        => $_SESSION['auth']
                ]);

                App::redirect('admin/reports');
            }

            else {
                $this->render('pages/admin/reports_add.twig', [
                    'title'       => 'Add report',
                    'description' => 'Reports - Just a simple inventory management system.',
                    'page'        => 'reports',
                    'errors'      => $validator->getErrors(),
                    'data'        => [
                        'title'       => $title,
                    ]
                ]);
            }
        }

        else {
            $this->render('pages/admin/reports_add.twig', [
                'title'       => 'Add report',
                'description' => 'Reports - Just a simple inventory management system.',
                'page'        => 'reports'
            ]);
        }
    }

    public function delete($id) {
        if(!empty($_POST)) {
            $model = new ReportsModel();
            $file  = $model->find($id)->file;
            unlink(__DIR__ . '/../../public/uploads/' . $file);
            $model->delete($id);

            App::redirect('admin/reports');
        }

        else {
            $model = new ReportsModel();
            $data = $model->find($id);
            $this->render('pages/admin/reports_delete.twig', [
                'title'       => 'Delete report',
                'description' => 'Reports - Just a simple inventory management system.',
                'page'        => 'reports',
                'data'        => $data
            ]);
        }
    }

}
