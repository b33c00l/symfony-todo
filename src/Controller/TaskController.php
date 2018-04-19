<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Form\TaskType;

class TaskController extends Controller
{	

	private $entityManager;
	private $taskRepository;

	public function __construct(
		EntityManagerInterface $entityManager,
		TaskRepository $taskRepository
	)

	{
		$this->entityManager = $entityManager;
		$this->taskRepository = $taskRepository;
	}

    /**
     * @Route("/task", name="task")
     */
    public function index()
    {	
    	$tasks = $this->taskRepository->findAll();
        return $this->render('task/index.html.twig', [
            'tasks' => $tasks
        ]);
    }

    /**
     * @Route("/task/create", name="task.create")
     */
    public function create(Request $request)
    {	
    	$task = new Task();
		$form = $this->createForm(TaskType::class, $task);    	

    	$form->handleRequest($request);

    	if ($form->isSubmitted() && $form->isValid())
    	{
    		$data = $form->getData();

    		$data->setCreatedAt(new \DateTime());

    		$this->entityManager->persist($data);
    		$this->entityManager->flush();

    		return $this->redirect('/task');

    	}

    	return $this->render('task/create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

   	/**
     * @Route("/task/{id}/edit", name="task.edit")
     */
    public function edit(Request $request, $id)
    {	
    	$task = $this->taskRepository->find($id);

    	if ($task == null)
    	{
    		throw $this->createNotFoundException("Task # $id does not exist");
    	}

    	$form = $this->createForm(TaskType::class, $task);

    	$form->handleRequest($request);

    	if ($form->isSubmitted())
    	{
    		$data = $form->getData();

    		$this->entityManager->persist($data);
    		$this->entityManager->flush();

    		return $this->redirect('/task');

    	}
    	return $this->render('task/create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/task/{id}/delete", name="task.delete")
     */
    public function delete($id)
    {
        $task = $this->taskRepository->find($id);
        $this->entityManager->remove($task);
        $this->entityManager->flush();

        return $this->redirect('/task');
    }
    
}
