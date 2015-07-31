<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ClientRepository;
use CodeProject\Http\Requests;

class ClientController extends Controller
{

    private $repository;

    public function __construct(ClientRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return  $this->repository->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\ClientRequest  $request
     * @return Response
     */
    public function store(Requests\ClientRequest $request)
    {
        return $this->repository->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\ClientRequest  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Requests\ClientRequest $request, $id)
    {
        $this->repository->find($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->repository->find($id)->delete();
    }
}
