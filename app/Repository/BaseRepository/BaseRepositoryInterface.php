<?php
	namespace App\Repository\BaseRepository;

	use BaseRepositoryInterface;
	use Illuminate\Database\Eloquent\Model;
	class BaseRepository implements BaseRepositoryInterface
	{
		protected $model;
		public function __construct(Model $model){
			$this->model = $model;
		}
		public function getAll(){
			return $this->model->all();
		}
		public function getDetail($id)
		{
			return $this->model->where('id', $id)->get();
		}
		public function create(){
			return $this->model->create($data);
		}
		public function update($id, $data)
		{
			$model = $this->getDetail($id);
			$model->update($data);
		}
		public function delete($id)
		{
			$this->model->withTrashed()->where('id', $id)->get();
		}
	}
?>