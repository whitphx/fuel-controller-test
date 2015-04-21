<?php
class Controller_Admin_Entity extends Controller_Admin
{

	public function action_index()
	{
		$data['entities'] = Model_Entity::find('all');
		$this->template->title = "Entities";
		$this->template->content = View::forge('admin/entity/index', $data);

	}

	public function action_view($id = null)
	{
		$data['entity'] = Model_Entity::find($id);

		$this->template->title = "Entity";
		$this->template->content = View::forge('admin/entity/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Entity::validate('create');

			if ($val->run())
			{
				$entity = Model_Entity::forge(array(
					'name' => Input::post('name'),
				));

				if ($entity and $entity->save())
				{
					Session::set_flash('success', e('Added entity #'.$entity->id.'.'));

					Response::redirect('admin/entity');
				}

				else
				{
					Session::set_flash('error', e('Could not save entity.'));
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Entities";
		$this->template->content = View::forge('admin/entity/create');

	}

	public function action_edit($id = null)
	{
		$entity = Model_Entity::find($id);
		$val = Model_Entity::validate('edit');

		if ($val->run())
		{
			$entity->name = Input::post('name');

			if ($entity->save())
			{
				Session::set_flash('success', e('Updated entity #' . $id));

				Response::redirect('admin/entity');
			}

			else
			{
				Session::set_flash('error', e('Could not update entity #' . $id));
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$entity->name = $val->validated('name');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('entity', $entity, false);
		}

		$this->template->title = "Entities";
		$this->template->content = View::forge('admin/entity/edit');

	}

	public function action_delete($id = null)
	{
		if ($entity = Model_Entity::find($id))
		{
			$entity->delete();

			Session::set_flash('success', e('Deleted entity #'.$id));
		}

		else
		{
			Session::set_flash('error', e('Could not delete entity #'.$id));
		}

		Response::redirect('admin/entity');

	}

}
