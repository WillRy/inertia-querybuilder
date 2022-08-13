<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateSubscriptionRequest;
use App\Models\Plan;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Inertia\Inertia;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        return Inertia::render("Subscriptions/Index");
    }

    public function url(Request $request)
    {
        $plan = (new Plan())->getByID($request->input("plan"));
        $filters = [
            "searchURL" => $request->input("search"),
            "planURL" => $plan
        ];

        return Inertia::render("Subscriptions/Url", $filters);
    }

    public function list(Request $request)
    {
        try {
            $subs = (new Subscription())->searchSubscription(
                $request->input("page"),
                $request->input("search"),
                $request->input("plan")
            );

            return $this->responseJSON($subs);
        } catch (\Exception $e) {
            return $this->errorJSON($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $subs = (new Subscription())->getByID($id);

            return $this->responseJSON($subs);
        } catch (\Exception $e) {
            return $this->errorJSON($e->getMessage());
        }
    }

    public function store(StoreUpdateSubscriptionRequest $request)
    {
        try {

            $exists = (new Subscription())->subscriptionExists(
                $request->input("student_id"),
                $request->input("plan_id"),
            );

            if($exists) {
                throw new \Exception("Aluno já possui uma matrícula ativa");
            }

            $data = $request->all();

            $plan = (new Plan())->getByID($data["plan_id"]);

            $data["dt_start"] = Carbon::make($data["dt_start"])->format("Y-m-d");
            $data["dt_end"] = Carbon::make($data["dt_start"])->addMonths($plan->duration)->format("Y-m-d");

            $returnData = (new Subscription())->createSubscription($data);

            return $this->successInertia('Matrícula criada com sucesso!',null, [], $returnData);

        } catch (\Exception $e) {
            return $this->errorInertia($e->getMessage());
        }
    }

    public function update(StoreUpdateSubscriptionRequest $request, $id)
    {
        try {
            $subscription = (new Subscription())->getByID($id);

            $data = $request->all();

            $data["dt_start"] = Carbon::make($data["dt_start"])->format("Y-m-d");
            $data["dt_end"] = Carbon::make($data["dt_start"])->addMonths($subscription->plan->duration)->format("Y-m-d");

            (new Subscription())->updateSubscription($id, $data);

	        $returnData = (new Subscription())->getByID($subscription->id);

            return $this->successInertia("Matrícula editada com sucesso!",null, [], $returnData);
        } catch (\Exception $e) {
            return $this->errorInertia($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $sub = (new Subscription())->getByID($id);

            (new Subscription())->deleteByID($id);

            return $this->successInertia("Matrícula excluída com sucesso!");
        } catch (\Exception $e) {
            return $this->errorInertia($e->getMessage());
        }
    }
}
