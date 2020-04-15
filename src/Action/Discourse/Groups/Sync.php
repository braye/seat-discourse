<?php
/**
 * Created by PhpStorm.
 *  * User: Herpaderp Aldent
 * Date: 09.06.2018
 * Time: 10:48.
 */

namespace Herpaderpaldent\Seat\SeatDiscourse\Action\Discourse\Groups;

use Seat\Web\Models\Acl\Role;
use Herpaderpaldent\Seat\SeatDiscourse\Helpers\DiscourseGroupNameHelper;

class Sync
{
    protected $attach;
    protected $detach;
    protected $get;

    public function __construct(Attach $attach, Detach $detach, Get $get)
    {
        $this->attach = $attach;
        $this->detach = $detach;
        $this->get = $get;
    }

    public function execute()
    {
        $roles = Role::all();
        $groups = $this->get->execute();

        $feedback = collect();

        if($roles->map(function ($role) {return DiscourseGroupNameHelper::format($role->title); })->diff($groups->map(function ($group) {return DiscourseGroupNameHelper::format($group->name); }))->isNotEmpty())
        {
            $feedback->push($this->attach->execute($roles, $groups));
        }

        if($groups->map(function ($group) {return DiscourseGroupNameHelper::format($group->name); })->diff($roles->map(function ($role) {return DiscourseGroupNameHelper::format($role->title); }))->isNotEmpty()){
            $feedback->push($this->detach->execute($roles, $groups));
        }

        return $feedback;
    }
}
