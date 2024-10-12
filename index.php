<?php

/*
Ecommerce

- Users
 - email
 - name

- Categories
 - title

- Items
 - user_id
 - category_id
 - title

- Blogs
 - user_id
 - title
*/

class Ecommerce {
	public $records = [];

	public function create(array $attributes) 
	{
		$id = (count($this->records) + 1);

		$attributes['id'] = $id;
		$this->records[] = $attributes;
	}

	public function show(array $attributes) 
	{
		foreach($this->records as $record) {
			foreach($attributes as $attKey => $attValue) {
				if(isset($record[$attKey]) && $record[$attKey] == $attValue) {
					return $record;
				}
			}
			
		}
	}

	public function update($id, array $attributes) 
	{
		foreach($this->records as $key => $record) {

			if($record['id'] == $id) {
				foreach($attributes as $attKey => $attValue) {
					if(isset($record[$attKey])) {
						$this->records[$key][$attKey] = $attValue;
					}
				}
			}
		}
	}

	public function delete($id) 
	{
		foreach($this->records as $key => $record) {

			if($record['id'] == $id) {
				unset($this->records[$key]);
			}
		}
	}
}

class User extends Ecommerce {

}

class Category extends Ecommerce {

}

class Item extends Ecommerce {

	public function getInfo(User $user, Category $category, $itemId) 
	{

			$item = $this->show(['id' => $itemId]);

			// print_r($category);die;

			$userInfo = $user->show([
				'id' => $item['user_id']
			]);

			$categoryInfo = $category->show([
				'id' => $item['category_id']
			]);

			return [
				'user' => $userInfo['name'],
				'category' => $categoryInfo['name'],
				'item' => $item['name']
			];


		/*
		[
			'user' => 'Ross Van Tinapao'
			'category' => 'Shoes',
			'item' => 'Jordan'
		]
		*/


	}

}


$user = new User;
$user->create([
	'email' => 'jcruz@gmail.com',
	'name' => 'Juan Dela Cruz'
]);
$user->create([
	'email' => 'jdoe@gmail.com',
	'name' => 'John Doe'
]);
$user->create([
	'email' => 'rvt@gmail.com',
	'name' => 'Ross Van Tinapao'
]);
print_r($user); 

// $user->show([
// 	'name' => 'Juan Dela Cruz'
// ]);

$user->update(2, [
	'email' => 'jdoe123@gmail.com',
	'name' => 'John Doe Updated',
	'name2' => 'John Doe Updated'
]);

print_r($user);


$user->delete(2);
print_r($user);


$category = new Category;
$category->create([
	'name' => 'Bags'
]);
$category->create([
	'name' => 'Shoes'
]);
$category->create([
	'name' => 'Tshirts'
]);

print_r($category);

/*
- Items
 - user_id
 - category_id
 - name
*/

$item = new Item;

$userInfo = $user->show([
	'id' => 3
]);

$categoryInfo = $category->show([
	'name' => 'Shoes'
]);


if(!empty($userInfo)) {
	$item->create([
	 	'user_id' => $userInfo['id'],
	 	'category_id' => $categoryInfo['id'],
	 	'name' => 'Jordan'
	]);

	$item->create([
	 	'user_id' => $userInfo['id'],
	 	'category_id' => $categoryInfo['id'],
	 	'name' => 'Jordan 123'
	]);
}

print_r($item);

$itemInfo = $item->getInfo($user, $category, 2);


print_r($itemInfo);