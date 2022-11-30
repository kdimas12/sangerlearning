<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CoursesModel;
use App\Models\PendaftaranKelasModel;
use App\Models\UserModel;

class Courses extends BaseController
{
	protected $coursesModel;

	public function __construct()
	{
		$this->coursesModel = new CoursesModel();
		$this->pendaftaranKelasModel = new PendaftaranKelasModel();
		$this->userModel = new UserModel();
	}

	public function index()
	{
		$dataCourses = $this->coursesModel->findAll();

		function group_by($key, $data)
		{
			$result = array();
			foreach ($data as $val) {
				if (array_key_exists($key, $val)) {
					$result[$val[$key]][] = $val;
				} else {
					$result[""][] = $val;
				}
			}
			return $result;
		}
		$result = group_by("id_jenis", $dataCourses);

		$data = array(
			'title' => 'Courses',
			'courses' => $result,
		);

		return view('courses', $data);
	}
}
