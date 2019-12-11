<?php
namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\JobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
* @Route("v1/job", name="api_job_")
*/
class ApiJobController extends AbstractController
{
    /**
     * @Route("/category/list", name="category")
     */
    public function categoryList(CategoryRepository $categoryRepository)
    {
        return $this->json($categoryRepository->findAll(), 200, [],['groups' => 'category_search']);
    }

    /**
     * @Route("/list", name="job")
     */
    public function jobListFromCategory(Request $request, JobRepository $jobRepository)
    {
        $jobList = $jobRepository->findFromCategory($request->get('categoryId'));
        return $this->json($jobList, 200, [],['groups' => 'job_search']);
    }
}