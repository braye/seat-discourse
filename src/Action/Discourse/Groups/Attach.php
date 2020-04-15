<?php
/**
 * Created by PhpStorm.
 * User: fehu
 * Date: 05.06.18
 * Time: 18:01.
 */

namespace Herpaderpaldent\Seat\SeatDiscourse\Action\Discourse\Groups;

use Exception;
use Illuminate\Support\Collection;
use Herpaderpaldent\Seat\SeatDiscourse\Helpers\DiscourseGroupNameHelper;

class Attach
{
    protected $create;

    public function __construct(Create $create)
    {
        $this->create = $create;
    }

    public function execute(Collection $roles, Collection $groups)
    {
        try{
            $feedback = collect();

            $groupnames_array = $groups->map(function ($group) {return DiscourseGroupNameHelper::format($group->name); })->toArray();

            $roles->each(function ($role) use ($feedback, $groupnames_array) {
                if(! in_array(DiscourseGroupNameHelper::format($role->title), $groupnames_array)){
                    $feedback->push($this->create->execute(DiscourseGroupNameHelper::format($role->title)));
                }
            });

            return $feedback;

        } catch (Exception $e){

            report($e);
            throw $e;
        }

    }
}
