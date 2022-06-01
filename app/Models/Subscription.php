<?php

namespace App\Models;

use App\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Subscription extends Model
{
    use HasFactory;

    protected $table = "subscriptions";

    protected $primaryKey = "id";

    protected $fillable = [
        "student_id",
        "plan_id",
        "dt_start",
        "dt_end"
    ];

    public function subscriptionExists($student_id, $plan_id)
    {
        return DB::table("subscriptions AS s")
            ->join("plans AS p","p.id","=","s.plan_id")
            ->join("students AS st","st.id","=","s.student_id")
            ->where([
                "p.id" => $plan_id,
                "st.id" => $student_id,
                "st.tenant_id" => Auth::user()->tenant_id
            ])->exists();
    }

    public function subscriptionUsedByPlan($plan_id)
    {
        return DB::table("subscriptions AS s")
            ->join("plans AS p","p.id","=","s.plan_id")
            ->where([
                "p.id" => $plan_id,
                "p.tenant_id" => Auth::user()->tenant_id
            ])->exists();
    }

    public function getByID($id)
    {
        $subscriptions = DB::table("subscriptions AS s")
            ->where("id","=", $id)
            ->whereExists(function ($q) {
                $q->from("students as st")
                    ->where("st.tenant_id","=",Auth::user()->tenant_id)
                    ->whereColumn("s.student_id","=","st.id");
            })
            ->first();

        if(empty($subscriptions)) return null;

        $subscriptions->student = DB::table("students")->where("id","=", $subscriptions->student_id)->first();
        $subscriptions->plan = DB::table("plans")->where("id","=", $subscriptions->plan_id)->first();

        return $subscriptions;
    }

    public function deleteByID($id)
    {
        return DB::table("subscriptions AS s")
            ->join("plans AS p","p.id","=","s.plan_id")
            ->where([
                "s.id" => $id
            ])->delete();
    }

    public function createSubscription(array $data)
    {
        $data["tenant_id"] = Auth::user()->tenant_id;
        DB::table("subscriptions")->insert($data);
        return $this->getByID(DB::getPdo()->lastInsertId());
    }

    public function updateSubscription(int $id, array $data)
    {
        DB::table("subscriptions")->where([
            "id" => $id
        ])->update([
            'plan_id' => $data["plan_id"],
            'dt_start' => $data["dt_start"],
            'dt_end' => $data["dt_end"],
        ]);
        return $this->getByID($id);
    }


    public function searchSubscription($page = 1, $search = null, $plan = null)
    {
        $offset = ($page - 1) * 10;

        $query = DB::query()
            ->select(
                "s.*",
                "p.id as plan_id",
                "p.name as plan",
                "p.price",
                "p.duration",
                "st.id as student_id",
                "st.name as student",
                "st.email as email",
                "st.date_birth",
                "st.weight",
                "st.height",
                "st.gender",
            )
            ->fromSub(function ($query) use($offset) {
                $query->from("subscriptions AS s")
                    ->orderBy("id","DESC")
                    ->offset($offset)
                    ->limit(10);
            }, "s")
            ->join("plans AS p","p.id","=","s.plan_id")
            ->join("students AS st","st.id","=","s.student_id");

        if(!empty($search)) {
            $query->whereRaw("st.name LIKE ? ", ["%$search%"]);
        }
        if(!empty($plan)) {
            $query->where("p.id",'=', $plan);
        }

        $query->where("st.tenant_id","=", Auth::user()->tenant_id);

        $resultado = $query->orderBy("id","DESC")->get();

        $result = [];
        foreach ($resultado as $item) {
            $result[$item->id]["id"] = $item->id;
            $result[$item->id]["student_id"] = $item->student_id;
            $result[$item->id]["plan_id"] = $item->plan_id;
            $result[$item->id]["dt_start"] = $item->dt_start;
            $result[$item->id]["dt_end"] = $item->dt_end;


            if ($item->plan_id) {
                $result[$item->id]["plan"] = [
                    "id" => $item->plan_id,
                    "name" => $item->plan,
                    "price" => $item->price,
                    "duration" => $item->duration,
                ];
            }

            if ($item->student) {
                $result[$item->id]["student"] = [
                    "id" => $item->student_id,
                    "name" => $item->student,
                    "email" => $item->email,
                    "date_birth" => $item->duration,
                    "weight" => $item->duration,
                    "height" => $item->height,
                    "gender" => $item->gender,
                ];
            }
        }

        Helper::clean($result, []);

        $final["current_page"] = $page;
        $final["total"] = $this->searchSubscriptionCount($search, $plan);
        $final["per_page"] = 10;
        $final["last_page"] = ceil($final["total"] / 10);

        $final["data"] = $result;

        return $final;
    }

    public function searchSubscriptionCount($search,  $plan = null)
    {

        $query = DB::query()
            ->fromSub(function ($query){
                $query->from("subscriptions AS s");
            }, "s")
            ->join("plans AS p","p.id","=","s.plan_id")
            ->join("students AS st","st.id","=","s.student_id");

        if(!empty($search)) {
            $query->whereRaw("st.name LIKE ? ", ["%$search%"]);
        }
        if(!empty($plan)) {
            $query->where("p.id",'=', $plan);
        }

        $query->where("st.tenant_id","=", Auth::user()->tenant_id);

        return $query->count();
    }
}
