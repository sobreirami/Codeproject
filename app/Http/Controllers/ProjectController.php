<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ProjectController extends Controller
{

    /**
     * @var ProjectRepository
     */
    private $repository;

    /**
     * @var ProjectService
     */
    private $service;

    public function __construct(ProjectRepository $repository, ProjectService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return  $this->repository->with(['owner', 'client', 'notes', 'tasks', 'members'])->findWhere(['owner_id' => \Authorizer::getResourceOwnerId()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        if($this->checkProjectPermissions($id) == false)
        {
            return ['error' => true,
                'message' => 'Access forbidden'];
        }

        return $this->service->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        if($this->checkProjectPermissions($id) == false)
        {
            return ['error' => true,
                'message' => 'Access forbidden'];
        }

        return $this->service->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        if($this->checkProjectPermissions($id) == false)
        {
            return ['error' => true,
                'message' => 'Access forbidden'];
        }

        return $this->service->delete($id);
    }

    public function addMember(Request $request)
    {
        return $this->service->addMember($request->all());
    }

    public function removeMember($id, $id_user)
    {
        return $this->service->removeMember($id, $id_user);
    }

    public function Member($id)
    {
        return $this->service->allMember($id);
    }

    public function isMember($id, $id_user)
    {
        return $this->service->isMember($id, $id_user);
    }

    private function checkProjectOwner($projectId)
    {
        $userId = \Authorizer::getResourceOwnerId();

        return $this->repository->isOwner($projectId, $userId);
    }

    private function checkProjectMember($projectId)
    {
        $userId = \Authorizer::getResourceOwnerId();

        return $this->repository->hasMember($projectId, $userId);
    }

    private function checkProjectPermissions($projectId)
    {
       if($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId))
       {
           return true;
       }

        return false;
    }

}
