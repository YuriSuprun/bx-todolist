<?php

// php todo.php list
// php todo.php list 2023-10-12
// php todo.php list today
// php todo.php add "Wake up"
// php todo.php add "Drink some coffee"
// php todo.php complete 1 2
// php todo.php remove 2 (rm - сокращенный вариант)

function main(array $arguments): void
{
	array_shift($arguments);
	$command = array_shift($arguments);

	switch ($command)
	{
		case 'list':
			listCommand($arguments);
			break;
		case 'add':
			addCommand($arguments);
			break;
		case 'complete':
			completeCommand($arguments);
			break;
		case 'remove':
		case 'rm':
			removeCommand($arguments);
			break;
		default:
			echo 'Unknown command';
			exit(1);
	}
	exit(0);
}

function listCommand(array $arguments)
{
	$fileName = date('Y-m-d') . '.txt';
	$filePath = __DIR__ . '/data/' . $fileName;

	if (!file_exists($filePath))
	{
		echo 'Nothing to do';
		return;
	}

	$content = file_get_contents($filePath);
	$todos = unserialize($content, [
		'allowed_classes' => false
	]);

	if (empty($todos))
	{
		echo 'Nothing to do';
		return;
	}

	foreach ($todos as $index => $todo)
	{
		echo sprintf
		(
			"%s. [%s] %s \n",
			($index + 1),
			$todo['completed'] ? 'x' : ' ',
			$todo['title']
		);
	}
}

function addCommand(array $arguments)
{

	$title = array_shift($arguments);

	$todo = [
		'id' => uniqid('', true),
		'title' => $title,
		'completed' => false
	];

	$fileName = date('Y-m-d') . '.txt';
	$filePath = __DIR__ . '/data/' . $fileName;

	if (file_exists($filePath))
	{
		$content = file_get_contents($filePath);
		$todos = unserialize($content, [
			'allowed_classes' => false
		]);
		$todos [] = $todo;
		file_put_contents($filePath, serialize($todos));
	}
	else
	{
		$todos = [ $todo ];
		file_put_contents($filePath, serialize($todos));
	}
}

function completeCommand(array $arguments)
{

}

function removeCommand(array $arguments)
{

}

main($argv);