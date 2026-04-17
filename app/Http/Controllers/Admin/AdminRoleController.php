<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminRole;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminRoleController extends Controller
{
    private $permissions = [
        'manage_users' => 'Gerenciar Usuários (Visualizar, Bloquear, Ajustar Saldo)',
        'manage_content' => 'Gerenciar Conteúdo (Posts, Lives, Presentes)',
        'manage_finance' => 'Gerenciar Financeiro (Saques, Depósitos)',
        'manage_support' => 'Gerenciar Suporte (Tickets)',
        'manage_settings' => 'Gerenciar Configurações do Sistema',
        'manage_reports' => 'Visualizar Relatórios e Analytics',
        'manage_roles' => 'Gerenciar Funções e Permissões (Acesso Total)',
    ];

    public function index()
    {
        $roles = AdminRole::withCount('users')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = $this->permissions;
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'required|array',
        ]);

        AdminRole::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'permissions' => $request->permissions,
        ]);

        return redirect()->route('admin.roles')->with('success', 'Função criada com sucesso!');
    }

    public function edit(AdminRole $role)
    {
        $permissions = $this->permissions;
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, AdminRole $role)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'required|array',
        ]);

        $role->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'permissions' => $request->permissions,
        ]);

        return redirect()->route('admin.roles')->with('success', 'Função atualizada com sucesso!');
    }

    public function destroy(AdminRole $role)
    {
        if ($role->users()->count() > 0) {
            return back()->with('error', 'Não é possível excluir uma função que possui usuários vinculados.');
        }

        $role->delete();
        return redirect()->route('admin.roles')->with('success', 'Função excluída com sucesso!');
    }
}
