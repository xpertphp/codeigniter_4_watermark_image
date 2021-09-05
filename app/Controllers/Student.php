<?php 

namespace App\Controllers;
 
use CodeIgniter\Controller;
use App\Models\StudentModel;
 
class Student extends Controller
{
 
	public function __construct()
    {
       helper(['form', 'url']); 
    }
    public function index()
    {   
		return view('add');
    }    
	public function store()
    { 
		$rules = [
			'image' => [
				'uploaded[image]',
                'mime_in[image,image/jpg,image/jpeg,image/gif,image/png]',
                'max_size[image,4096]',
			 ],
		];
         
        if (!$rules) {
           return view('add', ['validation' => $this->validator]);
        } else {
			$imageFile = $this->request->getFile('image');
             // Image manipulation
            $image = \Config\Services::image()
                ->withFile($imageFile)
                ->text('Copyright XpertPhp.com @2021', [
                    'color'      => '#fff',
                    'opacity'    => 0.7,
                    'withShadow' => true,
                    'hAlign'     => 'center',
                    'vAlign'     => 'bottom',
                    'fontSize'   => 20
                ])
                ->save(FCPATH .'/images/'. $imageFile->getRandomName());
 
            $imageFile->move(WRITEPATH . 'uploads');
		  
			$data = [
				'image'  => $imageFile->getName(),
			];
			 
			$model = new StudentModel(); 
			$save = $model->insert($data);
			return redirect()->to( base_url('student') );
        }	
    }
}
?>