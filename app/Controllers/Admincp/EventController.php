<?php

namespace App\Controllers\Admincp;

use App\Repositories\EventCategoryRepository;
use App\Repositories\EventRepository;

class EventController extends AdmincpController
{
    public function __construct(EventCategoryRepository $categoryRepository, EventRepository $eventRepository)
    {
        parent::__construct();
        $this->activePage('event');
        $this->categoryRepository = $categoryRepository;
        $this->eventRepository = $eventRepository;
    }

    public function index()
    {
        return $this->theme->view('events.list', ['events' => $this->eventRepository->lists(null, 20, \Input::get('term'))])->render();
    }

    public function editEvent($id)
    {
        $event = $this->eventRepository->get($id);

        $message = null;

        if ($val = \Input::get('val')) {
            $this->eventRepository->adminEdit($val, $event);
            $message = "Saved successfully";
        }
        return $this->theme->view('events.edit', ['event' => $page, 'message' => $message])->render();
    }

    public function categories()
    {
       return  $this->theme->view('events.categories', ['categories' => $this->categoryRepository->lists()])->render();
    }

    public function createCategory()
    {
        $this->setTitle('Create Event Category');
        $message = null;
        if ($val = \Input::get('val')) {
            $category = $this->categoryRepository->add($val);
            if($category) {
                $message = "Category added successfully";
            } else {
                $message = "Failed to add category due to existence or invalid details";
            }
        }
        return $this->theme->view('events.create-category', ['message' => $message])->render();
    }

    public function editCategory($id)
    {
        $this->setTitle('Edit Event Category');
        $category = $this->categoryRepository->get($id);

        if (!$category) return \Redirect::to(\URL::previous());

        $message = null;

        if ($val = \Input::get('val')) {
            $s = $this->categoryRepository->save($val, $category);
            if($s) {
                $message = "Category save successfully";
            } else {
                $message = "Failed to add category due to existence or invalid details";
            }
        }
        return $this->theme->view('pages.edit-category', ['message' => $message, 'category' => $category])->render();

    }

    public function deleteCategory($id)
    {
        $this->categoryRepository->delete($id);
        return \Redirect::to(\URL::previous());
    }
}
