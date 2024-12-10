<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterControllers extends Controller
{
    public function getGroupData($examId) {
        // Data dummy untuk grup
        $groups = [
            ['id' => 1, 'name' => 'Group A'],
            ['id' => 2, 'name' => 'Group B'],
            ['id' => 3, 'name' => 'Group C'],
        ];

        // Data dummy untuk grup yang sudah dipilih
        $selectedGroups = [1, 3]; // Grup yang dipilih (Group A & Group C)

        return response()->json([
            'groups' => $groups,
            'selected_groups' => $selectedGroups,
        ]);
    }

    public function getExceptUsers($examId) {
        // Data dummy untuk pengguna
        $users = [
            ['id' => 1, 'name' => 'Alice'],
            ['id' => 2, 'name' => 'Bob'],
            ['id' => 3, 'name' => 'Charlie'],
            ['id' => 4, 'name' => 'Diana'],
        ];

        // Data dummy untuk pengguna yang dikecualikan
        $selectedUsers = [2, 4]; // Bob dan Diana dikecualikan

        return response()->json([
            'users' => $users,
            'selected_users' => $selectedUsers,
        ]);
    }
}


