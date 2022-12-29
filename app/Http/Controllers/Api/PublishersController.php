<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PublishersRequest;
use App\Http\Requests\PublisherStoreRequest;
use App\Http\Requests\PublisherUpdateRequest;
use App\Http\Requests\StandRequest;
use App\Models\StandTemplate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class PublishersController extends Controller
{
    public function index(PublishersRequest $request): JsonResource
    {
        $users = User::query()->where('congregation_id', $request->congregationId)->get();

        return JsonResource::collection($users);
    }

    public function store(PublisherStoreRequest $request): JsonResource
    {
        $user = User::query()->create([
            'name' => $request->name,
            'prename' => $request->prename,
            'email' => $request->email,
            'congregation_id' => $request->congregationId,
            'password' => Hash::make($request->password),
        ]);

        return new JsonResource($user);
    }

    public function update(PublisherUpdateRequest $request, int $id): JsonResource
    {
        $user = User::query()->findOrFail($id);

        $update = [];

        if ($request->congregationId) {
            $update['congregation_id'] = $request->congregationId;
        }

        if ($request->name) {
            $update['name'] = $request->name;
        }

        if ($request->prename) {
            $update['prename'] = $request->prename;
        }

        if ($request->email) {
            $update['email'] = $request->email;
        }

        if ($request->password) {
            $update['password'] = Hash::make($request->password);
        }

        $user->update($update);

        return new JsonResource($user);
    }

    public function destroy(int $id): JsonResponse
    {
        User::destroy($id);

        return Response::json(['message' => 'Publisher was deleted.']);
    }
}
