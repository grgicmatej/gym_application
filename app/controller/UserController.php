<?php


class UserController
{
    public function viewUser($id)
    {
        /*
        $data=User::viewUserEssentialData($id);
        $data1=User::userArrivalCount($id);

        $obj_merged = (object) array_merge(
            (array) $data, (array) $data1);
        */
        echo json_encode(User::essentialUserData($id));

    }
}