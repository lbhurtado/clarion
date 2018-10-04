<?php

namespace Clarion\Http\Controllers;

use Illuminate\Http\Request;

use Clarion\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Clarion\Http\Requests\FlashCreateRequest;
use Clarion\Http\Requests\FlashUpdateRequest;
use Clarion\Domain\Contracts\FlashRepository;
use Clarion\Domain\Validators\FlashValidator;

/**
 * Class FlashesController.
 *
 * @package namespace Clarion\Http\Controllers;
 */
class FlashesController extends Controller
{
    /**
     * @var FlashRepository
     */
    protected $repository;

    /**
     * @var FlashValidator
     */
    protected $validator;

    /**
     * FlashesController constructor.
     *
     * @param FlashRepository $repository
     * @param FlashValidator $validator
     */
    public function __construct(FlashRepository $repository, FlashValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $flashes = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $flashes,
            ]);
        }

        return view('flashes.index', compact('flashes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FlashCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(FlashCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $flash = $this->repository->create($request->all());

            $response = [
                'message' => 'Flash created.',
                'data'    => $flash->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $flash = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $flash,
            ]);
        }

        return view('flashes.show', compact('flash'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $flash = $this->repository->find($id);

        return view('flashes.edit', compact('flash'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FlashUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(FlashUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $flash = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Flash updated.',
                'data'    => $flash->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Flash deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Flash deleted.');
    }
}
