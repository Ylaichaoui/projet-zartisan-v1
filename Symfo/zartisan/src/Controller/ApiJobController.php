<?php
namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\JobRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
* @Route("v1/job", name="api_job_")/v1/job/category/list
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
     * @Route("/category/listV2", name="categoryV2")
     */
    public function categoryListV2(UserRepository $userRepository, JobRepository $jobRepository, Request $request)
    {
        $jobs = $userRepository->findByRegion($request->get('region'));
        if($jobs != NULL){
            foreach($jobs as $job){
                $jobData[] = $job[1];
            }
            $jobs = [];
            foreach($jobData as $job){
                $jobs[] = $jobRepository->find($job);
            }
            return $this->json($jobs , 200, [],['groups' => 'job_search']);
        }
        return $this->json($jobs, 200);
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
