<?php

namespace Clarion\Http\Controllers;

use Illuminate\Http\Request;

use Clarion\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Clarion\Http\Requests\MessengerCreateRequest;
use Clarion\Http\Requests\MessengerUpdateRequest;
use Clarion\Domain\Contracts\MessengerRepository;
use Clarion\Domain\Validators\MessengerValidator;

/**
 * Class MessengersController.
 *
 * @package namespace Clarion\Http\Controllers;
 */
class MessengersController extends Controller
{
    /**
     * @var MessengerRepository
     */
    protected $repository;

    /**
     * @var MessengerValidator
     */
    protected $validator;

    /**
     * MessengersController constructor.
     *
     * @param MessengerRepository $repository
     * @param MessengerValidator $validator
     */
    public function __construct(MessengerRepository $repository, MessengerValidator $validator)
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
        $messengers = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $messengers,
            ]);
        }

        return view('messengers.index', compact('messengers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MessengerCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MessengerCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $messenger = $this->repository->create($request->all());

            $response = [
                'message' => 'Messenger created.',
                'data'    => $messenger->toArray(),
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
        $messenger = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $messenger,
            ]);
        }

        return view('messengers.show', compact('messenger'));
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
        $messenger = $this->repository->find($id);

        return view('messengers.edit', compact('messenger'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MessengerUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MessengerUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $messenger = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Messenger updated.',
                'data'    => $messenger->toArray(),
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
                'message' => 'Messenger deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Messenger deleted.');
    }
}
