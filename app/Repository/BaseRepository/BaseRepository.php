<?php 
	namespace App\Repository\BaseRepository;
	interface BaseRepositoryInterface
	{
		public function getAll();
		public function getDetail($id);
		public function create($data);
		public function update($id, $data);
		public function delete($id);

	}
?>